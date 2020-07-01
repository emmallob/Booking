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

var responseCode = (code) => {
    if (code == 200 || code == 201) {
        return "success";
    } else {
        return "error";
    }
}

var confirmNotice = (noticeName) => {
    let itemId = Cookies.get(`${noticeName}_notice`);
    if (itemId === 'true') {
        $(`div[data-notice="${noticeName}"]`)
            .removeClass(`alert alert-primary`)
            .html(``);
    }
}

var hideNotice = (noticeName) => {
    let itemId = Cookies.get(`${noticeName}_notice`);
    if (itemId == undefined) {
        Cookies.set(`${noticeName}_notice`, 'true');
    }
    $(`div[data-notice="${noticeName}"]`).html(``);
}

$(`a[class~="data-logout"]`).on("click", function() {
    $.post(`${baseUrl}api/users/logout`, function(response) {
        if (response.code == 200) {
            Cookies.set(`dashboard_notice`, 'false');
            Toast.fire({
                title: "You have successfully been logged out",
                type: "success"
            });
            setTimeout(() => {
                window.location.href = `${baseUrl}logout`;
            }, 1000);
        }
    }, 'json');
});

$(`span[data-notice="dashboard"]`).on('click', function() {
    hideNotice('dashboard');
});

$(`select[name="event_is_payable"]`).on('change', function() {
    let value = $(this).val();
    value == 0 ? $(`select[name="event_ticket"]`).parents(`div[class~="cards"]:first`).addClass("hidden") : $(`select[name="event_ticket"]`).parents(`div[class~="cards"]:first`).removeClass("hidden");
    $(`select[class~="selectpicker2"]`).select2();
});

$(`select[name="multiple_booking"]`).on('change', function() {
    let value = $(this).val();
    value == 0 ? $(`input[name="maximum_booking"]`).parents(`div[class~="cards"]:first`).addClass("hidden") : $(`input[name="maximum_booking"]`).parents(`div[class~="cards"]:first`).removeClass("hidden");
});

$(`select[name="ticket_is_payable"]`).on('change', function() {
    let value = $(this).val();
    value == 0 ? $(`input[name="ticket_amount"]`).parents(`div[class~="cards"]:first`).addClass("hidden") : $(`input[name="ticket_amount"]`).parents(`div[class~="cards"]:first`).removeClass("hidden");
});

$(`input[name="hall_columns"], input[name="hall_rows"]`).on('input', function() {
    let columns = $(`input[name="hall_columns"]`).val(),
        rows = $(`input[name="hall_rows"]`).val();

    columns = columns.length ? parseInt(columns) : 0;
    rows = rows.length ? parseInt(rows) : 0;

    let total = rows * columns;

    $(`input[id="temp_seats"]`).val(`${total} Seats`);
});

var hiddenItems = [];
var blockedItems = [];

$(`div[class~="seats-table"] table tr td div`).on("click", function() {
    $(this).toggleClass("selected");
    $(`input[data-label="${$(this).data("label")}"]`).focus();
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

$(`button[type="submit"]`).on('click', function(i, e) {
    let selectibles = {};
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if (!$(this).hasClass("hidden")) {
            let label = $(this).data("label");
            let value = $(`input[data-label="${$(this).data("label")}"]`).val();
            selectibles[label] = value;
        }
    });
    $(`button[type="restore"]`).addClass("hidden");
    $(`button[type="unblock"]`).addClass("hidden");
    console.log(selectibles)
    hiddenItems = [];
    blockedItems = [];
});

$(`button[type="restore"]`).on('click', function(i, e) {
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if ($.inArray($(this).data("label"), hiddenItems) !== -1) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`).removeClass('selected hidden');
            remove(hiddenItems, $(this).data("label"));
        }
    });
    showButton("restore");
});

$(`button[type="unblock"]`).on('click', function(i, e) {
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if ($.inArray($(this).data("label"), blockedItems) !== -1) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`)
                .removeClass('selected hidden blocked')
                .prop({ "title": "" });
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] input[data-label="${$(this).data("label")}"]`)
                .prop({ "disabled": false });
            remove(blockedItems, $(this).data("label"));
        }
    });
    showButton("unblock");
});

function showButton(btnName) {
    let arrayItem = btnName == "restore" ? hiddenItems : blockedItems;
    if (arrayItem.length) {
        $(`button[type="${btnName}"]`).removeClass("hidden");
    } else {
        $(`button[type="${btnName}"]`).addClass("hidden");
    }

}

$(`button[type="remove"]`).on('click', function(i, e) {
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if ($(this).hasClass("selected")) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`).removeClass('selected').addClass(`hidden`);
            hiddenItems.push($(this).data("label"));
        }
    });
    showButton("restore");
});

$(`button[type="block"]`).on('click', function(i, e) {
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if ($(this).hasClass("selected")) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`)
                .removeClass('selected')
                .addClass(`blocked`)
                .prop({ "title": "Blocked Seat" });
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] input[data-label="${$(this).data("label")}"]`)
                .prop({ "disabled": true });
            blockedItems.push($(this).data("label"));
        }
    });
    showButton("unblock");
});