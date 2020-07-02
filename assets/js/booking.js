var current_url = $("#current_url").attr('value');

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
    $.post(`${baseUrl}auth/logout`, function(response) {
        if (response.status == 203) {
            Cookies.set(`dashboard_notice`, 'false');
            Toast.fire({
                title: "You have successfully been logged out",
                type: "success"
            });
            setTimeout(() => {
                window.location.href = `${baseUrl}login`;
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

$(`div[class~="hall-configuration"] button[type="submit"]`).on('click', function(i, e) {

    let availableSeats = {};
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if (!$(this).hasClass("hidden")) {
            let label = $(this).data("label");
            let value = $(`input[data-label="${$(this).data("label")}"]`).val();
            availableSeats[label] = value;
        }
    });

    $(`button[type="restore"]`).addClass("hidden");
    $(`button[type="unblock"]`).addClass("hidden");

    var formData = {
        'hall_guid': $(`input[name="hall_guid"]`).val(),
        'available_seats': availableSeats,
        'blocked_seats': blockedItems,
        'removed_seats': hiddenItems,
    };

    $(`div[class="form-content-loader"]`).css("display", "flex");
    $.post(`${baseUrl}api/halls/configure`, formData, function(response) {
        Toast.fire({
            title: response.data.result,
            type: responseCode(response.code)
        });
        if (response.code == 200) {
            hiddenItems = [];
            blockedItems = [];
            $(`button[type="restore"]`).addClass("hidden");
            $(`button[type="unblock"]`).addClass("hidden");
        }
        $(`div[class="form-content-loader"]`).css("display", "none");
    }, "json").catch(() => {
        $(`div[class="form-content-loader"]`).css("display", "none");
    });

});

$(`div[class~="hall-configuration"] button[type="restore"]`).on('click', function(i, e) {
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if ($.inArray($(this).data("label"), hiddenItems) !== -1) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`).removeClass('selected hidden');
            remove(hiddenItems, $(this).data("label"));
        }
    });
    showButton("restore");
});

$(`div[class~="hall-configuration"] button[type="unblock"]`).on('click', function(i, e) {
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

$(`div[class~="hall-configuration"] button[type="remove"]`).on('click', function(i, e) {
    $.each($(`div[class~="seats-table"] table tr td div`), function(i, e) {
        if ($(this).hasClass("selected")) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`).removeClass('selected').addClass(`hidden`);
            hiddenItems.push($(this).data("label"));
        }
    });
    showButton("restore");
});

