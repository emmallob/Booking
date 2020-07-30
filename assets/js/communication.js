(function($) {
    $.fn.smsArea = function(options) {

        var e = this,
            cutStrLength = 0,

            s = $.extend({

                cut: true,
                maxSmsNum: 3,
                interval: 0,

                counters: {
                    message: $('#smsCount'),
                    character: $('#smsLength')
                },

                lengths: {
                    ascii: [145, 306, 459],
                    unicode: [70, 134, 201]
                }
            }, options);


        e.keyup(function() {

            var smsType,
                smsLength = 0,
                smsCount = -1,
                charsLeft = 0,
                text = e.val(),
                isUnicode = false;

            for (var charPos = 0; charPos < text.length; charPos++) {
                switch (text[charPos]) {
                    case "\n":
                    case "[":
                    case "]":
                    case "\\":
                    case "^":
                    case "{":
                    case "}":
                    case "|":
                    case "€":
                        smsLength += 2;
                        break;
                    default:
                        smsLength += 1;
                }

                if (text.charCodeAt(charPos) > 127 && text[charPos] != "€")
                    isUnicode = true;
            }

            if (isUnicode) smsType = s.lengths.unicode;
            else smsType = s.lengths.ascii;

            for (var sCount = 0; sCount < s.maxSmsNum; sCount++) {

                cutStrLength = smsType[sCount];
                if (smsLength <= smsType[sCount]) {

                    smsCount = sCount + 1;
                    charsLeft = smsType[sCount] - smsLength;
                    break
                }
            }

            if (s.cut) e.val(text.substring(0, cutStrLength));
            smsCount == -1 && (smsCount = s.maxSmsNum, charsLeft = 0);

            if (smsLength > 0) {
                $(".cancel-message").removeClass("d-none");
                $(".type-message").removeClass("d-none");
            } else {
                $(".cancel-message").addClass("d-none");
                $(".type-message").addClass("d-none");
            }

            s.counters.message.html(smsCount);
            s.counters.character.html(charsLeft);
            calculateSMSUnitCost();

        }).keyup()
    }
}(jQuery));

$(function() {
    $('#smsText').smsArea({ maxSmsNum: 3 });
})

$(".select-rec-category").on("change", function() {

    var recipient = $(this).val();
    var msg_type = $(this).data("message-type");

    if (recipient == "null") {
        $(".show-recipient-cat").html('');
        return false;
    }

    $.ajax({
        url: `${baseUrl}api/sms/category?msg_type=${msg_type}&recipient=${recipient}`,
        type: "GET",
        dataType: "json",
        beforeSend: function() {
            $(".show-recipient-cat:visible").html(`<p class="text-center"><span class="fa fa-spin fa-spinner"></span></p>`);
        },
        success: function(response) {
            $(".show-recipient-cat:visible").html(response.data.result);
            if (msg_type == 'sms') {
                calculateSMSUnitCost();
                getMultiSelectValues();
            }
        },
        error: function() {
            $(".show-recipient-cat:visible").html(`<p class="text-center alert alert-danger">Error Occurred.</p>`);
            setTimeout(function() {
                $(".show-recipient-cat:visible").fadeOut(1200);
            }, 3000);
        },
        complete: function() {
            if ($(`[name="recipient-lists"]`).length) {
                $(`[name="recipient-lists"]`).select2();
            }
        }
    });

});

var loadMessageHistory = (contactId) => {

    let presetId = $(`span[class="current-viewer"]`).attr('data-contact-id');

    var messagesHistory;

    if (presetId.length > 5) {
        messagesHistory = $(`a[data-history-id='${presetId}']`).attr('data-history');
    } else {
        messagesHistory = $(`a[data-history-id='${contactId}']`).attr('data-history');
    }

    let jsonMessages = $.parseJSON(messagesHistory);

    var msgList = ``,
        status = ``;

    $.each(jsonMessages, function(i, e) {
        if (e.sms_status == 'sent') {
            status = `<span class="badge badge-success">Sent</span>`;
        } else if (e.sms_status == 'failed') {
            status = `<span class="badge badge-danger">Failed</span>`;
        } else if (e.sms_status == 'pending') {
            status = `<span class="badge badge-primary">Pending</span>`;
        }
        msgList += `
            <p style="margin-bottom: 5px">
	         	${e.message}<br>
	         	<strong>Date: </strong>${e.date_sent} | 
	         	<strong>Status: </strong>${status}
	        </p><br>`;
    });

    $(`div[class~="sms-message-sent"]`).html(msgList);
}

