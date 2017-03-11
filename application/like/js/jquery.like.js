/*
* This create the source to become the like button
* Creator: Loch Khemarin
* Date: 09/08/2011
*/

(function($){

    $.fn.likeButton = function(options){
        var defaults = {
            likeword : "Like",
            islike   : true,
            numlike : 0,
            onClick  : function(){}
        };

        var settings = $.extend(defaults, options);

        return this.each(function(){
            $(this).addClass("_like_button");
            var $like_image   = "<img src='application/like/images/like.png'>";
            var $like_summary;
            $like_summary = "<span class='summary'></span>";
            if(settings.numlike != 0)$like_summary = "<span class='summary'>" + settings.numlike + "</span>";
            var $like_word    = "";
            if(!settings.islike)
                $like_word    = "<span class='like_word'>" + settings.likeword + "</span>";
            else
                $like_word    = "<span class='unlike_word'>x</span>";

            var $like_button = $like_image + $like_summary + $like_word;
            $(this).html($like_button);


            //when click the like button
            $(this).find("span:nth-child(3)").click(function(){
                if($(this).html() != "x"){
                    $(this).removeClass("like_word");
                    $(this).addClass("unlike_word");
                    $(this).html("x");
                    settings.numlike++;
                    settings.onClick.call(this, "like");
                }
                else{
                    $(this).removeClass("unlike_word");
                    $(this).addClass("like_word");
                    settings.numlike--;
                    $(this).html(settings.likeword);
                    settings.onClick.call(this, "unlike");
                }
                //alert(settings.numlike)
                if(settings.numlike == 0)$(this).parent().find("span.summary").html("");
                else $(this).parent().find("span.summary").html(settings.numlike);

            });



        });
    };
})(jQuery)