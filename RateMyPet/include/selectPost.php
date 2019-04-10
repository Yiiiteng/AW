<?php

if (isset($_GET['id'])) { // Check who the requested user is
    $sql = 'SELECT * FROM posts WHERE idpost = '.$_GET['id']; // Return the user
    $data = $conn->query($sql);
    $postSimple = $data->fetch_assoc();
    $post = Post::buscaPost($postSimple['idpost']);
    if(!$post) {
        header('Location: error.php');
    }
  
} else { // You shouldn't be here
    header('Location: error.php');
}
?>