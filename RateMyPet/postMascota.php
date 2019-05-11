<?php
	require_once __DIR__.'/include/Usuario.php';
	require_once __DIR__.'/include/Post.php';
    require_once __DIR__.'/include/config.php';
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
</head>
<body>
	<?php
        require("include/comun/header.php");
	?>
    
	<div class="content">
		<?php
			if ($mod) { // You are a mod
				if ($pending) {
					echo '<h1>This post needs to be verified.</h1>';
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
			} else { // You are not a mod
				echo ''.$post->toString();
			}
		?>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>