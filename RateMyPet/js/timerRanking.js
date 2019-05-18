// This JavaScript function is a Timer to the next closest 10 minute range - This is the time until the Rankings get reset

var deadline = new Date();
var aux = roundTimeTenMinutes(deadline);
deadline = aux;

var x = setInterval(function () {
    var now = new Date().getTime();
    var t = deadline - now;
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((t % (1000 * 60)) / 1000);

    // This function allows the Programmer to make the timer more specific

    /*var html = "";
    if (days > 0) html += days + "d ";
    if (hours > 0) html += hours + "h ";
    if (minutes > 0) html += minutes + "m ";
    if (seconds > 0) html += seconds + "s ";*/

    document.getElementById("timer").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    if (t < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "0d 0h 0m 0s";
        // We can use AJAX to call a function manually, but we preffer to use phpmyadmin EVENTS to handle this
        // var url = "include/resetTreats.php";
        // $.get(url,result);
        location.reload(true); // Reload the page
    }
}, 1000);

console.log(aux);

function roundTimeTenMinutes(time) {
    var timeToReturn = new Date(time);
    timeToReturn.setMilliseconds(Math.ceil(time.getMilliseconds() / 1000) * 1000);
    timeToReturn.setSeconds(Math.ceil(timeToReturn.getSeconds() / 60) * 60);
    timeToReturn.setMinutes(Math.ceil(timeToReturn.getMinutes() / 10) * 10); // Ceil -> Closest Highest Interval
    return timeToReturn;
}

function result(a, b) {
    console.log("Hello");
}

