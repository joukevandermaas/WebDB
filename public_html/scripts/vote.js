var request;
function doVote(id, val, elem) {
    
    
    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
    request.open("GET", "dynamic/vote.php?pid=" + id + "&value=" + val, true);
    request.onreadystatechange = function() { voteDone(elem) };
    request.send(null);
}
function voteDone(elem) {
    if (request.readyState == 4)
    {
       var response = JSON.parse(request.responseText);
       if (response.succes) {
           fixpic(elem);
       }
    }
}
function fixpic(elem) {
    elem.className += ' fixed';
}
