<?php

session_start();

if (isset($_POST['submit']))
{
    include 'dbh.inc.php';

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	if(empty($username) || empty($password))
	{
          header("Location: index.php?login=empty");
	  	  exit();
	}
	else
	{
		$sql = "SELECT * FROM users WHERE username='$username'";
		$result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1)
        {
             header("Location: index.php?login=error");
	  		exit();
        }
        else
        {
        	if($row = mysqli_fetch_assoc($result))
        	{
        		$hashedpassCheck = password_verify($password, $row['password']);
        		if($hashedpassCheck == false)
        		{
                     header("Location: index.php?login=error");
	  				exit();
        		}
        		elseif ($hashedpassCheck == true)
        		{
        			$_SESSION['username'] = $row[username];
        			$_SESSION['firstname'] = $row[firstname];
        			$_SESSION['lastname'] = $row[lastname];
        			$_SESSION['email'] = $row[email];
        			header("Location: index.php?login=success");
	  				exit();
        		}
        	}
        }
    }
	
}
else
{
	  header("Location: index.php?login=error");
	  exit();
}