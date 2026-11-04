<?php
error_reporting( ~E_NOTICE ); // avoid notice
ini_set('display_errors', 1);
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Post</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Edit Post</h2>


	<?php
  try {

    $stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont, image, imageCaption, newsSource, postDate FROM blog_posts WHERE postID = :postID') ;
    $stmt->execute(array(':postID' => $_GET['id'] ?? 0));
    $row = $stmt->fetch();
    if (!$row) {
      header('Location: index.php');
      exit;
    }

  } catch(PDOException $e) {
      echo $e->getMessage();
  }
	//if form has been submitted process it
	if(isset($_POST['submit'])){

	//$_POST = array_map( 'stripslashes', $_POST );

//	collect form data

  $postID       = $row['postID'];
  $postTitle    = $_POST['postTitle'] ?? '';
  $postDesc     = $_POST['postDesc'] ?? '';
  $postCont     = $_POST['postCont'] ?? '';
  $postDate     = $_POST['postDate'] ?? '';
  $newsSource   = $_POST['newsSource'] ?? '';
  $imageCaption = $_POST['imageCaption'] ?? '';
  $catID        = $_POST['catID'] ?? null;
  $imgFile = $_FILES['user_image']['name'] ?? '';
  $tmp_dir = $_FILES['user_image']['tmp_name'] ?? '';
  $imgSize = $_FILES['user_image']['size'] ?? 0;
  $format = strtotime($postDate);
  $postDate = $format === false ? '' : date('Y-m-d', $format);
		//very basic validation
    if(empty($postTitle)){
			$error[] = 'Please enter the title.';
		}
		if(empty($postDesc)){
			$error[] = 'Please enter the description.';
		}

		if(empty($postCont)){
			$error[] = 'Please enter the content.';
		}
        if(empty($postDate)){
            $error[] = 'Please enter the date.';
        }
        if(empty($newsSource)){
            $error[] = 'Please enter the news source.';
        }
    if(empty($catID)){
			$error[] = 'Please enter the category.';
		}
    if($imgFile){
      if(empty($imageCaption)){
  			$error[] = 'Please enter the Image Caption.';
  		}
    $upload_dir = "../uploads/"; //set upload folder path
    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

    // rename uploading image
    $blog_img = "zoeNews_".date('ymdHis').".".$imgExt;
    // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){
     // Check file size '5MB'
     if($imgSize < 5000000)    {
       if (!empty($row['image']) && is_file('../uploads/'.basename($row['image']))) {
         unlink('../uploads/'.basename($row['image']));
       }
       move_uploaded_file($tmp_dir,$upload_dir.$blog_img);
     }
     else{
      $error[] = "Sorry, your file is too large.";
     }
    }
    else{
     $error[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
   }
   else
  {
   // if no image selected the old image remain as it is.
   $blog_img = $row['image']; // old image from database
  }

		if(!isset($error)){
      date_default_timezone_set('America/Los_Angeles');
        //insert into database
        $postSlug = slug($postTitle);
				$stmt = $db->prepare('UPDATE blog_posts SET postTitle = :postTitle, postSlug = :postSlug, postDesc = :postDesc, postCont = :postCont,authorUpdated = :authorUpdated, postDate = :postDate, image = :image_file, imageCaption = :imageCaption, newsSource = :newsSource WHERE postID = :postID');
        $stmt->bindParam(':postTitle',$postTitle);
        $stmt->bindParam(':postSlug',$postSlug);
        $stmt->bindParam(':postDesc',$postDesc);
        $stmt->bindParam(':postCont',$postCont);
        $stmt->bindParam(':authorUpdated',$_SESSION['author']);
        $stmt->bindParam(':image_file',$blog_img);
        $stmt->bindParam(':imageCaption',$imageCaption);
        $stmt->bindParam(':newsSource',$newsSource);
        $stmt->bindParam(':postDate',$postDate);
        $stmt->bindParam(':postID',$postID);

        if($stmt->execute())
           {
             //delete all items with the current postID
      				$stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
      				$stmt->execute(array(':postID' => $postID));

      				if(is_array($catID)){
      					foreach($_POST['catID'] as $catID){
      						$stmt = $db->prepare('INSERT INTO blog_post_cats (postID,catID)VALUES(:postID,:catID)');
      						$stmt->execute(array(
      							':postID' => $postID,
      							':catID' => $catID
      						));
      					}
      				}
            $successMSG = "new record succesfully inserted ...";
            header('Location: index.php?action=updated');
            exit;
           }
           else
           {
            $error[] = "error while inserting....";
           }
          }

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>' style="width: 100%;"></p>

		<p><label>Summary</label><br />
		<textarea name='postDesc' cols='60' rows='5' maxlength="100"><?php echo $row['postDesc'];?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='15'><?php echo $row['postCont'];?></textarea></p>

    <fieldset>
			<legend>Categories</legend>

			<?php

			$stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');
			while($row2 = $stmt2->fetch()){

				$stmt3 = $db->prepare('SELECT catID FROM blog_post_cats WHERE catID = :catID AND postID = :postID') ;
				$stmt3->execute(array(':catID' => $row2['catID'], ':postID' => $row['postID']));
				$row3 = $stmt3->fetch();

				if($row3 && $row3['catID'] == $row2['catID']){
					$checked = 'checked=checked';
				} else {
					$checked = null;
				}

			    echo "<input type='checkbox' name='catID[]' value='".$row2['catID']."'" .$checked."> ".$row2['catTitle']."<br />";
			}

			?>

		</fieldset>

    <p><label>Image</label><br />
    <img src="../uploads/<?php echo $row['image']; ?>" height="100" /><br>
    <input type='file' name='user_image' accept='image/*' /><?php if(isset($error)){ echo $imgFile;}?></p>

    <p><label>Image Caption</label><br />
    <input type='text' name='imageCaption' value='<?php echo $row['imageCaption'];?>' style="width: 100%;"></p>

        <p><label>Select Date</label><br />
            <input name='postDate' type='text' id='postDate' value='<?php echo $row['postDate'];?>' style="width: 25%;">
        </p>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                $('#postDate').datepicker({
                    format: "yyyy/mm/dd"
                });
            });
        </script>

        <p><label>News Source</label><br />
            <input type='text' name='newsSource' value='<?php echo $row['newsSource'];?>' style="width: 100%;"></p>

        <p><input type='submit' name='submit' value='Update'></p>

	</form>

</div>

</body>
</html>