var loadBulkMessageHistory = (historyId) => {

    $(`div[class~="sms-message-sent"]`).html(``);

    let contactDetails = $(`a[data-bulk-history-id='${historyId}']`).attr('data-recipients-info');
    let messageContent = $(`a[data-bulk-history-id='${historyId}']`).attr('data-message');

    let jsonContacts = $.parseJSON(contactDetails);

    var msgList = ``,
        status = ``,
        sentList = ``;

    $.each(jsonContacts, function(i, e) {
        if (e.message_status == 'sent') {
            status = `<span class="badge badge-success">Sent</span>`;
        } else if (e.message_status == 'failed') {
            status = `<span class="badge badge-danger">Failed</span>`;
        } else if (e.message_status == 'pending') {
            status = `<span class="badge badge-primary">Pending</span>`;
        }
        sentList += `${e.fullname} (${e.contact}) ${status} | `;
    });

    $(`div[class~="sms-message-sent"]`).html(`
        <p class='border alert alert-info-soft m-2'>${sentList}</p>
        <hr class='pt-0 mt-0'>
        <p style="margin-bottom: 5px; padding: 10px">${messageContent}</p><br>
    `);
}

var checkSMSBalance = () => {
    if ($("#get-sms-balance").length) {
        $.ajax({
            url: `${baseUrl}api/sms/check-balance`,
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $("#get-sms-balance").html(`Loading balance &nbsp;<span class="fa fa-spin fa-spinner"></span>`);
            },
            success: function(response) {
                if (response.code == 200) {
                    $("#get-sms-balance").html(response.data.result.show_balance).attr("data-sms-balance", response.data.result.balance);
                } else {
                    $("#get-sms-balance").html('0 SMS Units');
                }
            },
            error: function() {
                $("#get-sms-balance").html(`Balance Error!`);
            }
        });
    }
}
checkSMSBalance();

var fetchHistoryOfSMS = () => {

    $.each(['.bulk-history-lists', '.single-history-lists'], function(key, value) {

        if ($(value).length) {
            var group = $(value).data("group");
            let display = $(value);
            $.ajax({
                url: `${baseUrl}api/sms/history?group=${group}`,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    display.html(`<p class="text-center"><span class="fa fa-spin fa-spinner"></span><br>Loading...</p>`);
                },
                success: function(response) {
                    if (response.code == 200) {
                        display.empty();
                        $.each(response.data.result, function(i, e) {

                            display.append(response.data.result[i].list);

                            $(`a[data-history-id='${response.data.result[i].recipients}']`, display).on("click", function() {
                                $(`span[class="current-viewer"]`).attr('data-contact-id', response.data.result[i].recipients);
                                $(".recipient-icon, .get-sms-detail").removeClass("d-none");
                                $(".chat-recipient-title").html(response.data.result[i].recipientName);
                                $(`[name="selectedrecipients"]`).val(response.data.result[i].recipients);
                                $(`[name="messageDirection"]`).val("process_2");
                                $(`.read-message`).removeClass("d-none");
                                loadMessageHistory(i);
                            });

                            $(`a[data-bulk-history-id='${i}']`, display).on("click", function() {
                                $(`div[class~="sms-message-sent"]`).html(``);
                                $(`span[class="current-viewer"]`).attr('data-contact-id', response.data.result[i].category);
                                $(".recipient-icon, .get-sms-detail").removeClass("d-none");
                                $(".chat-recipient-title").html(response.data.result[i].recipientName);
                                $(`p[class~="chat-date"]`).html(response.data.result[i].full_date);
                                $(`[name="selectedrecipients"]`).val(response.data.result[i].recipients);
                                $(`[name="messageDirection"]`).val("process_1");
                                $(`.read-message`).removeClass("d-none");
                                $(".select-rec-category").val('null').change();
                                loadBulkMessageHistory(i);
                            });
                        });
                    } else {
                        display.html(`<p class='text-center'><em>No records found</em></p>`);
                    }
                },
                error: function() {
                    display.html(`
                        <p class="text-center">
                            Error Processing Request
                        </p>
                    `);
                },
                complete: function() {}
            });

        }
    });
}
fetchHistoryOfSMS();

