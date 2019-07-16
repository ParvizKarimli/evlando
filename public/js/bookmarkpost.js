function bookmarkPost(e)
{
    event.preventDefault();

    var post_id = e.getAttribute('bookmark-post-id');

    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        var xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open('POST', '/bookmarks/bookmark', true);
    // Send the proper header information along with the request
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send('post_id=' + post_id);

    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            // Check if not bookmarked, then bookmark it
            if(e.innerHTML == '<i class="far fa-star"></i>')
            {
                e.innerHTML = '<i class="fas fa-star"></i>';
                e.title = 'Remove this post from bookmarks';
            }
            // Check if bookmarked, then remove it from bookmarks
            else if(e.innerHTML == '<i class="fas fa-star"></i>')
            {
                e.innerHTML = '<i class="far fa-star"></i>';
                e.title = 'Add this post to bookmarks';
            }
        }
    };

    return;
}