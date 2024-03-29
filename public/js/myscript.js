var locationInput = document.getElementById('location-input');
if(locationInput){
    locationInput.addEventListener('keyup', getLocationSuggestions);
}

var locationSuggestionsContainer = document.getElementById('location-suggestions-container');

function getLocationSuggestions() {
    var locationInputValue = this.value;

    if(locationInputValue.length > 0) {
        if(window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            var xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open('POST', '/posts/get_location_suggestions', true);
        // Send the proper header information along with the request
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xmlhttp.send('location_input_value=' + locationInputValue);

        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                if(this.responseText.length > 0) {
                    locationSuggestionsContainer.style.display = 'block';
                    locationSuggestionsContainer.innerHTML = this.responseText;

                    var locationSuggestionRows = document.querySelectorAll('.location-suggestion-row');
                    if(locationSuggestionRows.length > 0) {
                        for(var i=0; i<locationSuggestionRows.length; i++) {
                            locationSuggestionRows[i].addEventListener('click', selectLocationSuggestion);
                        }
                    }
                }
            }
        };
    } else {
        locationSuggestionsContainer.style.display = 'none';
        locationSuggestionsContainer.innerHTML = '';
    }
}

function selectLocationSuggestion() {
    event.preventDefault();

    locationInput.value = this.innerText;
    document.getElementById('location_id').value = this.getAttribute('location-id');
    locationSuggestionsContainer.style.display = 'none';
}

var postsToBookmark = document.querySelectorAll('.post-to-bookmark');
if(postsToBookmark) {
    for(var i=0; i<postsToBookmark.length; i++) {
        postsToBookmark[i].addEventListener('click', bookmarkPost);
    }
}

function bookmarkPost()
{
    event.preventDefault();

    var post_id = this.getAttribute('bookmark-post-id');
    var postToBookmark = this;

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
            if(postToBookmark.innerText == '☆')
            {
                postToBookmark.innerHTML = '&#9733;';
                postToBookmark.title = 'Remove this post from bookmarks';
            }
            // Check if bookmarked, then remove it from bookmarks
            else if(postToBookmark.innerText == '★')
            {
                postToBookmark.innerHTML = '&#9734;';
                postToBookmark.title = 'Add this post to bookmarks';
            }
        }
    };

    return;
}

var siteType = document.getElementById('site-type');
if(siteType) {
    siteType.addEventListener('change', changeType);
}

function changeType()
{
    var site = this.getAttribute('site');
    var type = this.value;
    if(type === 'all')
    {
        window.location.href = '/' + site;
    }
    else
    {
        window.location.href = '/' + site + '/' + type;
    }
}

var imageAdderButton = document.getElementById('image-adder-button');
if(imageAdderButton) {
    imageAdderButton.addEventListener('click', addImage);
}

var image_i = 1;
function addImage() {
    event.preventDefault();

    var postForm = document.getElementById('post-form');
    var newDiv = document.createElement('div');
    newDiv.setAttribute('class', "form-group");
    postForm.appendChild(newDiv);
    var newLabel = document.createElement('label');
    newLabel.setAttribute('for', 'image_' + image_i);
    newDiv.appendChild(newLabel);
    var labelTxt = document.createTextNode(image_i + '. image');
    newLabel.appendChild(labelTxt);
    var newDiv2 = document.createElement('div');
    newDiv.appendChild(newDiv2);
    var newFileInput = document.createElement('input');
    newFileInput.setAttribute('type', 'file');
    newFileInput.setAttribute('name', 'image_' + image_i);
    newFileInput.setAttribute('id', 'image_' + image_i);
    newFileInput.setAttribute('class', 'images');
    newFileInput.setAttribute('accept', '.jpg, .jpeg, .png, .gif');
    newDiv2.appendChild(newFileInput);
    var imageAdderButton = document.getElementById('imageAdderButton');
    postForm.insertBefore(newDiv, imageAdderButton);
    image_i++;
}

var numberOfImagesSender = document.getElementById('number-of-images-sender');
if(numberOfImagesSender) {
    numberOfImagesSender.addEventListener('click', sendNumberOfImages);
}

function sendNumberOfImages() {
    var images = document.getElementsByClassName('images');
    var numberOfImages = document.getElementById('numberOfImages');
    numberOfImages.value = images.length;
}