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

var loggedInUser = Cookies.get("loggedInUser");
(loggedInUser !== undefined) ? $(`span[class="loggedInUser"]`).html(loggedInUser): null;
$(`div[id="validateTicket"]`).length ? $(`input[name="event_ticket"]`).focus() : null;

$(`div[class~="event-selector"]`).on('click', function() {
    let event_guid = $(this).attr("data-event-guid"),
        event_halls_guid = $(this).attr("data-url");
    $(`div[id="eventDialogModal"] input[name="event_guid"]`).val(event_guid);
    $(`div[id="eventDialogModal"] input[name="event_halls_guid"]`).val(event_halls_guid);
    $(`div[id="eventDialogModal"]`).modal("show");
});

$(`div[id="eventDialogModal"] button[type="submit"]`).on("click", function() {
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