var calculateSMSUnitCost = () => {
    if ($("#showSMSCost").length) {
        var totalCost = 0;
        var unit = $("#smsCount").html();
        var totalContact = 0;
        if ($(`[name="messageDirection"]`).val() == "process_1") {
            if ($(".append-lists").length) {
                totalContact = $(".append-lists").data("total-contacts");
            } else if ($(`[name="recipient-lists"]`).length) {
                totalContact = $(`[name="recipient-lists"]`).val();
                totalContact = totalContact.length;
            }
        } else {
            if ($(`[name="selectedrecipients"]`).val().length) {
                totalContact = $(`[name="selectedrecipients"]`).val().split(",").length;
            }
        }
        totalCost = (totalContact > 0 && unit > 0) ? (totalContact * unit) : 0;
        if (totalCost > $("[data-sms-balance]").data("sms-balance")) {
            $(".send-message:visible").attr("disabled", "disabled");
        } else {
            $(".send-message:visible").prop("disabled", false);
        }
        $("#showSMSCost").html(totalCost + " Unit(s)");
    }
}
calculateSMSUnitCost();

var getMultiSelectValues = () => {
    $(`select[name="recipient-lists"] > option`).on('click', function(e) {
        calculateSMSUnitCost();
    });
}

$(".top-up-sms").on("click", function(e) {
    $(`[id="topupFormModal"]`).modal("show");
});

var smsCalculate = () => {
    $(`form[id="topup-form"] input[name="topup-amount"]`).on('input', function() {
        let amount = parseInt($(this).val());
        if (amount > 1000) {
            $(this).val(1000);
        }
        let smsunit = (amount * 50) / 10
        if (!isNaN(smsunit)) {
            $(`form[id="topup-form"] input[name="topup-unit"]`).val(smsunit);
        } else {
            $(`form[id="topup-form"] input[name="topup-unit"]`).val(0);
        }
    });
    $(`form[id="topup-form"] button[type="submit"]`).on("click", function() {
        let amount = parseInt($(`form[id="topup-form"] input[name="topup-amount"]`).val());

        if (isNaN(amount) || amount == 0) {
            Toast.fire({
                'title': 'Sorry! Please enter an amount',
                'type': 'error'
            });
        } else {
            $(`form div[class="form-content-loader"]`).css("display", "flex");

            var payload = '{"amount":"' + amount + '"}';

            $.ajax({
                type: `POST`,
                url: `${baseUrl}api/sms/topup`,
                data: payload,
                dataType: 'json',
                success: function(response) {
                    Toast.fire({
                        'title': response.data.result,
                        'type': responseCode(response.code)
                    });

                    if (response.code == 200) {
                        $(`form[id="topup-form"] input[name="topup-amount"]`).val(0);
                        $(`form[id="topup-form"] input[name="topup-unit"]`).val(0);
                        $(`.launchModal`).modal("hide");
                    }
                },
                complete: function() {
                    $(`form div[class="form-content-loader"]`).css("display", "none");
                },
                error: function() {
                    Toast.fire({
                        'title': 'Sorry! There was an error while processing the request.',
                        'type': 'error'
                    });
                    $(`form div[class="form-content-loader"]`).css("display", "none");
                }
            }).catch(() => {
                $(`form div[class="form-content-loader"]`).css("display", "none");
            })
        }
    });
}
smsCalculate();

$("button[class~='cancel-message']").on("click", function(e) {
    $("#smsText").val("");
    $("button[class~='cancel-message']").addClass("d-none");
    $(".type-message").addClass("d-none");
    $(`[id="smsLength"]`).html(145)
});

$(`button[class~="send-message"]`).on("click", function() {
    $(`div[id="sendMessageModal"]`).modal('show');
});

