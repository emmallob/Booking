var emails_array_list = {},
    email_content_filters,
    email_loader = $(`div[class="email-list"] div[class="absolute-content-loader"]`),
    emails_container = $(`div[id="emails-content-listing"]`),
    emails_content_display = $(`div[id="emails-content-display"]`),
    emails_filters = $(`div[id="email-content-filters"]`),
    listUl = $(`ul[class="nav"][data-email-duty="list"] li`),
    listBtn = $(`a[data-email-duty="list"]`),
    readState = $(`a[data-email-change="state"],button[data-email-change="state"]`),
    moveToBtn = $(`button[data-email-move="mail"]`),
    checkAllBtn = $(`input[class~="data-email-checkall"]`),
    emailSearch = $(`input[class~="email-search-item"]`),
    emailSearchBtn = $(`button[class~="email-search-btn"]`),
    newEmailBtn = $(`button[class~="new-email-list"]`),
    oldEmailBtn = $(`button[class~="old-email-list"]`),
    noMailFound = ` <div class="email-list-item email-list-item--unread"><div class="text-center w-100"><span>No mails available</span></div></div>`;

checkAllBtn.on("change", function() {
    $(`div[id="emails-content-listing"] input[type="checkbox"]`).prop("checked", !$(`div[id="emails-content-listing"] input[type="checkbox"]`).prop('checked'));
});

readState.on("click", async function() {
    let value = $(this).attr("data-email-value"),
        thread_Ids = new Array();
    $.each($(`div[id="emails-content-listing"] input[type="checkbox"]`), function(ii, ie) {
        if ($(this).prop("checked")) {
            thread_Ids.push($(this).attr("data-thread-id"));
        }
    });
    if (thread_Ids.length) {
        thread_Ids = thread_Ids.join(",");
        if (value === "mark_as_read") {
            await mark_As_Read(thread_Ids, true);
        } else if (value === "mark_as_unread") {
            await mark_As_Unread(thread_Ids, true);
        } else if (value === "favorite") {
            await toggle_Favorite(thread_Ids);
        } else if (value === "important") {
            await toggle_Important(thread_Ids);
        } else if (value === "trash") {
            await change_Mail_Label("move_to_trash", thread_Ids, true);
        } else if (value === "inbox") {
            await change_Mail_Label("move_to_inbox", thread_Ids, true);
        }
        await count_Emails();
        checkAllBtn.prop("checked", false);
        $(`div[id="emails-content-listing"] input[type="checkbox"]`).prop("checked", false);
    }
});

moveToBtn.on("click", function() {
    let thread_Ids = new Array();
    $.each($(`div[id="emails-content-listing"] input[type="checkbox"]`), function(ii, ie) {
        if ($(this).prop("checked")) {
            thread_Ids.push($(this).attr("data-thread-id"));
        }
    });
});

var backBtn = function() {
    emails_filters.removeClass("hidden");
    emails_container.removeClass("hidden");
    emails_content_display.addClass("hidden");
    $(`div[class~="email-content-list-filter"] span`).attr("data-thread-id", "");
}

listBtn.on("click", async function() {
    let that = $(this).parent("li"),
        value = $(this).attr("data-email-value");

    $(`button[data-email-change="state"][data-email-value="inbox"]`).addClass("hidden");
    $(`button[data-email-move="mail"][data-email-value="trash"]`).prop({ "disabled": false, "title": "" }).removeClass("hidden");
    $(`button[data-email-change="state"][data-email-value="important"]`).prop({ "disabled": false, "title": "" });

    $(`button[data-email-value="mark_as_read"]`).removeClass("hidden");
    $(`button[data-email-value="mark_as_unread"]`).removeClass("hidden");

    if (value == "trash") {
        $(`button[data-email-change="state"][data-email-value="inbox"]`).removeClass("hidden");
        $(`button[data-email-change="state"][data-email-value="trash"]`).prop({ "disabled": true, "title": "Disabled" }).addClass("hidden");
    }
    if (value == "important") {
        $(`button[data-email-change="state"][data-email-value="important"]`).prop({ "disabled": true, "title": "Disabled" });
    }
    if (value == "sent") {
        $(`button[data-email-value="mark_as_read"]`).addClass("hidden");
        $(`button[data-email-value="mark_as_unread"]`).addClass("hidden");
    }

    listUl.removeClass("active");
    that.addClass("active");

    checkAllBtn.prop("checked", false);
    emails_filters.removeClass("hidden");
    emails_container.removeClass("hidden");
    emails_content_display.addClass("hidden");
    ajax_Load_Emails();
});

