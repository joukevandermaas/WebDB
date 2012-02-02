function checklength(textarea) {
    var counter = document.getElementById('commentlength');
    var length = textarea.value.length;
    var charsleft = 256 - length;
    
    if (charsleft < 0) {
        counter.className = 'neg';
    }
    else if (charsleft < 10) {
        counter.className = 'low'
    } else {
        counter.className = '';
    }
    counter.innerHTML = ' (' + charsleft + ')';
}

var request;
function submitComment(post_id)
{ 
    if (event.preventDefault)
        event.preventDefault();
    else
        event.cancel = true;
    
    var text = document.getElementById('text').value;
    if(!(text.length > 256)) {
        var textEnc = encodeURIComponent(text);
        var param = 'text=' + textEnc + '&pid=' + post_id;
        
        request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
        request.open("POST", "dynamic/submitcomment.php",  true); 
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = function () { createComment(text) };
        request.send(param);
    }
}
function createComment(text) {
	if (request.readyState == 4)// && request.status == 200)
    {	
        var container = document.getElementById("newcomment");
        //alert(request.responseText);
        response = JSON.parse(request.responseText);
        if (!response.succes) {
            var error = container.getElementsByTagName('span')[0]
            if (!response.loggedin) {
                error.innerHTML = 'Je bent niet <a href="login.php">ingelogd</a>.';
            } else if (response.error == 'message') {
                error.innerHTML = 'Vul overal iets in.';
            } else {
                error.innerHTML = 'Er is iets misgegaan, probeer het opnieuw.';
            }
        } else {
            container.innerHTML = text + '<ul class="reacties"><li>User: ' + response.user + '</li></ul>';
        }
	}
}
