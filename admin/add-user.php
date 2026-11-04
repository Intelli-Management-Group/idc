<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add User</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">User Admin Index</a></p>

	<h2>Add User</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		$username = trim($_POST['username'] ?? '');
		$password = $_POST['password'] ?? '';
		$passwordConfirm = $_POST['passwordConfirm'] ?? '';
		$email = trim($_POST['email'] ?? '');
		$fullname = trim($_POST['fullname'] ?? '');

		//very basic validation
		if($username ==''){
			$error[] = 'Please enter the username.';
		}

		if($password ==''){
			$error[] = 'Please enter the password.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Please confirm the password.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Passwords do not match.';
		}

		if($email ==''){
			$error[] = 'Please enter the email address.';
		}
    if($fullname ==''){
			$error[] = 'Please enter the full name.';
		}

		if(!isset($error)){

			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_members (username,password,email,fullname) VALUES (:username, :password, :email, :fullname)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $hashedpassword,
					':email' => $email,
          ':fullname' => $fullname
				));

				//redirect to index page
				header('Location: users.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
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

	<form action='' method='post'>

		<p><label>Username</label><br />
		<input type='text' name='username' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');}?>'></p>

		<p><label>Password</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');}?>'></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['passwordConfirm'] ?? '', ENT_QUOTES, 'UTF-8');}?>'></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');}?>'></p>

    <p><label>Full Name</label><br />
    <input type='text' name='fullname' value='<?php if(isset($error)){ echo htmlspecialchars($_POST['fullname'] ?? '', ENT_QUOTES, 'UTF-8');}?>'></p>

		<p><input type='submit' name='submit' value='Add User'></p>

	</form>

</div>
