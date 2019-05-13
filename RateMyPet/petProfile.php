<?php
    require_once __DIR__.'/include/Usuario.php';
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/selectPet.php';
    require_once __DIR__.'/include/Post.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
	<?php
		require("include/comun/header.php");
    ?>
    
    <div class="content">
        <h1>This is <?php echo ''.$pet->petName(); ?> the <?php echo ''.$pet->petType(); ?>'s Page</h1>
        <?php
            if($mine) {
                echo'
                    <form method="post" action="include/borrarPet.php?id='.$pet->owner_id().'&idpet='.$pet->petId().'">
                    <button class="borrar fa-lg hover-opacity"> Delete this pet
                        <i class="fa fa-times-circle-o fa-lg"></i></button>
                    </form>';
                echo '<p>Here you will be able to browse the pet\'s posts, as well as see everything related with the pet\'s ranking.</p>';
                echo '<h2>I belong to you!</h2>';
            } else {
                echo '<h2>This pet belongs to: <a href="ownerProfile.php?id='.$pet->owner_id().'">'.$name.'</a></h2>';
            }

            if ($verified) { // You are accepted by the community
                
            } else { // Make the profile invisible for other users
                echo '<h1>This profile is awaiting validation.</h1>';
            }
        ?>
        
        <?php 
            
        ?>
        <div class="display-pets">
            <img src="img/animals/<?php echo $pet->petType()?>.png"></a>
        </div>
        <?php
            echo '<p>'.$pet->petDescription().'</p>';
            echo '<h4><a href="followers.php?idPet='.$pet->petId().'&followersPets">Followers:</a> '.$pet->followerAmount().'</h4>';
            echo '<h4><i class="fa fa-paw" id="treatNum">'.$pet->treats().'</i></h4>';

            if (!$mine) {
                echo '
                <form method="post" action="include/giveTreat.php?idPet='.$pet->petId().'">
                    <input type="submit" class="button-create" value="Give a treat!">
                </form>
                ';
            }
            else{

                echo '<button type="button" class="button-create" onclick="window.location.href=\'updatePet.php?id='.$pet->petId().'\'">Edit</button>';
            }
        ?>

        <div class="pet-post">
            <h3>POST</h3>
            <?php
                if(!$mine) {
                    if ($following) {
                        echo '<button type="button" class="button-create" onclick="window.location.href=\'include/follow.php?action=unfollowPet&id2='.$pet->petId().'\'">Unfollow</button>';
                    } else {
                        echo '<button type="button" class="button-create" onclick="window.location.href=\'include/follow.php?action=followPet&id2='.$pet->petId().'\'">Follow</button>';
                    }
                }
                ?>
                <form method="POST" action="petPost.php">
                    <input type="hidden" name="idPet" value="<?php echo $_GET['idPet']; ?>">
                    <?php if ($mine) echo '<input class="button-create" type="submit" value="New Post">'; ?>
                </form>
                <?php
                $myPosts = Post::allPosts($pet->petId());
                if ($myPosts->num_rows > 0) { 
                    echo '<div class="posts">';
                    while($row = $myPosts->fetch_assoc()) {
                        $post = Post::buscaPost($row['idpost']);
                        
                        echo'<div class="fourinline container card">';
                        if($mine){
                            echo'
                            <form method="post" action="include/borrarPost.php?idpost='.$post->idPost().'&idpet='.$pet->petId().'">
                            <button class="borrar fa-lg hover-opacity">
                                <i class="fa fa-times-circle-o fa-lg"></i></button>
                            </form>';
                        }
                        echo '
                            <a href="postMascota.php?id='.$post->idPost().'"><img src="upload/posts/'.$post->idPost().'.jpg" style="width:100%" class="hover-opacity"></a>
                            <div class="container white">
                            <p>'.$post->title().'</p>
                            <p>'.$post->description().'</p>
                            <p class="iright"><i class="fa fa-heart like"></i>'.$post->likes().'</p>
                            </div>
                        </div>';
                    }
                    echo '</div>';
                }
                ?>
        </div>
        
	</div>

    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>