$(".prepare-test").on('click', function(event) {
    var test_set_full_id = $(this).attr('value');
    var test_defined_mode = $(this).attr('data-function');
    var instruction_id = $(this).attr('data-instruction');

    $(".test-content").show();
    $(".learning-content").show();
    $("#test_set_full_id").val(test_set_full_id);
    $("#test_defined_mode").val(test_defined_mode);

    var learningModeTests = ['QINS001'];
    if (jQuery.inArray(instruction_id, learningModeTests) === -1) {
        $(".learning-content").hide();
    }
    if (test_defined_mode == "study-mode") {
        $(".test-content").hide();
    } else if (test_defined_mode == "test-mode") {
        $(".learning-content").hide();
    }
    jQuery("#modal-popin").modal('show');
});

function selected_mode(user_mode) {
    $(".overlay").css('display', 'block');
    var category_id = $("#test_set_full_id").val();
    var test_defined_mode = $("#test_defined_mode").val();
    if ((test_defined_mode != "undefined-mode") && (user_mode != test_defined_mode)) {
        $(".overlay").css('display', 'none');
        Toast.fire({
            type: "error",
            title: "Sorry! An invalid Session Token was submitted."
        });
    } else {
        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/quiz/preparetest`,
            data: { category_id: category_id, u_mode: user_mode, test_defined_mode: test_defined_mode },
            success: function(response) {
                if ($.trim(response) == "valid_session_token") {
                    window.location.href = baseUrl + "tests-prepare/" + category_id;
                } else {
                    $(".overlay").css('display', 'none');
                    Toast.fire({
                        type: "error",
                        title: "Sorry! An invalid Session Token was submitted."
                    });
                }
            }
        });
    }
}