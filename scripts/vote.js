var request;

function doVote(id, val, elem) {
    // do a http request to dynamic/vote.php to cast the vote
    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
    request.open("GET", "dynamic/vote.php?pid=" + id + "&value=" + val, true);
    request.onreadystatechange = function() { voteDone(elem) };
    request.send(null);
}
function voteDone(elem) {
    if (request.readyState == 4  && request.status == 200)
    {
       var response = JSON.parse(request.responseText);
       if (response.succes) { // the vote was cast, so make the image seem fixed
           fixpic(elem);
       }
    }
}
function fixpic(elem) { // the css will take care of the images
    elem.className += ' fixed';
}
