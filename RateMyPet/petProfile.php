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
                echo '<p>Here you will be able to browse the pet\'s posts, as well as see everything related with the pet\'s ranking.</p>';
                echo '<h2>I belong to you!</h2>';
            } else {
                echo '<h2>This pet belongs to: <a href="ownerProfile.php?id='.$pet->owner_id().'">'.$name.'</a></h2>';
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
                <form method="post" action="include/giveTreat.php?idPet='.$pet->petId().'&numtreat='.$pet->treats().'">
                    <input type="submit" class="button-create" value="Give a treat!">
                </form>
                ';
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
                } else {
                    echo '<button type="button" class="button-create" onclick="window.location.href=\'petPost.php\'">New Post</button>';
                    $myPosts = Post::allPosts($pet->petId());
                    if ($myPosts->num_rows > 0) { 
                        echo '<div class="posts">';
                        while($post = $myPosts->fetch_assoc()) {
                            echo '<div class="fourinline container card">';
                            if($mine){
                                echo '<i class="fa fa-times-circle borrar"></i>';
                            }
                                echo '
                                <img src="posts/'.$post['idpost'].'.png" style="width:100%" class="hover-opacity">
                                <div class="container white">
                                <p class="iright"><i class="fa fa-heart like"></i>'.$post['likes'].'</p>
                                </div>

                            </div>';
                        }
                        echo '</div>';
                    }
                }
            ?>
        </div>
        
	</div>

    <?php
		require("include/comun/footer.php");
	?>
</body>
</html>