var toggle_Important = async(threadIds = null) => {
    let action = {
        action: "mark_as_important",
        thread_id: threadIds
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        if (response.code == 200) {
            let c_count = 0;
            $.each(response.data.result, function(ii, ie) {
                c_count++;
                emails_array_list[ii].is_important = ie.is_important;
                $(`span[class~="marked-as-important"][data-thread-id="${ii}"]`).html(ie.class);
                $(`div[id="emails-content-listing"] input[type="checkbox"][data-thread-id="${ii}"]`).prop("checked", false);
            });
            let note = (c_count == 1) ? "Conversation marked as important" : `${c_count} conversations marked as important`;
            show_Notification(note);
        } else {}
    });
}

var toggle_Favorite = async(threadIds = null) => {
    let action = {
        action: "mark_as_favorite",
        thread_id: threadIds
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        if (response.code == 200) {
            let c_count = 0;
            $.each(response.data.result, function(ii, ie) {
                c_count++;
                emails_array_list[ii].is_favorited = ie.is_favorited;
                $(`span[data-thread-id="${ii}"][class~="favorited"]`).removeClass("text-warning text-secondary").addClass(ie.class);
                $(`div[id="emails-content-listing"] input[type="checkbox"][data-thread-id="${ii}"]`).prop("checked", false);
            });
            let note = (c_count == 1) ? "Conversation favorite mode toggled" : `${c_count} conversations favorite mode toggled`;
            show_Notification(note);
        } else {}
    });
}

var mark_As_Read = async(threadIds = null, show_notification = true) => {
    let action = {
        action: "mark_as_read",
        thread_id: threadIds
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        if (response.code == 200) {
            let c_count = 0;
            $.each(response.data.result, function(_, ie) {
                c_count++;
                emails_array_list[ie].is_read = 1;
                $(`div[class~="email-list-item"][data-thread-id="${ie}"]`).attr("data-thread-status", "read");
                $(`div[data-thread-id="${ie}"][class~="email-list-item"]`).removeClass("email-list-item--unread");
                $(`div[id="emails-content-listing"] input[type="checkbox"][data-thread-id="${ie}"]`).prop("checked", false);
            });
            if (show_notification) {
                let note = (c_count == 1) ? "Conversation marked as read" : `${c_count} conversations marked as read`;
                show_Notification(note);
            }
        } else {}
    });
}

var mark_As_Unread = async(threadIds = null, show_thread_list = false) => {
    let action = {
        action: "mark_as_unread",
        thread_id: threadIds
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        if (response.code == 200) {
            let c_count = 0;
            $.each(response.data.result, function(_, ie) {
                c_count++;
                emails_array_list[ie].is_read = 0;
                $(`div[class~="email-list-item"][data-thread-id="${ie}"]`).attr("data-thread-status", "unread");
                $(`div[data-thread-id="${ie}"][class~="email-list-item"]`).addClass("email-list-item--unread");
                $(`div[id="emails-content-listing"] input[type="checkbox"][data-thread-id="${ie}"]`).prop("checked", false);
            });
            let note = (c_count == 1) ? "Conversation marked as unread" : `${c_count} conversations marked as unread`;
            show_Notification(note);

            if (show_thread_list) {
                emails_filters.removeClass("hidden");
                emails_container.removeClass("hidden");
                emails_content_display.addClass("hidden");
            }
        } else {}
    });
}

