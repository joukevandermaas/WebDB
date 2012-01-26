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
                "<ul class='thumbs'>" + createVoteButton(1, post.id) + createVoteButton(-1, post.id) + "</ul><h5>" +
                post.title + "</h5>" + post.content;
            container.appendChild(elem);
        }
    }
}

function createVoteButton(type, pid) {
    var t = getName(type);
    var result = '<li><a class="' + t + '" href="#" onclick="doVote(' 
        + pid + ', ' + type + ')"></a></li>';
    return result;
}
function getName(type) {
    return type == 1 ? 'up' : 'down';
}