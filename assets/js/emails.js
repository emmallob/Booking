$(function() {

    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("h1").text("Drag here");
    });

    $("html").on("drop", function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('.upload-area').on('dragenter', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    $('.upload-area').on('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    $('.upload-area').on('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();

        $("h1").text("Upload");

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('mail_attachment', file[0]);

        uploadData(fd);
    });

    $("#uploadfile").click(function() {
        $("#mail_attachment").click();
    });

    $("#mail_attachment").change(function() {
        var fd = new FormData();

        var files = $('#mail_attachment')[0].files[0];

        fd.append('mail_attachment', files);

        uploadData(fd);
    });

});

function temporaryAttachments() {
    $.ajax({
        url: `${baseUrl}api/emails/temp-attachments`,
        type: 'GET',
        dataType: 'json',
        success: function(resp) {
            $(`div[class~="email-attachments"]`).html(resp.data.result.files);
            $(`div[class="total-upload-size"]`).html(resp.data.result.total);
        },
        complete: function() {
            setTimeout(() => {
                removeItem();
            }, 500)
        }
    });
}
if ($(`div[class~="email-attachments"]`).length) {
    $(() => {
        temporaryAttachments();
    })
}

$(`button[class~="discard-mail"]`).on('click', function() {
    if (confirm("Are you sure you want to discard this message?")) {
        $.ajax({
            url: `${baseUrl}api/emails/discard`,
            type: 'post',
            data: { discardEmail: true },
            dataType: 'json',
            success: function(resp) {
                if (resp.code == 200) {
                    Toast.fire({
                        title: 'Message was successfully discarded',
                        type: 'success'
                    });
                    $(`div[class~="email-attachments"]`).html(``);
                    setTimeout(() => {
                        window.location.href = `${baseUrl}emails-list`;
                    }, 1000);
                }
            }
        });
    }
});

function removeItem() {
    $(`svg[class~="delete-document"]`).on('click', function() {
        let document_id = $(this).attr('data-value');

        let payload = `{"document_id":"${document_id}"}`;

        $.ajax({
            url: `${baseUrl}api/emails/remove-attachment`,
            type: 'post',
            data: payload,
            dataType: 'json',
            success: function(resp) {
                if (resp.code == 200) {
                    $(`div[data-value="${document_id}"]`).remove();
                    $(`div[class="total-upload-size"]`).html(resp.data.result.total);
                }
            }
        });
    });
}

function uploadData(formdata) {

    $.ajax({
        url: `${baseUrl}api/emails/attach`,
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $(`div[class="upload-area"] small`).html(`Uploading file <i class="fa fa-spin fa-spinner"></i>`);
        },
        success: function(resp) {
            if (resp.data.result.upload_status == 1) {
                $(`div[class="upload-area"] small`).html(`<span class="text-success"><i style="height: 1em;" class="fa fa-check-circle"></i> File uploaded successfully</span>`);
            } else if (resp.data.result.upload_status == 0) {
                $(`div[class="upload-area"] small`).html(`<span class="text-danger"><i style="height: 1em;" class="em em-warning"></i> File size exceeded</span>`);
            } else if (resp.data.result.upload_status == 2) {
                $(`div[class="upload-area"] small`).html(`<span class="text-danger"><i style="height: 1em;" class="em em-warning"></i> File type unacceptable (${resp.allowed_types})</span>`);
            }
        },
        complete: function(data) {
            temporaryAttachments();

            setTimeout(function() {
                $(`div[class="upload-area"] small`).html(``);
            }, 5000);
        },
        error: function(err) {
            $(`div[class="upload-area"] small`).html(`<span class="text-danger"><i style="height: 1em;" class="em em-warning"></i> Error uploading file</span>`);
        }
    });
}

$(`form[class="submitEmailForm"]`).on('submit', function(e) {
    e.preventDefault();
    let sender = $(`select[name="send_from"]`).val(),
        subject = $(`input[name="subject"]`).val(),
        recipients = $(`input[name="recipients"]`).val(),
        content = htmlEntities($(`textarea[data-editor="summernote"]`).val());

    let payload = `{"sender":"${sender}","subject":"${subject}","message":"${content}","recipients":"${recipients}"}`;

    $.ajax({
        type: "POST",
        url: `${baseUrl}api/emails/send`,
        data: payload,
        dataType: "json",
        beforeSend: function() {
            $(`form div[class="form-content-loader"]`).css("display", "flex");
            $(`form[class="submitEmailForm"] button[type="submit"]`).prop('disabled', true);
        },
        success: function(resp) {
            if (resp.code == 200) {
                $(`input[name="subject"]`).val('');
                $(`input[name="recipients"]`).val('');
                Toast.fire({
                    type: "success",
                    title: "Email message was successfully sent"
                });
                $(`form[class="submitEmailForm"] button[type="submit"]`).prop('disabled', false);
                $(`textarea[data-editor="summernote"]`).val('');
                temporaryAttachments();
                setTimeout(() => {
                    window.location.href = `${baseUrl}emails-list`;
                }, 2000);
            } else {
                $(`form[class="submitEmailForm"] button[type="submit"]`).prop('disabled', false);
                Toast.fire({
                    type: "error",
                    title: resp.data.result
                });
            }
        },
        complete: function(data) {
            $(`form div[class="form-content-loader"]`).css("display", "none");
        },
        error: function(err) {
            $(`form[class="submitEmailForm"] button[type="submit"]`).prop('disabled', false);
            $(`form div[class="form-content-loader"]`).css("display", "none");
            Toast.fire({
                type: "success",
                title: "Sorry! An error was encountered while trying to send the message."
            });
        }
    });

});