var change_Mail_Label = async(label, threadIds = null, show_thread_list = false) => {
    let action = {
        action: label,
        thread_id: threadIds
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        if (response.code == 200) {
            let c_count = 0,
                note;
            $.each(response.data.result, function(_, ie) {
                c_count++;
                emails_array_list[ie] = {};
                $(`div[class~="email-list-item"][data-thread-id="${ie}"]`).remove();
                $(`div[id="emails-content-listing"] input[type="checkbox"][data-thread-id="${ie}"]`).prop("checked", false);
            });
            if (label === "move_to_trash") {
                note = (c_count == 1) ? "Conversation moved to trash" : `${c_count} conversations moved to trash`;
            } else if (label == "move_to_inbox") {
                note = (c_count == 1) ? "Conversation moved from trash" : `${c_count} conversations moved from trash`;
            } else if (label == "move_to_archive") {
                note = (c_count == 1) ? "Conversation has been archived" : `${c_count} conversations have been archived`;
            }
            show_Notification(note);
            if (show_thread_list) {
                count_Emails();
                emails_filters.removeClass("hidden");
                emails_container.removeClass("hidden");
                emails_content_display.addClass("hidden");
            }
        } else {}
    });
}

var apply_email_click_handlers = () => {
    $(`span[data-function="toggle-thread-files-attachment-list"]`).on("click", function() {
        let reply_id = $(this).attr("data-thread-id");
        $(`div[class~="attachments_list"][data-thread-id="${reply_id}"]`).slideToggle("slow");
    });
    init_image_popup();
    $(`[data-toggle="tooltip"]`).tooltip();
}

var show_Emails_Content = async(threadId = null) => {

        let status = $(`div[class~="email-list-item"][data-thread-id="${threadId}"]`).attr("data-thread-status");

        if (status == "unread") {
            await mark_As_Read(threadId, false);
        }

        let mail = emails_array_list[threadId],
            r_count = mail.recipient_details.length,
            rc_count = mail.copy_recipients.length,
            r_list = mail.recipient_details,
            rc_list = mail.copy_recipients,
            r_content = "",
            rc_content = "";

        $.each(r_list, function(ii, ie) {
            r_content += `<span class="text-muted"><strong>${ie.fullname}</strong> <small>&lt;${ie.email}&gt;</small></span>`;
            if (ii < r_count - 1) {
                r_content += ", ";
            }
        });

        $.each(rc_list, function(ii, ie) {
            rc_content += `<span class="text-muted"><strong>${ie.fullname}</strong> <small>&lt;${ie.email}&gt;</small></span>`;
            if (ii < rc_count - 1) {
                rc_content += ", ";
            }
        });

        let email_content = `
        <div class="card" id="email-full-content-display" data-thread-id="${mail.thread_id}">
            <div class="card-header">
                <div class="row justify-content-between" style="width:100%">
                    <div class="d-flex align-items-start">
                        <div class="pl-3 mr-1">
                            <h4>${mail.subject}</h4>
                        </div>
                        <div>
                            <span onclick="return toggle_Important('${mail.thread_id}');" data-thread-id="${mail.thread_id}" ${mail.is_important ? "title='Marked as important' class='text-warning marked-important'" : "class='marked-important'"} ""><i class="fa fa-tags"></i></span>
                        </div>
                    </div>
                    <div class="email-content-list-filter">
                        <span data-thread-id="${mail.thread_id}" onclick="return backBtn();" class="text-muted cursor font-18px mr-1" data-placement="bottom" data-toggle="tooltip" title="Go back"><i class="fa fa-arrow-circle-left"></i></span>
                        <span data-thread-id="${mail.thread_id}" onclick="return change_Mail_Label('move_to_archive', '${mail.thread_id}',true);" class="text-muted cursor font-18px archieve-emails-list mr-1" data-placement="bottom" data-email-duty_change="archieve" data-toggle="tooltip" title="Archieve this conversation"><i class="fa fa-archive"></i></span>
                        <span data-thread-id="${mail.thread_id}" onclick="return change_Mail_Label('move_to_trash', '${mail.thread_id}',true);" class="text-muted cursor font-18px delete-emails-list mr-1" data-placement="bottom" data-email-duty_change="delete" data-toggle="tooltip" title="Delete this conversation"><i class="fa fa-trash"></i></span>
                        <span data-thread-id="${mail.thread_id}" onclick="return mark_As_Unread('${mail.thread_id}',true);" class="text-muted cursor font-18px mr-2" data-placement="bottom" data-email-duty_change="unread" data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open-text"></i></span>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 p-0">
                <div class="d-flex align-items-start p-3 pt-0 pb-0">
                    <div style="width:60px">
                        <img class="img-xs rounded-circle" width="50px" src="${baseUrl}${mail.sender_image}" alt="">
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong class="font-16px">${mail.sender_details.fullname}</strong> <small class="text-muted">&lt;${mail.sender_details.email}&gt;</small>
                                </div>
                                <div class="col-md-6 d-none d-md-block text-right">
                                    <span class="text-muted tx-12">${mail.email_fulldate} (${mail.days_ago})</span>
                                    <span onclick="return toggle_Favorite('${mail.thread_id}')" data-placement="bottom" data-toggle="tooltip" title="Click to toggle favorite" data-thread-id="${mail.thread_id}" class="${mail.is_favorited ? "text-warning" : "text-secondary"} cursor favorited"><i class="fa fa-star"></i></span>
                                </div>
                            </div>
                        </div>
                        ${r_content ? `<div class="col-lg-12">to: ${r_content}` : `</div>`}
                        ${rc_content ? `<div class="col-lg-12">copy: ${rc_content}` : `</div>`}
                    </div>
                </div>
                <div class="col-lg-12 border-top mt-3 p-3">
                    ${mail.message}
                </div>
                <div class="row">
                    <div class="col-lg-12 pt-3 pb-2">
                        <div class="${mail.attachment.files.length ? `` : ""}">
                            <p>
                                <span ${mail.attachment.files.length ? `data-function="toggle-thread-files-attachment-list" data-thread-id="${mail.thread_id}" class="cursor" data-toggle="tooltip" title="Hide Attachments"` : ""}>
                                ${mail.attachment.files.length ? `${mail.attachment.files.length} files attached (${mail.attachment.files_size})` : ""}
                                </span>
                            </p>
                        </div>
                        <div class="attachments_list" data-thread-id="${mail.thread_id}">${mail.attachment_html}</div>
                    </div>
                </div>
            </div>
        </div>`;

    emails_filters.addClass("hidden");
    emails_container.addClass("hidden");
    emails_content_display.html(email_content);
    emails_content_display.removeClass("hidden"); 
    email_content_filters = $(`div[class~="email-content-list-filter"]`);
    apply_email_click_handlers();
}

