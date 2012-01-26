var request;
function loadPosts(id, page) {
    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
    request.open("GET", "tools/posts.php?id=" + id + "&page=" + page, true);
    request.onreadystatechange = createPostList;
    request.send(null);
}
function createPostList() {
    if (request.readyState == 4)// && request.status == 200)
    {
        //alert(request.responseText);
        var container = document.getElementById('posts');
        var posts = JSON.parse(request.responseText);
        
        for (var i = 0; i < posts.length; i++) {
            var post = posts[i];
            var elem = document.createElement('li');
            if (i % 2 == 0)
                elem.setAttribute('class', 'inspringR');
            elem.innerHTML =
                "<ul class='thumbs'><li><img src='img/thumbsup.png'></li>" + 
                "<li><img src='img/thumbsdown.png'></li></ul><h5>" +
                post.title + "</h5>" + post.content;
            container.appendChild(elem);
        }
    }
}