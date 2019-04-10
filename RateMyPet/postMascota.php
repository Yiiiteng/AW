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
			echo ''.Post::toString($postSimple);
		?>
	</div>

	<?php
		require("include/comun/footer.php");
	?>
</body>
</html>