var format_Email_Content = (mail) => {

    return `<div class="email-list-item ${mail.is_read ? "" : "email-list-item--unread"}" data-thread-status="${mail.is_read ? "read" : "unread"}" data-thread-id="${mail.thread_id}">
        <div class="email-list-actions">
            <div class="form-check form-check-flat form-check-primary">
                <label class="form-check-label" for="email-thread-id_${mail.thread_id}">
                    <input type="checkbox" data-thread-id="${mail.thread_id}" class="form-check-input" id="email-thread-id_${mail.thread_id}">
                    <i class="input-frame" id="email-thread-id_${mail.thread_id}"></i>
                </label>
            </div>
            <span onclick="return toggle_Favorite('${mail.thread_id}')" title="Click to toggle favorite" data-thread-id="${mail.thread_id}" class="${mail.is_favorited ? "text-warning" : "text-secondary"} favorited"><i class="fa fa-star"></i></span>
        </div>
        <a onclick="return show_Emails_Content('${mail.thread_id}')" href="javascript:void(0)" class="email-list-detail">
            <div>
                <span class="from">${mail.subject} <span data-thread-id="${mail.thread_id}" class="marked-as-important">${mail.is_important ? "<span class='txt-10'><i title='Marked as important' class='fa text-warning fa-tags'></i></span>" : ""}</span></span>
                <p class="msg">${mail.caption}</p>
            </div>
            <span class="date">${mail.attachment.files.length ? `<span class="icon"><i class="fa text-muted fa-paperclip"></i></span>` : "" } ${mail.email_date}</span>
        </a>
    </div>`;
}

