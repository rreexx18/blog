$(document).ready(function(){
    $("tbody tr").hover(function(){
        $(this).find(".actions").show();
    });
    $("tbody td").hover(function(){
        $(this).find(".actions").show();
    });
    $(".actions").hover(function(){
        $(this).show();
    });
    $(".admin-table").mouseout(function(){
        $(this).find(".actions").hide();
    });
    $(".form-upd-passwd").removeAttr("required");
});