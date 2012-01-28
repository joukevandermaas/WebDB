var request;
function loadContent(id, page, type) {
    request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
    request.open("GET", type == 'post' ? getPostUrl(id, page) : getCommentUrl(id, page), true);
    request.onreadystatechange = type == 'post' ? createPostList : createCommentList;
    request.send(null);
}
function getPostUrl(id, page) {
    return "dynamic/contentlist.php?id=" + id + "&page=" + page + "&type=post&climit=128";
}
function getCommentUrl(id, page) {
    return "dynamic/contentlist.php?id=" + id + "&page=" + page + "&type=comment&climit=0";
}

function createPostList() {
    createList('posts', generatePostInnerHTML);
}
function createCommentList() {
    createList('comments', generateCommentInnerHTML);
}
function createList(containerId, innerHTML) {
    if (request.readyState == 4 && request.status == 200) {
        var container = document.getElementById(containerId);
        var items = JSON.parse(request.responseText);
        
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var elem = document.createElement('li');
            if (i % 2 == 0)
                elem.setAttribute('class', 'inspringR');
            var html = innerHTML(item);
            elem.innerHTML = html;
            container.appendChild(elem);
        }
    }
}
function generatePostInnerHTML(post) {
    return "<ul class='thumbs'>" + createVoteButton(1, post.id) + 
        createVoteButton(-1, post.id) + "</ul><h5>" +
        "<a href='post.php?id=" + post.id + "'>" + 
        post.title + "</a></h5>" + post.content +
        "<ul class='reacties'><li>comments: " + 
        post.comment_count + " </li> <li>user: " +
        post.user_id + " </li> <li>time: " + post.timestamp + "</li></ul>";
}
function generateCommentInnerHTML(comment) {
    return comment.content + "<ul class='reacties'><li>user: " + 
        comment.user_id + "</li><li>time: " 
        + comment.timestamp + "</li></ul>";
}

function createVoteButton(type, pid) {
    var t = getName(type);
    var result = '<li><a class="' + t + '" href="#" onclick="doVote(' 
        + pid + ', ' + type + ', this)"></a></li>';
    return result;
}
function getName(type) {
    return type == 1 ? 'up' : 'down';
}
