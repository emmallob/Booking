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
$("form[id='authForm']").on('submit', function(e) {
    e.preventDefault();
    $("#submit-button").attr("disabled", true);
    $("#login-result").html("");
    $("#loader_img").css("display", "block");
    $.ajax({
        type: 'POST',
        url: $("form[id='authForm']").attr('action'),
        data: $("form[id='authForm']").serialize(),
        dataType: 'json',
        success: function(response) {
            Toast.fire({
                title: response.result,
                type: responseCode(response.status)
            });
            if (response.reload) {
                $("form[id='form-login'] input").val('');
                setTimeout(() => {
                    window.location.href = response.href
                }, 1000)
            }
        },
        error: function(err) {
            $("#loader_img").css("display", "none");
            $("#submit-button").removeAttr("disabled", false);
            Toast.fire({
                title: "Sorry! An error was encountered while processing the request.",
                type: "error"
            });
        },
        complete: function(data) {
            $("#loader_img").css("display", "none");
            $("#submit-button").removeAttr("disabled", false);
        }
    });
});