<!DOCTYPE html>
<html>
<head>
	<?php
	include "ObjectOriented.php";
	$userErro = $passwordErr = $emailErr = $LpasswordErr=$LemailErr=""; //initialize the variable
	$Vali = new Validation ( isset($_POST["username"]) ? $_POST["username"] : "", isset($_POST["password"]) ? $_POST["password"] : "", isset($_POST["email"]) ? $_POST["email"] : "", isset($_POST["Lpassword"]) ? $_POST["Lpassword"] : "", isset($_POST["Lemail"]) ? $_POST["Lemail"] : "");//connect to the object oriented of validation for showing the validation to users
	$login = new Login("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database
	$errorP=" ";


		if (isset($_POST["login"])) //if press the login button
		{
			$LpasswordErr=$Vali->LErrPassword(); //validation
			$LemailErr=$Vali->LErrEmail(); //validation
			if($Vali->login==2) //if the number==0 
			{
				$email = $_POST["Lemail"]; //login part's email
				$password = $_POST["Lpassword"]; //loagin part's password
				$errorP=$login->login($email, $password);
			}
		}

		if (isset($_POST["submit"]))  //if press the submit button
		{	
			$userErro=$Vali->ErrID();  //validation
			$passwordErr=$Vali->ErrPassword(); //validation
			$emailErr=$Vali->ErrEmail();  //validation
			if($Vali->register==3) //if the number ==3 that mean all of the validation is vali 
			{
				$username = $_POST["username"];//register part's username
				$email = $_POST["email"];//register part's email
				$password = $_POST["password"];//register part's password
				$errorP=$login->register($username, $email, $password);
			}
		}

	?>
	<title>Login/register</title>
	<link rel="stylesheet" type="text/css" href="./login.css">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup"> <!--register page-->
				<form action="login.php" method="post">
					<label for="chk" aria-hidden="true">Sign up</label>
					<div class="Error"><?php echo $errorP; ?></div> <!--Validation-->
					<span class="Error"><?php echo $userErro;?></span><!--Validation-->
					<input type="text" name="username" placeholder="User name" >
					<span class="Error"><?php echo $emailErr; ?></span><!--Validation-->
					<input type="email" name="email" placeholder="Email"  list="email-list">
					<span class="Error"><?php echo $passwordErr;?></span><!--Validation-->
					<input type="password" name="password" placeholder="Password" >
					<button name="submit">Sign up</button>
				</form>
			</div>
			<div class="login"><!--login page-->
				<form action="login.php" method="post">
					<label for="chk" aria-hidden="true">Login</label>
					<div class="Error"><?php echo $errorP; ?></div> <!--Validation-->
					<span class="Error"><?php echo $LemailErr; ?></span><!--Validation-->
					<input type="email" name="Lemail" placeholder="Email"  list="email-list">
					<span class="Error"><?php echo $LpasswordErr;?></span> <!--Validation-->
					<input type="password" name="Lpassword" placeholder="Password">		
					<div>
					<span class="forgot">Forgot <a href="../../forgot/forgot.php">password</a></span>
					<span class="administrator">Admin <a href="../../admin/admin_login.php">Login</a></span> <!--admin login button and forgot password button-->
					</div>
					<button name="login">Login</button>
				</form>
			</div>
	</div>


    <datalist id="email-list">
  <option value="@gmail.com">
  <option value="@hotmail.com">
  <option value="@yahoo.com">
  <option value="@outlook.com">
  <option value="@icloud.com">
  <option value="john.doe@gmail.com">
  <option value="jane.doe@yahoo.com">
  <option value="testuser@hotmail.com">
  <option value="exampleuser@outlook.com">
</datalist>

</body>
</html>