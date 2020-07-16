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

var serealizeSelects = (select) => {
    var array = [];
    select.each(function() {
        array.push($(this).val())
    });
    return array;
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

var pushIntoOptions = async(selectField, dataSet, selectTitle) => {
    $(`select[name="${selectField}"]`).find('option').remove().end();
    $(`select[name="${selectField}"]`).append(`<option value="">${selectTitle}</option>`);
    $.each(dataSet, function(val, text) {
        $(`select[name="${selectField}"]`).append('<option value=' + text.guid + '>' + text.title + '</option>');
    });
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
    value == 0 ? $(`select[name="ticket_guid"]`).parents(`div[class~="cards"]:first`).addClass("hidden") : $(`select[name="ticket_guid"]`).parents(`div[class~="cards"]:first`).removeClass("hidden");
    $(`select[class~="selectpicker2"]`).select2();
});

$(`select[name="multiple_booking"]`).on('change', function() {
    let value = $(this).val();
    value == 0 ? $(`input[name="maximum_booking"]`).val(1).parents(`div[class~="cards"]:first`).addClass("hidden") : $(`input[name="maximum_booking"]`).parents(`div[class~="cards"]:first`).removeClass("hidden");
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

$(`div[class~="seats-table"] table tr td div`).on("click", function() {
    let item = $(this);
    item.toggleClass("selected");
    $(`input[data-label="${item.data("label")}"]`).focus();

    if (item.hasClass("blocked")) {
        item.addClass("blocked-border");
        curBlockedItems.push(item.data("label"));
        blockedItems.push(item.data("label"));
        $(`button[type="unblock"]`).removeClass("hidden");
    }
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
        if ($.inArray($(this).data("label"), curBlockedItems) !== -1) {
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] div`)
                .removeClass('selected hidden blocked blocked-border')
                .prop({ "title": "" });
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] input[data-label="${$(this).data("label")}"]`)
                .prop({ "disabled": false });
            remove(curBlockedItems, $(this).data("label"));
            remove(blockedItems, $(this).data("label"));
        }
    });
    $(`button[type="unblock"]`).addClass("hidden");
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
                .removeClass('selected blocked-border')
                .addClass(`blocked`)
                .prop({ "title": "Blocked Seat" });
            $(`div[class~="seats-table"] table tr td[data-label="${$(this).data("label")}"] input[data-label="${$(this).data("label")}"]`)
                .prop({ "disabled": true });
            blockedItems.push($(this).data("label"));
        }
    });
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
        $(this).attr("data-title") != undefined ? $(`div[id="deleteModal"] [class="modal-header"] h5`).html($(this).attr("data-title")) : $(`div[id="deleteModal"] [class="modal-header"] h5`).html("Delete Item")
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

var activateItem = () => {
    $(`div[id="layoutSidenav_content"]`).on("click", `a[class~="activate-item"]`, function() {
        let url = $(this).attr("data-url"),
            guid = $(this).attr("data-guid"),
            redirect = $(this).attr("data-redirect"),
            item = $(this).attr("data-item");

        var payload = `{"${item}":"${guid}"}`;
        $.post(`${baseUrl}${url}`, payload, function(response) {
            if (response.code == 200) {
                Toast.fire({
                    title: response.data.result,
                    type: "success"
                });
                setTimeout(() => {
                    window.location.href = `${baseUrl}${redirect}`;
                }, 1000);
            }
        }, 'json');
    });
}

