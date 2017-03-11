(function($){
jQuery.fn.LoadLanguage = function(options){

    var defaults = {
        language  : "jp"
    };

    var options = jQuery.extend(defaults,options);
    var url = "application/language/data/" + options.language + ".json";

    return this.each(function(){
        $(this).find("._language").each(function(){
            var txt = $(this).html();
            //$(this).html("<span style='display: none;'>" + txt + "</span><span></span>");
            //$(this).html("");
            $(this).attr("word", txt);
        });
        ChangeLanguage(options.language);
    });
};
})(jQuery)


function ChangeLanguage(lng){
    //if(lng == current_language)return;

    if(lng == "en"){
        $("._language").each(function(){
            /*var val = $(this).find("span:nth-child(1)").html();
            $(this).find("span:nth-child(2)").html(val);
            */
            $(this).html($(this).attr("word"));
        });
        current_language = lng;
        return;
    }
    var url = "application/language/data/" + lng + ".json";
    $.getJSON(url, function(data){
        var items = [];
        $.each(data, function(key, val){
            items[key] = val;
        });

        $("._language").each(function(){
            //key = $(this).find("span:nth-child(1)").html();
            key = $(this).attr("word");
            if(!items[key]){
                //$(this).find("span:nth-child(2)").html(key);
                $(this).html(key);
            }
            if(key == null){
                return;
            }
            key = key.toString().toLowerCase();
            if(items[key] == key) return;
            //$(this).find("span:nth-child(2)").html(items[key]);
            $(this).html(items[key]);
        });

        //integrate with datepick
        if(current_language == "jp"){
            $(".date").datepick($.extend($.datepick.regional['ja']));
        }
        else $(".date").datepick($.extend($.datepick.regional['en']));
        $.datepick.setDefaults($.datepick.regional['']);

    });
    current_language = lng;
}
