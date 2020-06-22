
$(document).ready(function () {

  
    $(window).on('scroll', function () {
        var height = $(window).scrollTop();

        if (height > 55 && ($(window).width() > 650)){
                $('#logo img').stop().animate({
                    height: "0px",
                    width: "0px"
                }, 800);
                $('.zamenaSlike').show("slow")
            }
            else {
                $('#logo img').stop().animate({
                    height: "200px",
                    width: "160"
                }, 800);
                $(".zamenaSlike").hide("slow");
            }
    });



    $(".vidiJos").click(function(){
    $(".josVesti").slideDown("slow");
});
    $(".vidiManje").click(function(){
        $(".josVesti").slideUp("slow");
    });

    $(".Otvaranje").click(function(){
        $("#tabela").slideToggle("slow");
    });

     $("#headerIcon").click(function(){
        $(".nav").slideToggle(500);
    });
    $( "#dialogAudi").dialog({
        autoOpen: false,
        modal: true,
        left: "15%",
        width: "70%",
        show: {
            effect: "highlight",
            duration: 1000
        },
        hide: {
            effect: "explode",
            duration: 1000
        }
    });

    $(".naslovAudi" ).click(function() {
        $( "#dialogAudi" ).dialog( "open" );
    });

    $(".log_out_prop").click(function(){
        $(".log_out").slideToggle("slow");
    });


   var logOut = document.getElementById("logOut_button").value;
   if(logOut.length === 0){
    logOut.style.display = "none";
   }

}
);
