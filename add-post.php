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
  <title>Admin - Add Post</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
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

	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

	//	$_POST = array_map( 'stripslashes', $_POST );
    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];
    $postTitle = $_POST['postTitle'];
    $postDesc = $_POST['postDesc'];
    $postCont = $_POST['postCont'];
    $catID = $_POST['catID'];
    $imageCaption = $_POST['imageCaption'];
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
    if(empty($imgFile)){
     $blog_img = NULL;
    }
    else{
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
    if(!isset($error)){
        date_default_timezone_set('America/Los_Angeles');
        $postSlug = slug($postTitle);
				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postSlug,postDesc,postCont,authorCreated,postDate,editDate,image,imageCaption) VALUES (:postTitle, :postSlug, :postDesc, :postCont, :authorCreated, :postDate,:editDate, :image_file, :imageCaption)') ;
        $stmt->bindParam(':postTitle',$postTitle);
        $stmt->bindParam(':postSlug',$postSlug);
        $stmt->bindParam(':postDesc',$postDesc);
        $stmt->bindParam(':postCont',$postCont);
        $stmt->bindParam(':authorCreated',$_SESSION['author']);
        $stmt->bindParam(':image_file',$blog_img);
        $stmt->bindParam(':imageCaption',$imageCaption);
        $stmt->bindParam(':postDate',date('Y-m-d H:i:s'));
        $stmt->bindParam(':editDate',date('Y-m-d H:i:s'));
        if($stmt->execute())
           {
             $postID = $db->lastInsertId();

      				//add categories
      				if(is_array($catID)){
      					foreach($_POST['catID'] as $catID){
      						$stmt = $db->prepare('INSERT INTO blog_post_cats (postID,catID)VALUES(:postID,:catID)');
      						$stmt->execute(array(
      							':postID' => $postID,
      							':catID' => $catID
      						));
      					}
      				}
              else{
                $error[]="Cat not inserted";
              }
            $successMSG = "new record succesfully inserted ...";
            header('Location: index.php?action=added'); // redirects image view page after 5 seconds.
           }
           else
           {
            $error[] = "error while inserting....";
           }


          }
	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' enctype='multipart/form-data'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>' style="width: 100%;"></p>

		<p><label>Summary</label><br />
		<textarea name='postDesc' cols='60' rows='5' maxlength="100"><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='15'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
    <fieldset>
    			<legend>Categories</legend>

    			<?php

    			$stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');
          $checked = null;
          while($row2 = $stmt2->fetch()){

    				if(isset($_POST['catID'])){

    					if(in_array($row2['catID'], $_POST['catID'])){
                           $checked="checked='checked'";
                        }
    				}

    			    echo "<input type='checkbox' name='catID[]' value='".$row2['catID']."'".$checked."> ".$row2['catTitle']."<br />";
    			}

    			?>

    </fieldset>
    <p><label>Image</label><br />
		<input type='file' name='user_image' accept='image/*' /><?php if(isset($error)){ echo $imgFile;}?></p>

    <p><label>Image Caption</label><br />
    <input type='text' name='imageCaption' value='<?php if(isset($error)){ echo $_POST['imageCaption'];}?>' style="width: 100%;"></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
