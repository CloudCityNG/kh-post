/*
* Created the structure of block navigation to be the block navigation application
*/

//create the block navigation

(function($){

jQuery.fn.blockNavigation = function(options){
    var defaults = {
        num_per_page  : 5
    };


    var Custom = jQuery.extend(defaults,options);


    return this.each(function(){

            //views only [num_per_page] <li> in the list
            var total_li = $(this).find("li").length;
            var total_page = (total_li / Custom.num_per_page);

            $(this).append('<div class="navigation"><div class="prev"></div><div class="page_info"></div><div class="next"></div></div>');
            $(this).append('<span style="display: none;" class="navigation_block_page">1</span>');

            if(total_li > Custom.num_per_page){
                //<div class="navigation"><div class="prev"></div><div class="next"></div></div>

                $(this).find("div.prev").click(function(){
                    var prev_page = parseInt($(this).parent().siblings("span.navigation_block_page").html()) - 1;
                    MoveToPage(prev_page, $(this).parents("div.navigation_block"));
                });

                $(this).find("div.next").click(function(){
                    var next_page = parseInt($(this).parent().siblings("span.navigation_block_page").html()) + 1;
                    MoveToPage(next_page, $(this).parents("div.navigation_block"));
                });
            }
            else{
                $(this).find("div.navigation div").each(function(){ $(this).hide(); });
            }

            MoveToPage(1, $(this));


            function MoveToPage(index, block){
                block.find("div.navigation").find("div").each(function(){
                    if($(this).hasClass("prev_disabled")){
                        $(this).removeClass("prev_disabled");
                        $(this).addClass("prev");
                    }
                    if($(this).hasClass("next_disabled")){
                        $(this).removeClass("next_disabled");
                        $(this).addClass("next");
                    }
                });

                var total_li  = block.find("li").length;
                var last_page = Math.ceil(total_li/Custom.num_per_page);
                if(index <= 1) {
                    index = 1;
                    //set previous button disable
                    block.find("div.navigation div:eq(0)").each(function(){
                        $(this).addClass("prev_disabled");
                        $(this).removeClass("prev");
                    });
                }

                else if(index >= last_page) {
                    index = last_page;
                    //set next button disable
                    block.find("div.navigation div:eq(2)").each(function(){
                        $(this).addClass("next_disabled");
                        $(this).removeClass("next");
                    });
                }


                //set page info
                block.find("div.navigation div.page_info").html(index + "/" + last_page);

                var start_li = (index - 1) * (Custom.num_per_page);
                var end_li   = start_li + Custom.num_per_page;
                //alert(start_li + ";" + end_li);
                //alert(index);
                block.find("li").each(function(){
                    $(this).addClass("hide");
                });

                //alert(block.find("li:eq(" + start_li + ")").html());
                for(i = start_li; i < end_li; i++){
                    block.find("li:eq(" + i + ")").removeClass("hide");
                }

                block.find("span.navigation_block_page").html(index);
            }

    });


};
})(jQuery)

