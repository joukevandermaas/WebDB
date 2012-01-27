var request;
function doVote(id, val) {
    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
    request.open("GET", "tools/vote.php?pid=" + id + "&value=" + val, true);
    request.onreadystatechange = voteDone;
    request.send(null);
}
function voteDone() {
    if (request.readyState == 4)
    {
        
    }
}
function movepic(img_name, img_src) {
document[img_name].src=img_src;
}