var count_Emails = async() => {
    let action = {
        action: "mails_count",
        labels: "labels_count,trash_count,unread_count,read_count,favorite_count,important_count"
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        if (response.code == 200) {
        $.each(response.data.result, function(i, e) {
            $(`span[data-mails-count="${i}"]`).html(e);
        });
        } else {}
    });
}

var ajax_Load_Emails = async() => {
    let action = {
        q: $(`input[class~="email-search-item"]`).val(),
        action: "mails_list",
        labels: $(`ul[class="nav"][data-email-duty="list"] li[class="active"] a`).attr("data-email-value")
    };
    await $.post(`${baseUrl}api/emails/action`, { action: action }).then((response) => {
        email_loader.css({ "display": "none" });
        if (response.code == 200) {
            let emails_list = response.data.result.list,
                emails_content = "";

            $.each(emails_list, function(ii, ie) {
                emails_array_list[ie.thread_id] = ie;
                emails_content += format_Email_Content(ie);
            });
            emails_container.html(emails_content);

            $.each(response.data.result.pagination, function(ii, ie) {
                $(`span[data-pagination="${ii}"]`).html(ie);
            });
        } else {
            $.each($(`span[data-pagination]`), function(ii, ie) {
                $(this).html(0);
            });
            emails_container.html(noMailFound);
        }
    }).catch(() => {
        email_loader.css({ "display": "none" });
    });
}

$(`button[class~="email-search-btn"]`).on("click", async function() {
    let search_term = $(`input[class~="email-search-item"]`).val();
    if(!search_term.length) {
        show_Notification("Enter a search term!", "danger");
        return false;
    }
    ajax_Load_Emails();
});

$(`input[class~="email-search-item"]`).on("keyup", async function(evt) {
    let search_term = $(this).val();
    if (evt.keyCode == 13) {
        if(!search_term.length) {
            show_Notification("Enter a search term!", "danger");
            return false;
        }
        ajax_Load_Emails();
    }
})

var append_Suggested_Email = (user_id, user_name, user_email, the_field) => {
    
    let last_field = $(`div[id="${the_field}sinput"] span[class="tag"]:last span`);
        last_field.attr({"data-user_id":user_id,"data-user_name":user_name,"data-user_email":user_email});
        last_field.html(user_name);

    $(`div[data-list-id="${the_field}"][class~="list_suggestions"]`).addClass("hidden").html("");
}

var format_Email_Suggestions_List = (e, the_field) => {
    return `<div class="each-item" data-user-id="${e.user_id}" onclick="return append_Suggested_Email('${e.user_id}','${e.name}','${e.email}','${the_field}')">
        <div class="d-flex align-items-start">
            <p class="mr-2"><img class="" src="${baseUrl}${e.image}" alt=""></p>
            <p>${e.name}<br><span class="text-muted">${e.email}</span></p>
        </div>
    </div>`;
}

$(`div[class="email-compose-fields"] button[class~="discard-button"]`).on("click", function() {
    $(`div[id="discardFormModal"]`).modal("show");
    $(`div[class="form-overlay-cover"]`).css("display", "flex");
});

