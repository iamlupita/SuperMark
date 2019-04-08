function sortSelect(selElem) 
        {
                var tmpAry = new Array();
                for (var i=0;i<selElem.options.length;i++) {
                        tmpAry[i] = new Array();
                        tmpAry[i][0] = selElem.options[i].text;
                        tmpAry[i][1] = selElem.options[i].value;
                }
                tmpAry.sort();
                while (selElem.options.length > 0) {
                    selElem.options[0] = null;
                }
                for (var i=0;i<tmpAry.length;i++) {
                        var op = new Option(tmpAry[i][0], tmpAry[i][1]);
                        selElem.options[i] = op;
                }
                return selElem;
        }

function popup(wid,hei,dur,str){
	$(".blackBg").fadeIn(300);
	$(".popUpwindow").fadeIn(200);
	
	$(".popUpwindow").animate({width:wid+"px",minHeight:hei+"px",marginTop:"-"+hei/2+"px",marginLeft:"-"+wid/2+"px"},dur,
			function(){
		//$(".popUpwindow").css({height:"auto"});
		
		//$(".popUpwindow").css({'overflow-y':"auto"});
	});
	$(".popUpwindow").html("");
	$(str).appendTo('.popUpwindow');
	
}

function popout(){
		$(".popUpwindow").css({minHeight:"0"});
		$(".popUpwindow").animate({width:"0", height:"0",marginTop:"0",marginLeft:"0"},200,
				function(){
		$(".popUpwindow").fadeOut(10,function(){
			$(this).removeAttr("style");
			var pophtml=$(this).html();
			$(pophtml).appendTo(".popDetails");
			$(".blackBg").fadeOut(100);
			$(".popUpwindow").html("");
		});	
		});
}


$(document).ready(function(){	

$(".blackBg").click(function(){
popout();
});

});


function strip_tags (str, allowed_tags)
{
    var key = '', allowed = false;
    var matches = [];    var allowed_array = [];
    var allowed_tag = '';
    var i = 0;
    var k = '';
    var html = ''; 
    var replacer = function (search, replace, str) {
        return str.split(search).join(replace);
    };
   
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
    }
    str += '';

   
    matches = str.match(/(<\/?[\S][^>]*>)/gi);
   
    for (key in matches) {
        if (isNaN(key)) {
                // IE7 Hack
            continue;
        }

       
        html = matches[key].toString();
      
        allowed = false;

        
        for (k in allowed_array) {            
            allowed_tag = allowed_array[k];
            i = -1;

            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}

           
            if (i == 0) {                allowed = true;
                break;
            }
        }
        if (!allowed) {
            str = replacer(html, "", str); 
        }
    }
    return str;
}