$(`button[class~="go-back"]`).on('click', function() {
    $(`div[class~="mails-listing"]`).removeClass('hidden');
    $(`div[class~="mails-content"]`).addClass('hidden');
    $(`button[class~="go-back"]`).addClass('hidden');
    $(`button[class~="delete-msg-button"]`)
        .prop('disabled', false)
        .css('cursor', 'pointer');
});

var showEmailContent = (messageId) => {

    $(`div[class="contact_details"]`).attr({ 'contact_id': null, 'message_id': null });

    $.ajax({
        url: `${baseUrl}api/emails/list?message_guid=${messageId}`,
        type: "GET",
        dataType: "JSON",
        success: function(resp) {

            if (resp.data.result.mailsCount) {

                $(`button[class~="go-back"]`).removeClass('hidden');
                $(`div[class~="mails-listing"]`).addClass('hidden');
                $(`div[class~="mails-content"]`).removeClass('hidden');
                $(`span[class="active-msg"]`).attr('messageId', messageId);
                $(`button[class~="delete-msg-button"]`)
                    .prop('disabled', true)
                    .css('cursor', 'not-allowed');
                $(`span[class="current-msg-display"]`).attr('data-messages', 'single');

                $(`div[class~="mails-content"]`).html(`
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="font-14 m-0"><strong>Recipients</strong></h4>
                            </div>
                            <div class="col-lg-4 text-right">
                                ${resp.data.result.result[0].date_sent}
                            </div>
                            <div class="col-lg-12 p-1" style="border:dashed 1px #ccc;">
                                <div class="text-">${resp.data.result.result[0].recipient}</div>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-0"><strong>${resp.data.result.result[0].subject} ${resp.data.result.result[0].email_status}</strong></h4>
                    <div style="border:dashed 1px #ccc;" class="p-2 mb-4">
                        ${resp.data.result.result[0].message}
                        <div class="row mt-4 justify-content-start">
                            ${resp.data.result.result[0].attachments}
                        </div>
                    </div>

                    <div class="mt-4">
                        <a class="btn btn-outline-danger delete-item" data-item="email" data-item-id="${resp.data.result.result[0].email_guid}" href="javascript:void(0)">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                        <a href="${baseUrl}emails-compose/fwd/${resp.data.result.result[0].email_guid}" class="btn btn-outline-primary waves-effect">Forward <i class="mdi mdi-share"></i></a>
                    </div>
                `);
            }
        },
        complete: function(data) {
            $(`span[class~="mail-content-loader"]`).html(``);
        },
        error: function(err) {
            $(`span[class~="mail-content-loader"]`).html(``);
        }
    });
}

var listEmails = (contact_guid = null, message_type = null) => {

    $(`span[class="current-msg-list"]`).attr('data-messages', message_type);
    $(`button[class~="go-back"]`).addClass('hidden');
    $(`button[data-button-action="all"]`).css({ display: 'none' });
    $(`button[data-button-action="trash"]`).css({ display: 'none' });
    $(`button[data-button-action="delete"]`).css({ display: 'none' });

    $(`div[class="form-content-loader"]`).css("display", "flex");

    $.ajax({
        url: `${baseUrl}api/emails/list`,
        type: "GET",
        dataType: "json",
        data: { contact_guid, message_type },
        success: function(resp) {

            $(`span[class="current-msg-display"]`).attr('data-messages', 'all');
            $(`div[class~="mails-content"]`).addClass('hidden');
            $(`div[class~="mails-listing"]`).removeClass('hidden');

            if (resp.code == 200) {
                $(`table[class~="emailsList"]`).dataTable().fnDestroy();
                $(`table[class~="emailsList"]`).dataTable({
                    "aaData": resp.data.result.result,
                    "iDisplayLength": 10,
                    "columns": [
                        { "data": "row_id" },
                        { "data": "main_subject" },
                        { "data": "message" },
                        { "data": "date_sent" },
                        { "data": "option" }
                    ]
                });
            }

        },
        complete: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
            $(`span[class~="mail-content-loader"]`).html(``);
            $(`span[class="active-msg"]`).attr('messageId', 'null');
        },
        error: function() {
            $(`div[class="form-content-loader"]`).css("display", "none");
        }
    })
}

if ($(`table[class~="emailsList"]`).length) {
    listEmails();
}

$(`button[data-request='execute-emails']`).on("click", function() {
    let container = $(`span[class="execute-loader"]`);
    let button = $(`button[data-request='execute-emails']`);
    button.prop('disabled', true);
    container.fadeIn().html(`Executing <i class="fa fa-spin fa-spinner"></i>`);

    $.post(`${baseUrl}api/emails/execute`, function(resp) {
        if (resp.code == 200) {
            container.html(`Success <i class="fa fa-check text-success"></i>`).fadeOut(5000);
        } else {
            container.html(`<span class="text-danger">Failed</span>`).fadeOut(5000);
        }
        button.prop('disabled', false);
    }).catch(() => {
        button.prop('disabled', true);
        container.html(`Failed`).fadeOut(5000);
    });
});