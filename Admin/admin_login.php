<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
  </head>
    <body>
      <form action="admin_login.php" method="POST" class='form'>
      <?php 
        include ("../Login SignUp/Login/ObjectOriented.php");
          $emailErr=$passwordErr="";
          $email=isset($_POST["email"])?$_POST["email"]:"";
          $password=isset($_POST["password"])?$_POST["password"]:"";
          $vali=new Validation("","","","$password","$email");
          $login = new Login("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database
          $errorP=" ";//warning for unsuccessfully log in
          if(isset($_POST["login"]))
          {
            $emailErr=$vali->LErrEmail(); //validation
            $passwordErr=$vali->LErrPassword();//validation
              if($vali->login==2) //all of tha validation is vali 
              {   
                $errorP=$login->AdminLogin($email, $password); //object oriented for log in           
              }
          }
      
    ?>
        <div class='control'>
          <h1>
            Administrator Sign In
          </h1>
          <span class="error"><?php echo $errorP."<br>".$emailErr."<br>".$passwordErr;?></span>
        </div>
        <div class='control block-cube block-input'>
          <input name='email' placeholder='Email' type='text'>
          <div class='bg-top'>
            <div class='bg-inner'></div>
          </div>
          <div class='bg-right'>
            <div class='bg-inner'></div>
          </div>
          <div class='bg'>
            <div class='bg-inner'></div>
          </div>
        </div>
        <div class='control block-cube block-input'>
          <input name='password' placeholder='Password' type='password'>
          <div class='bg-top'>
            <div class='bg-inner'></div>
          </div>
          <div class='bg-right'>
            <div class='bg-inner'></div>
          </div>
          <div class='bg'>
            <div class='bg-inner'></div>
          </div>
        </div>
        <button class='btn block-cube block-cube-hover' type='submit' name="login">
          <div class='bg-top'>
            <div class='bg-inner'></div>
          </div>
          <div class='bg-right'>
            <div class='bg-inner'></div>
          </div>
          <div class='bg'>
            <div class='bg-inner'></div>
          </div>
          <div class='text'>
            Log In
          </div>
        </button>
      </form>
      
    </body>
  <?php


  ?>
</html>