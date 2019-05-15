function setPreview() {
    //Getting Value
    var selObj = document.getElementById("cover_image");
    var selValue = selObj.options[selObj.selectedIndex].text;
    
    //Setting Value
	document.getElementById("platform").value = selValue;
	console.log("Hello");
}
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
};