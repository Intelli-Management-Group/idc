<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit User</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">User Admin Index</a></p>

	<h2>Edit User</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		$memberID = $_POST['memberID'] ?? '';
		$username = trim($_POST['username'] ?? '');
		$password = $_POST['password'] ?? '';
		$passwordConfirm = $_POST['passwordConfirm'] ?? '';
		$email = trim($_POST['email'] ?? '');
		$fullname = trim($_POST['fullname'] ?? '');

		//very basic validation
		if($username ==''){
			$error[] = 'Please enter the username.';
		}

		if( strlen($password) > 0){

			if($password ==''){
				$error[] = 'Please enter the password.';
			}

			if($passwordConfirm ==''){
				$error[] = 'Please confirm the password.';
			}

			if($password != $passwordConfirm){
				$error[] = 'Passwords do not match.';
			}

		}


		if($email ==''){
			$error[] = 'Please enter the email address.';
		}
    if($fullname ==''){
			$error[] = 'Please enter the Full Name.';
		}
		if(!isset($error)){

			try {

				if(strlen($password) > 0){

					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

					//update into database
          $ucName = ucwords($fullname);
					$stmt = $db->prepare('UPDATE blog_members SET username = :username, password = :password, email = :email , fullname = :fullname WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':password' => $hashedpassword,
						':email' => $email,
            ':fullname' => $ucName,
						':memberID' => $memberID
					));


				} else {

					//update database
          $ucName = ucwords($fullname);
					$stmt = $db->prepare('UPDATE blog_members SET username = :username, email = :email, fullname = :fullname WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':email' => $email,
            ':fullname' => $ucName,
						':memberID' => $memberID
					));

				}


				//redirect to index page
				header('Location: users.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT memberID, username, email, fullname FROM blog_members WHERE memberID = :memberID') ;
			$stmt->execute(array(':memberID' => $_GET['id'] ?? 0));
			$row = $stmt->fetch() ?: ['memberID' => '', 'username' => '', 'email' => '', 'fullname' => ''];

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

		<p><label>Username</label><br />
		<input type='text' name='username' value='<?php echo $row['username'];?>'></p>

		<p><label>Password (only to change)</label><br />
		<input type='password' name='password' value=''></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value=''></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php echo $row['email'];?>'></p>

    <p><label>Full Name</label><br />
		<input type='text' name='fullname' value='<?php echo $row['fullname'];?>'></p>

		<p><input type='submit' name='submit' value='Update User'></p>

	</form>

</div>

</body>
</html>
