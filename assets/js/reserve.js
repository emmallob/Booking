const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 6000,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$(`div[id="layoutAuthentication"] div[id="validateTicket"]`).length ? $(`input[name="event_ticket"]`).focus() : null;

$(`div[id="layoutAuthentication"] div[class~="event-selector"]`).on('click', function() {
    let event_guid = $(this).attr("data-event-guid"),
        event_halls_guid = $(this).attr("data-url");
    $(`div[id="eventDialogModal"] input[name="event_guid"]`).val(event_guid);
    $(`div[id="eventDialogModal"] input[name="event_halls_guid"]`).val(event_halls_guid);
    $(`div[id="eventDialogModal"]`).modal("show");
});

$(`div[id="layoutAuthentication"] div[id="eventDialogModal"] button[type="submit"]`).on("click", function() {
    var event_halls_guid = $(`input[name="event_halls_guid"]`).val();
    $.post(`${baseUrl}auth/reserve/`, { payload: $(`input[name="contact_number"]`).val() }, function(response) {
        if (response.status == 200) {
            window.location.href = `${event_halls_guid}`;
        } else {
            Toast.fire({
                title: "Please enter a valid contact number",
                type: "error"
            });
            $(`input[name="contact_number"]`).focus();
        }
    }, 'json');
});

function remove(array) {
    var what, a = arguments,
        L = a.length,
        ax;
    while (L > 1 && array.length) {
        what = a[--L];
        while ((ax = array.indexOf(what)) !== -1) {
            array.splice(ax, 1);
        }
    }
    return array;
}

function appendToArray(itemLabel) {

    let label = $(`div[class~="seats-table"] table td[data-label="${itemLabel}"] span[data-label="${itemLabel}"]`).html();

    let seatForm = `
        <div data-seat="${itemLabel}" class="mb-2">
            <p class="mb-0"><strong>Seat:</strong> ${label}</p>
            <div class="form-group mb-1">
                <input type="text" required data-seat-id="${itemLabel}" placeholder="Fullname *" name="fullname" id="fullname" class="form-control">
            </div>
            <div class="form-group mb-1">
                <input type="text" required data-seat-id="${itemLabel}" name="phone_number" id="phone_number" placeholder="Contact Number *" class="form-control">
            </div>
            <div class="form-group mb-1">
                <input type="text" data-seat-id="${itemLabel}" placeholder="House Address / GhanaPostGPS" name="address" id="address" class="form-control">
            </div>
        </div>`;

    if ($.inArray(itemLabel, bookingSelectedItems) !== -1) {
        $(`div[id="layoutAuthentication"] div[class~="seats-table"] table tr td div[data-label="${itemLabel}"]`).removeClass("selected");
        $(`div[class~="selected-seats"] div[class~="selected-seats-content"] div[data-seat="${itemLabel}"]`).remove();
        remove(bookingSelectedItems, itemLabel);
        $(`div[class~="selected-seats"] h4 span`).html(bookingSelectedItems.length);

        (bookingSelectedItems.length) ? $(`button[class~="reserve-seat"]`).removeClass('hidden'): $(`button[class~="reserve-seat"]`).addClass('hidden');

        return false;
    }
    if (bookingSelectedItems.length == maximumBooking) {
        return false;
    }

    bookingSelectedItems.push(itemLabel);
    (bookingSelectedItems.length) ? $(`button[class~="reserve-seat"]`).removeClass('hidden'): $(`button[class~="reserve-seat"]`).addClass('hidden');
    $(`div[class~="selected-seats"] h4 span`).html(bookingSelectedItems.length);
    $(`div[class~="selected-seats"] div[class~="selected-seats-content"]`).append(seatForm);
    $(`div[id="layoutAuthentication"] div[class~="seats-table"] table tr td div[data-label="${itemLabel}"]`).addClass("selected");
}

$(`div[id="layoutAuthentication"] div[class~="seats-table"] table tr td div`).on("click", function() {
    let item = $(this);
    if (!item.hasClass("unavailable")) {
        appendToArray(item.data("label"));
    }
});

$(`button[class~="reserve-seat"]`).on("click", function() {
    var booking_details = [];
    $.each($(`div[class~="selected-seats"] div[class~="selected-seats-content"] div[data-seat]`), function(i, e) {
        let seatLabel = $(this).attr("data-seat"),
            seatAddress = $(`input[name="address"][data-seat-id="${seatLabel}"]`).val(),
            seatPhone = $(`input[name="phone_number"][data-seat-id="${seatLabel}"]`).val(),
            seatFullname = $(`input[name="fullname"][data-seat-id="${seatLabel}"]`).val();

        booking_details.push(`${seatLabel}||${seatFullname}||${seatPhone}||${seatAddress}`);

    });

    $.post(`${baseUrl}api/reservations/reserve`, { booking_details, event_guid, hall_guid, hall_guid_key }, function(response) {
        Toast.fire({
            title: response.data.result,
            type: (response.code == 200) ? "success" : "error"
        });
    }, "json");
});