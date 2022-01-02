function loader(status,overlay){
    if(overlay === undefined){
        overlay = false;
    }
    if(status){
        $(".loader").fadeIn(200);
        if(overlay){ $(".overlay").fadeIn(10); }
    }else{
        if($(".overlay").is(":visible")){ $(".overlay").fadeOut(10); }
        $(".loader").fadeOut(200);
    }
}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});