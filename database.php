<?php 
	session_start();
	$db = mysqli_connect('localhost', 'root', '', 'todo');

	// initialize variables
	$title = "";
	$comment = "";
	$id = 0;
	$update = false;

  // add post to database
	if (isset($_POST['post'])) {
		$title = $_POST['title'];
		$comment = $_POST['comment'];

		mysqli_query($db, "INSERT INTO posts (title, comment) VALUES ('$title', '$comment')"); 
		$_SESSION['message'] = "Post saved"; 
		header('location: index.php');
	}

  // update button
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $comment = $_POST['comment'];
  
    mysqli_query($db, "UPDATE posts SET title='$title', comment='$comment' WHERE id=$id");
    $_SESSION['message'] = "Post updated!"; 
    header('location: index.php');
  }

  // deleting records
  if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM posts WHERE id=$id");
    $_SESSION['message'] = "Post deleted!"; 
    header('location: index.php');
  }