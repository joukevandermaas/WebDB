var request;
function submitForm(program_id, user_id)
{ 
    request =(window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");;
	
	var text = encodeURIComponent(document.getElementById("text").value);
	var title = encodeURIComponent(document.getElementById("title").value);
	var param = 'text='+ text + '&title=' + title;
	
    request.open("POST", "writePost.php?id=" + program_id + "&user=" + user_id,  true); 
	request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.onreadystatechange = createPost;
    request.send(param);
}
function createPost() {
	if (request.readyState == 4)// && request.status == 200)
    {	
		document.getElementById("show").innerHTML= request.responseText;
	}
}