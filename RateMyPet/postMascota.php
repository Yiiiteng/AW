<?php
	require_once __DIR__.'/include/Usuario.php';
	require_once __DIR__.'/include/Post.php';
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/Comment.php';//devuelve un objeto de tipo Post
    require_once __DIR__.'/include/selectPost.php';//devuelve un objeto de tipo Post
	
	//css a tope en esta vista uwu
?>

<!DOCTYPE html>
<html>
<head>
	<title>Post</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/content.css">
	<link rel="stylesheet" href="css/post.css">
</head>
<body>
	<?php
        require("include/comun/header.php");
	?>
    
	<div class="content">
		<?php

			if ($pending && ($me || $mod)) { // I'm the only one that can see this post (and a moderator)
				echo '<h1>This post needs to be verified.</h1>';
				echo ''.$post->toString(); // Print the Post
				echo '<div id="like">';
					echo '<form action="include/likePost.php" method="POST">'; // Like / dislike the post
						echo '<input type="hidden" name="post" value="'.$post->idpost().'">';
						if ($like) { // I already like the post
							echo '<input type="hidden" name="type" value="dislike">';
							echo '<button type="submit">Un-Pet</button>';
						} else { // I like the post
							echo '<input type="hidden" name="type" value="like">';
							echo '<button type="submit">Pet</button>';
						}
					echo '</form>'; // Like / dislike the post
				echo '</div>';
				echo '<div id="repet">';
					echo '<form action="include/repetPost.php" method="POST">'; // Like / dislike the post
						echo '<input type="hidden" name="post" value="'.$post->idpost().'">';
						if ($repet) { // I already like the post
							echo '<input type="hidden" name="type" value="dislike">';
							echo '<button type="submit">Un-Repet</button>';
						} else { // I like the post
							echo '<input type="hidden" name="type" value="like">';
							echo '<button type="submit">Repet</button>';
						}
					echo '</form>'; // Like / dislike the post
				echo '</div>';
				if ($mod) {
					if (!$me) {
						if (!$signed) {
							echo '
								<form action="include/verifyPost.php" method="POST">
									<input type="hidden" name="postId" value="'.$post->idpost().'">
									<button type="submit">Verify</button>
								</form>
							';
						} else {
							echo '<h1>You have already signed the petition. Awaiting aproval from the other mods.</h1>';
						}
					} 
				}
			} else { // Not pending || Not me
				echo ''.$post->toString(); // Print the Post
				echo '<div id="like">';
					echo '<form action="include/likePost.php" method="POST">'; // Like / dislike the post
						echo '<input type="hidden" name="post" value="'.$post->idpost().'">';
						if ($like) { // I already like the post
							echo '<input type="hidden" name="type" value="dislike">';
							echo '<button type="submit">Un-Pet</button>';
						} else { // I like the post
							echo '<input type="hidden" name="type" value="like">';
							echo '<button type="submit">Pet</button>';
						}
					echo '</form>'; // Like / dislike the post
				echo '</div>';
				echo '<div id="repet">';
					echo '<form action="include/repetPost.php" method="POST">'; // Like / dislike the post
						echo '<input type="hidden" name="post" value="'.$post->idpost().'">';
						if ($repet) { // I already like the post
							echo '<input type="hidden" name="type" value="dislike">';
							echo '<button type="submit">Un-Repet</button>';
						} else { // I like the post
							echo '<input type="hidden" name="type" value="like">';
							echo '<button type="submit">Repet</button>';
						}
					echo '</form>'; // Like / dislike the post
				echo '</div>';
			}

			if($comments->num_rows > 0) {
				echo '<h1>Comments</h1>';
				while($row = $comments->fetch_assoc()) {
					$comment = Comment::parseComment($row['idPost'], $row['idUser'], $row['idcomment']);
					echo $comment->toString();
				$likedComment = $_SESSION['user']->checkLikedComment($_GET['id'], $comment->idcomment());
				echo '<form action="include/likeComment.php" method="POST">'; // Like / dislike the post
					echo '<input type="hidden" name="post" value="'.$post->idpost().'">';
					echo '<input type="hidden" name="idComment" value="'.$comment->idcomment().'">';
					if ($likedComment) { // I already like the post
						echo '<input type="hidden" name="type" value="dislike">';
						echo '<button type="submit">Unlike comment</button>';
					} else { // I like the post
						echo '<input type="hidden" name="type" value="like">';
						echo '<button type="submit">Like comment</button>';
					}
				echo '</form>';
			}
		}
		else echo '<h1>No comments to display!</h1>';
		echo'<form method="POST" action="addComment.php">';
			echo '<input type="hidden" name="idPost" value="'.$post->idpost().'">';
			echo '<button type="submit">Add comment</button>';
		echo '</form>';		
		?>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>