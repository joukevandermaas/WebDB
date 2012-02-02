var request;
function submitPost(program_id)
{
    if (event.preventDefault)
        event.preventDefault();
    else
        event.cancel = true;
 
    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");;
	
    var text = document.getElementById("text").value;
    var title = document.getElementById("title").value;
    
	var textEnc = encodeURIComponent(text);
	var titleEnc = encodeURIComponent(title);
	var param = 'text='+ textEnc + '&title=' + titleEnc + '&id=' + program_id;
	
    request.open("POST", "dynamic/writePost.php",  true); 
	request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = function() {createPost(title, text); };
    request.send(param);
}
function createPost(title, text) {
	if (request.readyState == 4)// && request.status == 200)
    {	
        var formContainer = document.getElementById('newpost');
        var postContainer = document.getElementById('posts');
    //    alert(request.responseText);
        var response = JSON.parse(request.responseText);
        if (!response.succes) {
            var error = formContainer.getElementsByTagName('span')[0];
            if (!response.loggedin)
                error.innerHTML = 'Je bent niet <a href="login.php">ingelogd</a>.';
            else if (response.error == 'message')
                error.innerHTML = 'Vul overal wat in.';
            else
                error.innerHTML = 'Er is iets misgegaan, probeer het opnieuw.';
        } else {
            formContainer.parentNode.removeChild(formContainer)
            addPost(response, postContainer);
        }
        
    }
}

function addPost(post, container, text, title) {
    var newPostLi = document.createElement('li');
    newPostLi.innerHTML = "<h5>" + "<a href='post.php?id=" + post.id + "'>" + 
            title + "</a></h5>";
            
    switch(post.type) {
        case 'image':
            newPostLi.innerHTML += "<img src='" + post.content_link + "' alt='Afbeelding' />"; 
            break;
        case 'video':
            newPostLi.innerHTML += "<iframe width='560' height='315' " +
                "src='http://www.youtube.com/embed/" + post.content_link + "' " +  
                "frameborder='0' allowfullscreen></iframe>";
            break;
    }
    newPostLi.innerHTML += text;
    newPostLi.innerHTML += "<ul class='reacties'><li>user: " +
        post.user + " </li></ul>";
    container.appendChild(newPost);
   
}