$("form[class~='appForm']").on("submit", function(e) {
    e.preventDefault();

    if ($(`table[class~="usersAccounts"]`).length) {
        payload = $("form[class~='appForm']").serialize();
    } else {

        data = $("form[class~='appForm']").formToJson();

        if ($(`select[name="halls_guid"]`).length) {
            data.halls_guid = serealizeSelects($(`select[name="halls_guid"]`));
            console.log(data);
        }

        payload = JSON.stringify(data);
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

            if (response.data.additional) {
                let count = 0,
                    table = "<table class='table'>";
                $.each(response.data.additional.list, function(i, e) {
                    count++;
                    table += `<tr><td>${count}</td><td>${e}</td></tr>`;
                });
                table += `</table>`;
                table += `<div class="text-center"><a data-url="${response.data.additional.url}" data-redirect="${response.data.additional.redirect}" data-item="${response.data.additional.item}" data-guid="${response.data.additional.guid}" href='javascript:void(0)' class="btn btn-outline-success activate-item">Activate</a></div>`;

                $(`div[class~="sample-data"]`).html(table);

                $(`form[class~="appForm"] button[type="submit"]`).remove();
            }
        },
        error: function(err) {
            $(`div[class="form-content-loader"]`).css("display", "none");
            setTimeout(() => {
                $(`form[class~="appForm"] button[type="submit"]`).prop("disabled", false);
            }, 1000);
            Toast.fire({
                title: "Sorry! An error was encountered while processing the request.",
                type: "error"
            });
        },
        complete: function(data) {
            activateItem();
            $(`div[class="form-content-loader"]`).css("display", "none");
            setTimeout(() => {
                $(`form[class~="appForm"] button[type="submit"]`).prop("disabled", false);
            }, 1000);
        }
    }).catch((err) => {
        $(`div[class="form-content-loader"]`).css("display", "none");
        setTimeout(() => {
            $(`form[class~="appForm"] button[type="submit"]`).prop("disabled", false);
        }, 1000);
    });
});

var populateHallsList = (data) => {
    if ($(`table[class~="listHalls"]`).length) {
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
        activateItem();
    } else if ($(`select[name="halls_guid"]`).length) {
        pushIntoOptions("halls_guid", data, "Select Halls for this Event");
    }

}
async function listHalls() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    $.ajax({
        url: `${baseUrl}api/halls/list`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.code == 200) {
                populateHallsList(response.data.result);
            } else {
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        },
        complete: function() {}
    });
}
if ($(`table[class~="listHalls"], div[id="eventsManager"] select[name="halls_guid"]`).length) {
    listHalls();
}

var populateDepartmentsList = (data) => {

    if ($(`table[class~="departmentsList"]`).length) {

        $(`table[class~="departmentsList"]`).dataTable().fnDestroy();
        $(`table[class~="departmentsList"]`).dataTable({
            "aaData": data,
            "iDisplayLength": 10,
            "columns": [
                { "data": 'row_id' },
                { "data": 'department_name' },
                { "data": 'description' },
                { "data": 'pending_events' },
                { "data": 'no_of_events' },
                { "data": 'action' }
            ]
        });
        $(`table th:last`).removeClass('sorting');
        deleteItem();
    } else if ($(`select[name="department_guid"]`).length) {
        pushIntoOptions("department_guid", data, "Select Department or Group or Organization");
    }
    $(`div[class="form-content-loader"]`).css("display", "none");
}
async function departmentsList() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    $.ajax({
        url: `${baseUrl}api/departments/list`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.code == 200) {
                populateDepartmentsList(response.data.result);
            } else {
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        },
        complete: function() {}
    });
}
if ($(`table[class~="departmentsList"], div[id="eventsManager"] select[name="department_guid"]`).length) {
    departmentsList();
}

var populateTicketsList = (data) => {
    if ($(`table[class~="ticketsList"]`).length) {
        $(`table[class~="ticketsList"]`).dataTable().fnDestroy();
        $(`table[class~="ticketsList"]`).dataTable({
            "aaData": data,
            "iDisplayLength": 10,
            "columns": [
                { "data": 'row_id' },
                { "data": 'ticket_title' },
                { "data": 'number_generated' },
                { "data": 'number_sold' },
                { "data": 'number_left' },
                { "data": 'number_used' },
                { "data": 'action' }
            ]
        });
        $(`table th:last`).removeClass('sorting');
        deleteItem();
        activateItem();
    } else if ($(`select[name="ticket_guid"]`).length) {
        pushIntoOptions("ticket_guid", data, "Select Event Ticket");
    }
    $(`div[class="form-content-loader"]`).css("display", "none");
}
async function ticketsList() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    $.ajax({
        url: `${baseUrl}api/tickets/list`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.code == 200) {
                populateTicketsList(response.data.result);
            } else {
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        },
        complete: function() {}
    });
}
if ($(`table[class~="ticketsList"], div[id="eventsManager"] select[name="ticket_guid"]`).length) {
    ticketsList();
}

