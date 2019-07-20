function selectLocation(e) {
    event.preventDefault();

    var locationSelected = e.innerText;
    document.getElementById('location').value = locationSelected;
    document.getElementById('location-suggestions').style.display = 'none';
}