$(`div[class~="hall-configuration"] button[type="block"]`).on('click', function(i, e) {
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

$(`div[id="layoutSidenav_content"]`).on("click", `button[class~="reset-hall"]`, function() {
    if (confirm("Are you sure you want to proceed with this action?")) {
        var hall_guid = $(this).attr('data-item-id'),
            payload = '{"hall_guid":"' + hall_guid + '"}';
        $.post(`${baseUrl}api/halls/reset`, payload, function(response) {
            if (response.code == 200) {
                Toast.fire({
                    title: response.data.result,
                    type: "success"
                });
                setTimeout(() => {
                    window.location.href = `${baseUrl}halls-configuration/${hall_guid}`;
                }, 1000);
            }
        }, 'json');
    }
});

function confirmDelete() {
    $(`div[id="deleteModal"] button[type="submit"]`).on("click", function() {
        var payload = '{"item":"' + $(this).attr('data-item') + '","item_id":"' + $(this).attr('data-item-id') + '"}';
        $.ajax({
            type: "DELETE",
            url: `${baseUrl}api/remove/confirm`,
            data: payload,
            dataType: "json",
            success: function(response) {
                Toast.fire({
                    title: response.data.result,
                    type: responseCode(response.code)
                });

                if (response.code == 200) {
                    setTimeout((res) => {
                        window.location.href = current_url;
                    }, 1000);
                }
            },
            complete: function() {
                $(`div[id="deleteModal"]`).modal("hide");
                $(`div[class="form-content-loader"]`).css("display", "none");
            },
            error: function() {
                $(`div[id="deleteModal"]`).modal("hide");
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        });
    });
}

function deleteItem() {
    $(`div[id="layoutSidenav_content"]`).on('click', `a[class~="delete-item"]`, function(evt) {
        var item = $(this).attr('data-item');
        var itemId = $(this).attr('data-item-id');
        $(`div[id="deleteModal"]`).modal("show");
        $(`div[id="deleteModal"] button[type="submit"]`).attr({ "data-item": item, "data-item-id": itemId });
    });
}
confirmDelete();

function clear() {
    $(`form[class~='appForm'] input, form[class~='appForm'] textarea`).val('');
    $(`form[class~='appForm'] select`).val('null').change();
    $(`div[id="newModalWindow"]`).modal('hide');
}

$("form[class~='appForm']").on("submit", function(e) {
    e.preventDefault();

    if ($(`table[class~="usersAccounts"]`).length) {
        payload = $("form[class~='appForm']").serialize();
    } else {
        payload = JSON.stringify($("form[class~='appForm']").formToJson());
    }

    $(`div[class="form-content-loader"]`).css("display", "flex");
    $(`form[class~='appForm'] button[type="submit"]`).prop("disabled", true);

    $.ajax({
        type: $(`form[class~='appForm']`).attr('method'),
        url: $(`form[class~='appForm']`).attr('action'),
        data: payload,
        dataType: 'json',
        success: function(response) {
            Toast.fire({
                title: response.data.result,
                type: responseCode(response.code)
            });

            if (response.data.remote_request) {
                if (response.data.remote_request.function) {
                    eval(response.data.remote_request.function);
                }
                if (response.data.remote_request.clear) {
                    clear();
                }
                if (response.data.remote_request.reload) {
                    $(`form[class~='appForm'] input, form[class~='appForm'] textarea`).val('');
                    $(`form[class~='appForm'] select`).val('null').change();
                    setTimeout(() => {
                        window.location.href = response.data.remote_request.href;
                    }, 2000);
                }
            }
        },
        error: function(err) {
            $(`div[class="form-content-loader"]`).css("display", "none");
            $(`form[class~="appForm"] button[type="submit"]`).prop("disabled", false);
            Toast.fire({
                title: "Sorry! An error was encountered while processing the request.",
                type: "error"
            });
        },
        complete: function(data) {
            $(`div[class="form-content-loader"]`).css("display", "none");
            $(`form[class~="appForm"] button[type="submit"]`).prop("disabled", false);
        }
    }).catch((err) => {
        $(`div[class="form-content-loader"]`).css("display", "none");
    });
});

var activateHall = () => {
    $(`div[id="layoutSidenav_content"]`).on("click", `a[class~="activate-hall"]`, function() {
        var payload = '{"hall_guid":"' + $(this).attr('data-item-id') + '"}';
        $.post(`${baseUrl}api/halls/activate`, payload, function(response) {
            if (response.code == 200) {
                Toast.fire({
                    title: response.data.result,
                    type: "success"
                });
                setTimeout(() => {
                    window.location.href = `${baseUrl}halls`;
                }, 1000);
            }
        }, 'json');
    });
}

var populateHallsList = (data) => {
    $(`table[class~="listHalls"]`).dataTable().fnDestroy();
    $(`table[class~="listHalls"]`).dataTable({
        "aaData": data,
        "iDisplayLength": 10,
        "columns": [
            { "data": 'row_id' },
            { "data": 'hall_name' },
            { "data": 'rows' },
            { "data": 'columns' },
            { "data": 'seats' },
            { "data": 'description' },
            { "data": 'action' }
        ]
    });
    $(`table th:last`).removeClass('sorting');
    $(`div[class="form-content-loader"]`).css("display", "none");
    deleteItem();
    activateHall();
}
async function listHalls() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    $.ajax({
        url: `${baseUrl}api/halls/list`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            populateHallsList(response.data.result);
        },
        error: function() {},
        complete: function() {}
    });
}
if ($(`table[class~="listHalls"]`).length) {
    listHalls();
}