var populateEventsList = (data) => {
    if ($(`table[class~="eventsList"]`).length) {
        $(`table[class~="eventsList"]`).dataTable().fnDestroy();
        $(`table[class~="eventsList"]`).dataTable({
            "aaData": data,
            "iDisplayLength": 10,
            "columns": [
                { "data": 'row_id' },
                { "data": 'event_title' },
                { "data": 'event_date' },
                { "data": 'event_details' },
                { "data": 'booked_count' },
                { "data": 'seats' },
                { "data": 'status' },
                { "data": 'action' }
            ]
        });
        $(`table th:last`).removeClass('sorting');
        deleteItem();
        activateItem();
    }
    $(`div[class="form-content-loader"]`).css("display", "none");
}
async function eventsList() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    $.ajax({
        url: `${baseUrl}api/events/list`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.code == 200) {
                populateEventsList(response.data.result);
            } else {
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        },
        complete: function() {}
    });
}
if ($(`table[class~="eventsList"]`).length) {
    eventsList();
}

var populateBookedEventsList = (data) => {
    if ($(`table[class~="bookedEventList"]`).length) {
        $(`table[class~="bookedEventList"]`).dataTable().fnDestroy();
        $(`table[class~="bookedEventList"]`).dataTable({
            "aaData": data.booking_list,
            "iDisplayLength": 10,
            "columns": [
                { "data": 'row_id' },
                { "data": 'hall_name' },
                { "data": 'fullname' },
                { "data": 'contact' },
                { "data": 'address' },
                { "data": 'seat_name' },
                { "data": 'action' }
            ]
        });
        $(`table th:last`).removeClass('sorting');

        $(`input[name="event_title"]`).val(data.detail.event_title).prop("disabled", true);
        $(`input[name="event_date"]`).val(data.detail.event_date).prop("disabled", true);
        $(`input[name="event_time"]`).val(`${data.detail.start_time} to ${data.detail.end_time}`).prop("disabled", true);
        deleteItem();
    }
    $(`div[class="form-content-loader"]`).css("display", "none");
}
async function bookedEventList() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    let event_guid = $(`div[class~="event-guid"]`).attr("data-event-guid");

    $.ajax({
        url: `${baseUrl}api/insight/report?event_guid=${event_guid}&tree=detail,list`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.code == 200) {
                populateBookedEventsList(response.data.result.data[0]);
            } else {
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        },
        complete: function() {}
    });
}
if ($(`table[class~="bookedEventList"]`).length) {
    bookedEventList();
}

async function eventsChart() {
    $(`div[class="form-content-loader"]`).css("display", "flex");
    let event_guid = $(`div[class~="event-guid"]`).attr("data-event-guid");

    $.ajax({
        url: `${baseUrl}api/insight/report?tree=booking_count,overall_summary&order=desc`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.code == 200) {
                let chartLabel = new Array(),
                    bookingCount = new Array(),
                    confirmedCount = new Array();

                $.each(response.data.result.data, function(i, e) {
                    chartLabel.push(e.booking_count.event_title);
                    bookingCount.push(e.booking_count.booked_count);
                    confirmedCount.push(e.booking_count.confirmed_count);
                });

                // Area Chart Example
                var ctx = document.getElementById("myAreaChart");
                var myLineChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: chartLabel,
                        datasets: [{
                            label: "Total Booked",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 97, 242, 0.05)",
                            borderColor: "rgba(0, 97, 242, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(0, 97, 242, 1)",
                            pointBorderColor: "rgba(0, 97, 242, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(0, 97, 242, 1)",
                            pointHoverBorderColor: "rgba(0, 97, 242, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: bookingCount
                        }, {
                            label: "Total Confirmed",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 77, 242, 0.05)",
                            borderColor: "#6900c7",
                            pointRadius: 3,
                            pointBackgroundColor: "#6900c7",
                            pointBorderColor: "#6900c7",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#6900c7",
                            pointHoverBorderColor: "#6900c7",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: confirmedCount
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                });

                $.each(response.data.result.overall_summary, function(i, e) {
                    $(`div[data-count="${i}"]`).html(e);
                });
            } else {
                $(`div[class="form-content-loader"]`).css("display", "none");
            }
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        },
        complete: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        }
    });
}
if ($(`canvas[id="myAreaChart"`).length) {
    eventsChart();
}