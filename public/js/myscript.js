var locationInput = document.getElementById('location-input');
locationInput.addEventListener('keyup', getLocationSuggestions);

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