$("#general_chat, #single_chat").on("click", function(e) {
    e.preventDefault();
    // $(`[name="messageDirection"]`).val("process_2");
});

$(`a[id="group_chat_tab"]`).on('click', function() {
    $(`div[class~="sms-message-sent"]`).html(``);
    $(".chat-recipient-title").html(``);
    $(`span[class="current-viewer"]`).attr('data-contact-id', null);
    $(".recipient-icon, .get-sms-detail").addClass("d-none");
});

$("#compose").on("click", function(e) {
    $(`[name="messageDirection"]`).val("process_1");
    $(".read-message, .recipient-icon").addClass("d-none");
    $(".sms-message-sent").empty();
});

var sendBulkMessage = () => {

    $(`div[id="sendMessageModal"] button[type="submit"]`).on("click", function(e) {
        e.preventDefault();

        // Get Message Direction
        var recipients = "",
            additional_data = "",
            category = "unknown",
            msgDirection = $(`input[name="messageDirection"]`).val(),
            smsMsg = $(`textarea[name="directMessage"]`).val(),
            unit = $("#smsCount").html();

        var category = $(`select[name="recipientCategory"]`).val();

        if (msgDirection == "process_1") {

            if ($(`span[class="current-viewer"]`).attr('data-contact-id')) {
                category = $(`span[class="current-viewer"]`).attr('data-contact-id');
            }

            if (category == "specificEvent") {
                recipients = $(`select[name="recipient-lists"]`).val();

                recipients = recipients == undefined ? $(`[name="selectedrecipients"]`).val() : recipients;

                $('input[name^="category_list"]').each(function() {
                    additional_data += $(this).val() + ",";
                });
            }

        } else if (msgDirection == "process_2") {
            recipients = $(`[name="selectedrecipients"]`).val();
        }

        let payload = `{"message":"${smsMsg}","unit":"${unit}","recipients":"${recipients}","category":"${category}","data":"${additional_data}"}`;

        $.ajax({
            url: baseUrl + "api/sms/send",
            type: "POST",
            data: payload,
            dataType: "json",
            beforeSend: function() {
                $(".content-loader").css("display", "flex");
            },
            success: function(response) {
                if (response.code == 200) {
                    Toast.fire({
                        type: "success",
                        title: response.data.result.result
                    });
                    $(`[id="smsLength"]`).html(145);
                    $(`div[id="sendMessageModal"]`).modal('hide');
                    $(`textarea[name="directMessage"]`).val("");
                    $(`[name="recipientCategory"]`).val("null").change();

                    checkSMSBalance();
                    fetchHistoryOfSMS();
                    setTimeout(function() {
                        loadMessageHistory(response.data.result.recipient_id);
                    }, 2000);
                } else {
                    Toast.fire({
                        type: "error",
                        title: response.data.result
                    });
                }
            },
            error: function() {
                Toast.fire({
                    type: "error",
                    title: "An error occured while trying to send the message"
                });
                $(".content-loader").css("display", "none");
            },
            complete: function() {
                $(".content-loader").css("display", "none");
            }
        });

    });

}
sendBulkMessage();

var populateTopupList = (data) => {
    $(`table[class~="smsTopupList"]`).dataTable().fnDestroy();
    $(`table[class~="smsTopupList"]`).dataTable({
        "aaData": data,
        "iDisplayLength": 10,
        "columns": [
            { "data": 'row_id' },
            { "data": 'request_date' },
            { "data": 'request_by' },
            { "data": 'amount' },
            { "data": 'smsunit' },
            { "data": 'status' },
            { "data": 'action' }
        ]
    });
    $(`table th:last`).removeClass('sorting');
    deleteItem();
    $(`div[class="form-content-loader"]`).css("display", "none");
}

async function fetchTopupList() {
    if ($(`table[class~="smsTopupList"]`).length) {
        $.ajax({
            url: baseUrl + "apis/sms/topup-list",
            type: "GET",
            dataType: "json",
            success: function(response) {
                populateTopupList(response.data.result);
            },
            error: function() {},
            complete: function() {}
        });
    }
}
fetchTopupList();