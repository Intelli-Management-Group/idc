<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){

	$stmt1 = $db->prepare('SELECT postID, image FROM blog_posts WHERE postID = :postID') ;
	$stmt1->execute(array(':postID' => $_GET['delpost']));
	$row1 = $stmt1->fetch();
	unlink('../uploads/'.$row1['image']);

	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	//delete post categories.
	$stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>
	<div id="wrapper">

	<?php include('menu.php');?>

	<?php
	//show message from add / edit page
	if(isset($_GET['action'])){
		echo '<h3>Post '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Title</th>
		<th>Image</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT postID, postTitle,image, postDate FROM blog_posts ORDER BY postDate DESC');
			while($row = $stmt->fetch()){

				echo '<tr>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td><img src="../uploads/'.$row['image'].'" height="50" /></td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> |
					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo addslashes($row['postTitle']);?>')">Delete</a>
				</td>

				<?php
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-post.php'>Add Post</a></p>

</div>

</body>
</html>
