<?php
session_start();
include('includes/config.php');
if(isset($_POST['login']))
{
$uname=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
} else{
	
	echo "<script>alert('Invalid Details');</script>";

}

}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>CWMS | Admin Sign in</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #2c3e50 0%,rgb(92, 119, 147) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 20px;
    position: relative;
}

.login-container {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    padding: 40px;
    width: 100%;
    max-width: 400px;
}

.login-header {
    text-align: center;
    margin-bottom: 40px;
}

.login-header h2 {
    color: #333;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 10px;
}

.form-group {
    margin-bottom: 25px;
    position: relative;
}

.form-group input {
    width: 100%;
    padding: 12px 40px 12px 15px;
    border: 2px solid #e1e1e1;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}

.login-button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.back-link {
    text-align: center;
    margin-top: 20px;
}

.back-link a {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
}

.back-link a:hover {
    color: #764ba2;
}
</style>
</head> 
<body >
	<div class="login-container" style="back">
		<div class="login-header">
			<h2>Welcome Admin</h2>
			<p>Please sign in to continue</p>
		</div>
		<form method="post">
			<div class="form-group">
				<input type="text" name="username" placeholder="Enter your username" required>
				<i class="fas fa-user"></i>
			</div>
			<div class="form-group">
				<input type="password" name="password" placeholder="Enter your password" required>
				<i class="fas fa-lock"></i>
			</div>
			<button type="submit" name="login" class="login-button">Sign In</button>
			<div class="back-link">
				<a href="../index.php"><i class="fas fa-arrow-left"></i> Back to home</a>
			</div>
		</form>
	</div>

	<!-- jQuery -->
	<script src="js/jquery-2.1.4.min.js"></script>
</body>
</html>