/*
@author Ben
 */

(function($) {
    /*-----------------------show--------------------------*/
    if (navigator.userAgent.match(/Mobi/i) || navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/iPhone/i)) {//移动端
        $("#infility_tool .logo").bind("click",function () {
            let obj = $("#infility_tool");
            let chat = $(".chat");
            let logo = $(".logo");
            obj.stop();
            let height_logo = parseInt(logo.css("height"));
            let height_chat = Number(chat.length) * parseInt(chat.css("height"))+Number(chat.length) * parseInt(chat.css("margin-bottom"));
            let height = height_logo + height_chat;
            obj.animate({height: height + 'px'}, "slow");
            logo.css("display", "none");
            chat.fadeIn();
            return false;
        });

        $("#infility_tool").mouseleave(function () {
            let obj = $(this);
            let chat = $(".chat");
            let logo = $(".logo");
            obj.stop();
            obj.animate({height: "110px"}, "slow");
            chat.css("display", "none");
            logo.fadeIn();
            return false;
        });
    }else{
        $("#infility_tool .logo").mouseenter(function () {
            let obj = $("#infility_tool");
            let chat = $(".chat");
            let logo = $(".logo");
            obj.stop();
            let height_logo = parseInt(logo.css("height"));
            let height_chat = Number(chat.length) * parseInt(chat.css("height"))+Number(chat.length) * parseInt(chat.css("margin-bottom"));
            let height = height_logo + height_chat;
            obj.animate({height: height + 'px'}, "slow");
            logo.css("display", "none");
            chat.fadeIn();
            return false
        });

        $("#infility_tool").mouseleave(function () {
            let obj = $(this);
            let chat = $(".chat");
            let logo = $(".logo");
            obj.stop();
            obj.animate({height: "110px"}, "slow");
            chat.hide();
            logo.fadeIn();
            return false;
        });
    }

    $(".return_top").click(function(){
        $('body,html').animate({scrollTop:0},'fast');
        $("#infility_tool .return_top").stop().fadeOut();
        return false;
    });


    window.onmousewheel=move_scroll;
    move_scroll();
    function move_scroll(){
        let $window = $(window);
        if ( $window.scrollTop() <= ($window.height()/2) ) {
            $("#infility_tool .return_top").stop().fadeOut();
        }else{
            $("#infility_tool .return_top").stop().fadeIn();
        }
    }




/*-----------------------show--------------------------*/
})( jQuery );