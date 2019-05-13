<?php
require_once __DIR__ . '/include/Aplicacion.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/selectPet.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rate My Pet: Post</title>
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/slider.css">
</head>
<?php
require("include/comun/header.php");
?>
<div class="content">
    <?php
    echo '<h1>Is ' . $pet->petName() . ' a ' . $pet->petType() . '?</h1>';
    // Image of the pet
    // How much of a Dog is this

    echo '<form>';
    echo '<div class="slidecontainer">
        <p>How much of a ' . $pet->petType() . ' is ' . $pet->petName() . '?</p>
        <input onChange="otherType()" type="range" min="1" max="100" value="100" class="slider" id="myRange"><span oninput="percentageA()" id="a">100%</span>
    </div>';
    echo '<div id="other"></div>';
    echo '<button type="submit">Send</button>';
    echo '</form>'
    ?>
</div>
<?php
require("include/comun/footer.php");
?>
<script src="js/imagePreview.js"></script>
<script>

    function percentageA() {
        var x = document.getElementById("myRange").value;
        document.getElementById("a").innerHTML = x + '%';
    }

    function otherType() {
        var string = "";
        string += '<select class="form-"control" id="petType" type="text" name="petType">';
        string += '<option value="Dog">Dog</option>';
        string += '<option value="Cat">Cat</option>';
        string += '<option value="Hamster">Hamster</option>';
        string += '<option value="Rabbit">Rabbit</option>';
        string += '</select>';
        var slider = "";
        slider += '<div class="slidecontainer">';
        slider += '<p>How much of a ' + string + ' is <?php echo $pet->petName() ?></p>';
        slider += '<input type="range" min="1" max="100" value="100" class="slider" id="otherRange">';
        slider += '</div>';
        var x = document.getElementById("myRange").value;
        console.log(x);
        var all = "";
        if (parseInt(x) < "60") {
            all = all + '<div id="other">';
            all += slider;
            all = all + '</div>';
            document.getElementById("other").innerHTML = all;
        } else {
            document.getElementById("other").innerHTML = '<div id="other"></div></div>';
        }
        document.getElementById("a").innerHTML = x + '%';
    }
</script>
</body>

</html>