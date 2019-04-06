let loadFile = function(event) {
    let output = document.getElementById('output');
    let img = new Image();
    
    output.src = URL.createObjectURL(event.target.files[0]);
}