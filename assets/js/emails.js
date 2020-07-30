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
    $.ajax({
        url: `${baseUrl}api/emails/discard`,
        type: 'post',
        data: { discardEmail: true },
        dataType: 'json',
        success: function(resp) {
            window.location.href = `${baseUrl}emails`;
        }
    });
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