function getLocation(e) {
    var location = e.value;

    if(e.value.length > 0) {
        if(window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            var xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open('POST', '/posts/getlocation', true);
        // Send the proper header information along with the request
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xmlhttp.send('location=' + location);

        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                if(this.responseText.length > 0) {
                    document.getElementById('location-suggestions').style.display = 'block';
                    document.getElementById('location-suggestions').innerHTML = this.responseText;
                }
            }
        };
    } else {
        document.getElementById('location-suggestions').style.display = 'none';
        document.getElementById('location-suggestions').innerHTML = '';
    }
}