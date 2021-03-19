<?php  include('database.php');

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;

// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM posts WHERE id=$id");

		if (count(array($record)) == 1 ) {
			$n = mysqli_fetch_array($record);
			$title = $n['title'];
			$comment = $n['comment'];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>CRUD: CReate, Update, Delete PHP MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php if (isset($_SESSION['message'])): ?>
    <div class="msg">
      <?php 
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
      ?>
    </div>
  <?php endif ?>
  <div class="heading">
		<h2 style="font-style: 'Hervetica';">BLOG Post CRUD Functionality</h2>
	</div><br><br>
  
	<form method="POST" action="database.php" >
		<div class="input-group">
			<label>Title</label><br>
			<input type="text" name="title" value="<?php echo $title; ?>" required>
      <input type="hidden" name="id" value="<?php echo $id; ?>">
		</div>
		<div class="input-group">
			<label>Comment</label><br>
			<input type="text" name="comment" value="<?php echo $comment; ?>" required>
		</div>
		<div class="input-group">
      <?php if ($update == true): ?>
	      <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
      <?php else: ?>
        <button class="btn" type="submit" name="post" >Post</button>
      <?php endif ?>
		</div>
	</form>

  <?php $results = mysqli_query($db, "SELECT * FROM posts"); ?>


  <br><br><br>
  <div class="post-container">
    <h2>Posts</h2>
    <?php while ($row = mysqli_fetch_array($results)) { ?>

        <div class="text">
          <p style="color: black;"><?php echo $row['title']; ?></p>
          <p style="color: grey;"><?php echo $row['comment']; ?></p><br>
        </div><br>
        <div>
          <a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
          <a href="database.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
        </div>
    <?php } ?>
  </div>

</body>
</html>