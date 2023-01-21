require(['jquery', 'jquery/ui'], function ($) {
    $("#file").on("change", function(){
        var file_size = $('#file')[0].files[0].size / 1024 / 1024;
        if (file_size > 2) {
            $("#alertMessage").css("display", "block");
            $("#createNewTicket").prop('disabled', true);
        } else {
            $("#alertMessage").css("display", "none");
            $("#createNewTicket").prop('disabled', false);
        }
    });
});
