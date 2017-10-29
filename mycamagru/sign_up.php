<?php
	session_start();
	$_SESSION['message'] = '';
	$mysqli = mysqli_connect('localhost', 'root', 'Tumisho45', 'beta');

	if (isset($_POST['submit']))
	{
		if ($_POST['password'] == $_POST['confirmpassword'])
		{
            $firstname = $mysqli->real_escape_string($POST['firstname']);
            $lastname = $mysqli->real_escape_string($POST['lastname']);
            $password = md5($_POST['password']);//md5 hash password
			$username = $mysqli->real_escape_string($_POST['username']);
			$email = $mysqli->real_escape_string($_POST['email']);
			
			$sql = "INSERT INTO users (firstname, lastname, password, username, email) VALUES ('$firstname', '$lastname','$username', '$password', '$email')";
			if ($mysqli->query($sql) == true)
			{
				$to = $email;
				$subject = "Verifying user email address";
				$message = "Email verified!!!       click link: http://localhost:8080/Camagru/login.php";
				mail($to, $subject, $message);
				echo 'Registration successful! Added $username to the database';
				header("location: login.php");
			}else
			{
				$_SESSION['message'] = "User could not be added to database";
			}
		}
		else
			{
				$_SESSION['message'] = "Two passwords dont match";
			}
	}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/sign_up.css">
        <title>Registration</title>
    </head>
    <body>
        <h1>Fill_In_Form_Snapper</h1>
        <form action="sign_up.php" method="POST" enctype="multipart/from-data" autocomplete="off">
            <input type="text" placeholder="Firstname" name="firstname" required>
            <input type="text" placeholder="Lastname" name="lastname" required>
            <input type="text" placeholder="Username" name="username" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="password" placeholder="Confirm Passwrd" name="confirmpassword" required>

            <div>
                <input type="radio" id="male" name="gender"><label for="male">Male</label>
                <input type="radio" id="female" name="gender"><label for="female">female</label>
            </div>

            <input type="Submit" name="submit">
        </form>
    </body>
</html>