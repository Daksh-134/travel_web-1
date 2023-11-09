function submitForm() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: $("#signupForm").attr("action"),
        data: $("#signupForm").serialize(),
        success: function (response) {
            $("#resultContainer").html(response);
        }
    });
}
