var i = 1;
function addImage() {
	var postForm = document.getElementById('postForm');
	var newDiv = document.createElement('div');
	newDiv.setAttribute('class', "form-group");
	postForm.appendChild(newDiv);
	var newLabel = document.createElement('label');
	newLabel.setAttribute('for', 'image_' + i);
	newDiv.appendChild(newLabel);
	var labelTxt = document.createTextNode(i + '. image');
	newLabel.appendChild(labelTxt);
	var newDiv2 = document.createElement('div');
	newDiv.appendChild(newDiv2);
	var newFileInput = document.createElement('input');
	newFileInput.setAttribute('type', 'file');
	newFileInput.setAttribute('name', 'image_' + i);
	newFileInput.setAttribute('id', 'image_' + i);
	newFileInput.setAttribute('class', 'images');
	newFileInput.setAttribute('accept', '.jpg, .jpeg, .png, .gif');
	newDiv2.appendChild(newFileInput);
	var imageAdderButton = document.getElementById('imageAdderButton');
	postForm.insertBefore(newDiv, imageAdderButton);
	i++;
}
function sendNumberOfImages() {
	var images = document.getElementsByClassName('images');
	var numberOfImages = document.getElementById('numberOfImages');
	numberOfImages.value = images.length;
}