$(`div[class="email-compose-fields"] button[class~="send-button"]`).on("click", function() {
    var mail_request = $(`input[name="mail_request"]`).val(),
        recipients_list = {},
        mailer_notice = "",
        notice_type = "danger";
    $.each($(`div[id="recipients_list"] div[class="ms-sel-item"]`), function(i, e) {
        let item = $(this),
            the_item = item.data("json");
        recipients_list[i] = the_item;
    });

    let cc_list = {};
    $.each($(`div[id="cc_list"] div[class="ms-sel-item"]`), function(i,e) {
        let item = $(this),
            the_item = item.data("json");
        cc_list[i] = the_item;
    });

    if(mail_request == "send_later") {
        mail_request = $(`input[id="schedule_date"]`).val();
    }

    let content = htmlEntities($(`trix-editor[id="email_content"]`).html());

    let the_list = {
        mail_content : {
            label: "inbox",
            scheduler: mail_request,
            subject: $(`input[name="mail_subject"][id="mail_subject"]`).val(),
            content: content,
        },
        recipients : {
            primary: recipients_list,
            copied: cc_list
        }
    };

    the_list = JSON.stringify(the_list);

    let action = {
        action: "send_email",
        labels: the_list
    };

    $.post(`${baseUrl}api/emails/action`, {action: action}).then((response) => {
        $(`div[id="discardFormModal"]`).modal("hide");
        if(response.code == 200) {
            $(`div[class~="file-preview"]`).html(``);
            $(`trix-editor[id="email_content"]`).html(``);
            $(`input[name="mail_subject"][id="mail_subject"]`).val(``)
            $(`div[class="ms-sel-ctn"] div[class="ms-sel-item"]`).html(``);

            $(`div[class~="send-email-content"]`).addClass("hidden");
            $(`div[class~="email-inbox-header"]`).removeClass("hidden");
            $(`div[class~="email-filters"]`).removeClass("hidden");
            $(`div[class~="email-list"]`).removeClass("hidden");

            notice_type = "success";
            mailer_notice = `Email successfully sent!`;
        } else {
            mailer_notice = response.data.result;
        }
        show_Notification(mailer_notice, notice_type);
    });
});

$(`div[data-function="email"] button[data-action="schedule_send"]`).on("click", function() {
    $(`div[data-function="email"] button[data-action="schedule_now"]`).removeClass("hidden");
    $(`div[data-function="email"] button[data-action="schedule_send"]`).addClass("hidden");
    $(`input[id="schedule_date"]`).removeClass("hidden");
    $(`input[name="mail_request"]`).val("send_later");
});

$(`div[data-function="email"] button[data-action="schedule_now"]`).on("click", function() {
    $(`div[data-function="email"] button[data-action="schedule_send"]`).removeClass("hidden");
    $(`div[data-function="email"] button[data-action="schedule_now"]`).addClass("hidden");
    $(`input[id="schedule_date"]`).addClass("hidden");
    $(`input[name="mail_request"]`).val("send_now");
});

$(`div[id="discardFormModal"] button[class~="discard_email_content"]`).on("click", function() {
    let action = {
        action: "discard_email_composer",
        labels: "discard"
    };
    $.post(`${baseUrl}api/emails/action`, {action: action}).then((response) => {
        $(`div[id="discardFormModal"]`).modal("hide");
        if(response.code == 200) {
            $(`div[class~="file-preview"]`).html(``);
            $(`trix-editor[id="email_content"]`).html(``);
            $(`input[name="mail_subject"][id="mail_subject"]`).val(``)
            $(`div[class="ms-sel-ctn"] div[class="ms-sel-item"]`).html(``);

            $(`div[class~="send-email-content"]`).addClass("hidden");
            $(`div[class~="email-inbox-header"]`).removeClass("hidden");
            $(`div[class~="email-filters"]`).removeClass("hidden");
            $(`div[class~="email-list"]`).removeClass("hidden");

            show_Notification(`Email has been discarded!`, `primary`);
        }
    });
});

$(`a[id="send_mail"]`).on("click", function() {
    $(`div[class~="send-email-content"]`).removeClass("hidden");
    $(`div[class~="email-inbox-header"]`).addClass("hidden");
    $(`div[class~="email-filters"]`).addClass("hidden");
    $(`div[class~="email-list"]`).addClass("hidden");
});

$(() => {
    
    if($(`div[id="emails-content-listing"]`).length) {
        count_Emails();
        ajax_Load_Emails();
    }
     
    $(`[data-toggle="suggestions"]`).magicSuggest({
        method: "GET",
        allowDuplicates: false,
        valueField: "user_id",
        dataUrlParams: {
            minified: true,
            limit: 10
        },
        minChars: 2,
        maxSelection: 100,
        data: `${baseUrl}api/users/list`,
        strictSuggest: false,
        autoSelect: false,
        maxSelectionRenderer: function(v) {
            return 'You cannot choose more than 100 email address' + (v > 1 ? 'es' : '');
        }
    });
    
});