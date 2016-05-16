<?php
session_name('main_site');
session_start();
include_once 'dbconnect.php';
include_once 'include/functions.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}

if(isset($_POST['btn-login']))
{
	$email = escape($_POST['email']);
	$upass = escape($_POST['pass']);
	
	$email = trim($email);
	$upass = trim($upass);
	
	$sql = "SELECT user_id, user_name, user_pass FROM users WHERE user_email='$email'";
	$sth=$dbh->prepare($sql);
	$sth->execute();
	$row = $sth->fetchAll();
	
	
	
	
	
	if(!empty($row) && $row[0]['user_pass']==md5($upass))
	{
		$_SESSION['user'] = $row[0]['user_id'];
		header("Location: home.php");
	}
	else
	{
		?>
        <script>alert('Username / Password Seems Wrong !');</script>
        <?php
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pedagogy of Difference. - Login & Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="register.php">Sign Up Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>