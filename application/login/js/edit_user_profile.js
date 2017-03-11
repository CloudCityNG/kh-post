function display_data(n) {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null) {
        alert ("Your browser does not support AJAX!");
        return;
    }
    var url="application/login/insert.php";
    url=url+"?employ_id="+n;
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
            document.getElementById('employ_data').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",url,true);
	alert('hello');
    xmlhttp.send(null);
}