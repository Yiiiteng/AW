<?php
require_once __DIR__ . '/include/Aplicacion.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/selectPet.php';
require_once __DIR__ . '/include/getVerification.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rate My Pet: Post</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/slider.css">
</head>
<?php
require("include/comun/header.php");
?>
<div class="content">
    <h1>Pet Verification</h1>
    <p>Here you will be able to decide whether or not the following pet is legible for being a part of the community.</p>
    <p>If <?php echo ''.$pet->petName(); ?> gets accepted, he will be able to post some cute pictures!</p>
    <p>Note: a rating of less than 60% will mean that this pet is not the type of animal the owner says it is. Please choose the pet you truly think <?php echo ''.$pet->petName(); ?> represents.</p>
    <?php
    echo '<h1>Is ' . $pet->petName() . ' a ' . $pet->petType() . '?</h1>';
    echo '<img src="'.$pet->getImageSrc().'">';
    if ($you) { // If you have verified Him
        echo '<h1>You have already voted</h1>';
    } else if ($pet->owner_id() == $_SESSION['user']->id()) { // It's yours
        echo '<h1>You can\'t vote for your own pet!</h1>';
    } else { // Already verified   
        echo '<form action="include/votePet.php" method="POST">';
        echo '<div class="slidecontainer">
            <h2>How much of a ' . $pet->petType() . ' is ' . $pet->petName() . '?</h2>
            <input name="animal_A" onChange="otherType()" type="range" min="1" max="100" value="100" class="slider" id="myRange"><h1 oninput="percentageA()" id="a">100%</h1>
        </div>';
        echo '<div id="other"></div>';
        echo '<input type="hidden" name="petId" value="'.$pet->petId().'">';
        echo '<input type="submit" class="button-create" value="Vote">';
        echo '</form>';
    }
    ?>
</div>
<?php
require("include/comun/footer.php");
?>
<script src="js/imagePreview.js"></script>
<script>
    // This function needs to be here so we can set the HTML in a nice way (we need to use the PHP variable: $pet)
    function percentageA() {
        var x = document.getElementById("myRange").value;
        document.getElementById("a").innerHTML = x + '%';
    }

    function percentageB() {
        var x = document.getElementById("otherRange").value;
        document.getElementById("b").innerHTML = x + '%';
    }

    function otherType() {
        var string = "";
        string += '<select class="form-"control" id="petType" type="text" name="petType" required>';
        string += '<option value="Dog">Dog</option>';
        string += '<option value="Cat">Cat</option>';
        string += '<option value="Hamster">Hamster</option>';
        string += '<option value="Rabbit">Rabbit</option>';
        string += '</select>';
        var slider = "";
        slider += '<div class="slidecontainer">';
        slider += '<p>How much of a ' + string + ' is <?php echo $pet->petName(); ?>?</p>';
        slider += '<input name="animal_B" onChange="otherTypeValue()" type="range" min="1" max="100" value="100" class="slider" id="otherRange"><h1 id="b">100%</h1>';
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

    function otherTypeValue() {
        var x = document.getElementById("otherRange").value;
        document.getElementById("b").innerHTML = x + '%';
    }
</script>
</body>

</html>