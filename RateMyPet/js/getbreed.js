
// Global Arrays to store the name of the breeds for a faster access

var Dog = [
    "Labrador Retriever",
    "Bulldog",
    "Caniche",
    "Beagle",
    "German Shepherd Dog",
    "Golden Retriever",
    "French Bulldog",
    "Boxers",
    "Yorkshire Terrier",
    "Rottweiler",
    "Welsh Corgie"
]

var Cat = [
    "Abyssinian",
    "Aegean",
    "Bengal",
    "Bombay",
    "Burmese",
    "Khao Manee",
    "Lykoi", 
    "Manx",
    "Pixie-bob"
]

var Hamster = [
    "Syrian",
    "Robo",
    "Winter White",
    "Chinese",
    "Campbell"           
]

var Rabbit = [
    "Lionhead",
    "Flemish Giant",
    "Holland Lop",
    "Continental Giant",
    "Netherland Dwarf",
    "Dutch Rabbit",
    "English Lop",
    "French Lop",
    "Mini Rex"            
]

var Bird = [
    "Canary",
    "Budgy",
    "Finch",
    "Cocktiel",
    "Quaker Parakeet",
    "Parrot",
    "Lovebird"
]

// JS Function to set the Select "Breeds" HTML depending on the Animel

function getBreed() {
    var animal = document.getElementById("petType");
    var option = animal.options[animal.selectedIndex].value;
    let html = "";
    switch (option) {
        case "Dog":
            console.log("Dog");
            html = '<td>Breed: </td>';
            html += '<td>';
            html += '<select class="form-control" id="breed" type="text" name="breed">';
            for (let i = 0; i < Dog.length; i++) {
                html += '<option value="';
                html += Dog[i] + '">' + Dog[i] + '</option>';
            }
            html += '</select>';
            html += '</td>';
            document.getElementById("breed").innerHTML = html;
            break;
        case "Cat":
            console.log("Cat");
            html = '<td>Breed: </td>';
            html += '<td>';
            html += '<select class="form-control" id="breed" type="text" name="breed">';
            for (let i = 0; i < Cat.length; i++) {
                html += '<option value="';
                html += Cat[i] + '">' + Cat[i] + '</option>';
            }
            html += '</select>';
            html += '</td>';
            document.getElementById("breed").innerHTML = html;
            break;
        case "Hamster":
            console.log("Hamster");
            html = '<td>Breed: </td>';
            html += '<td>';
            html += '<select class="form-control" id="breed" type="text" name="breed">';
            for (let i = 0; i < Hamster.length; i++) {
                html += '<option value="';
                html += Hamster[i] + '">' + Hamster[i] + '</option>';
            }
            html += '</select>';
            html += '</td>';
            document.getElementById("breed").innerHTML = html;
            break;
        case "Rabbit":
            console.log("Rabbit");
            html = '<td>Breed: </td>';
            html += '<td>';
            html += '<select class="form-control" id="breed" type="text" name="breed">';
            for (let i = 0; i < Rabbit.length; i++) {
                html += '<option value="';
                html += Rabbit[i] + '">' + Rabbit[i] + '</option>';
            }
            html += '</select>';
            html += '</td>';
            document.getElementById("breed").innerHTML = html;
            break;
        case "Bird":
            console.log("Bird");
            html = '<td>Breed: </td>';
            html += '<td>';
            html += '<select class="form-control" id="breed" type="text" name="breed">';
            for (let i = 0; i < Bird.length; i++) {
                html += '<option value="';
                html += Bird[i] + '">' + Bird[i] + '</option>';
            }
            html += '</select>';
            html += '</td>';
            document.getElementById("breed").innerHTML = html;
            break;
        default:
            html = '<td>Breed: </td>';
            html += '<td>';
            html += '<select class="form-control" id="breed" type="text" name="breed">';
            html += '<option value="None">-</option>';
            html += '</select>';
            html += '</td>';
            document.getElementById("breed").innerHTML = html;
        break;
    }
}