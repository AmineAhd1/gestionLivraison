require(['jquery', 'jquery/ui'], function ($) {
    $("#return_file").on("change", function(){
        var file_size = $('#return_file')[0].files[0].size / 1024 / 1024;
        if (file_size > 2) {
            $("#alertMessage").css("display", "block");
            $("#save").prop('disabled', true);
        } else {
            $("#alertMessage").css("display", "none");
            $("#save").prop('disabled', false);
        }
    });
});
