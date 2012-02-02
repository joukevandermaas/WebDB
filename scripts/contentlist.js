var request;
var page = 0;
function loadContent(id, type) {
    // ask the server for the posts/comments
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
        // increase the page, so the next time the user clicks
        // the load more link, it will display different posts
        page++; 
        
        // if there's no more items, remove the link
        if (items.length == 0) {
            var link = document.getElementById('moar');
            link.parentNode.removeChild(link); 
        }
    
        // add the items to the list
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var elem = document.createElement('li');
            if (i % 2 == 0) // the items differ in color based on their position in the list
                elem.setAttribute('class', 'inspringR');
            var html = innerHTML(item);
            elem.innerHTML = html;
            container.appendChild(elem);
        }
    }
}
function generatePostInnerHTML(post) {
    // add the vote buttons and the title
    var html = "<ul class='thumbs'>" + createVoteButton(1, post.id) + 
        createVoteButton(-1, post.id) + "</ul><h5>" +
        "<a href='post.php?id=" + post.id + "'>" + 
        post.title + "</a></h5>";
    
    // if there's a movie or image, add that first
    switch(post.type) {
        case 'image':
            html += "<img src='" + post.content_link + "' alt='Afbeelding' />"; 
            break;
        case 'video':
            html += "<iframe width='560' height='315' " +
                "src='http://www.youtube.com/embed/" + post.content_link + "' " +  
                "frameborder='0' allowfullscreen></iframe>";
            break;
    }
    
    // add any descriptions (for images/videos) or actual content
    // and some metadata (user, time, etc)
    html +=  post.content +
        "<ul class='reacties'><li><a href='post.php?id=" + post.id + 
        "#comments'>" + post.comment_count + " comment(s)" 
        + "</a></li> <li>Door " +
        post.firstname + " " + post.lastname + 
        " </li> <li>" + post.timestamp + "</li></ul>";
    return html;
}
function generateCommentInnerHTML(comment) {
    // add the content and metadata
    return comment.content + "<ul class='reacties'><li>user: " + 
        comment.firstname + " " + comment.lastname + 
        "</li><li>tijd: " + comment.timestamp + "</li></ul>";
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
