<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset ="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    </head>
<body>
  <?php 
  session_start();
  $username=isset($_SESSION["username"])?$_SESSION["username"]:"USER";
  if(isset($_POST["signin"]))
  {
    header ("location: ../Login SignUp/Login/login.php");
  }
  if(isset($_POST["form"]))//for login's recycling form 
  {
    echo "<script>
    alert('As a member of our recycling program, you can earn cash by bringing in recyclable materials. For every 5kg of paper, plastic, glass, or wood, 2kg of metal, 1kg of electronics or clothes, and 1kg of bricks you bring to our facility, you could receive money in cash at the counter or walker will give the money to you.');
    window.location.href = '../recyclingform/Recyclingform.php';
    </script>";   }

  if(isset($_POST["form1"]))//for user havent login into the account's recycling form 
  {
    echo "<script>
    alert('As a member of our recycling program, you can earn cash by bringing in recyclable materials. For every 5kg of paper, plastic, glass, or wood, 2kg of metal, 1kg of electronics or clothes, and 1kg of bricks you bring to our facility, you could receive money in cash at the counter or walker will give the money to you. ');
    window.location.href = '../recyclingform/Recyclingform.php';
    </script>"; 
  }
  if(isset($_POST["form2"]))//for user havent login into the account
  {
    header ("location: ../Branches/Info.php");
  }
  ?>
<!--navigation bar-->
<input type="checkbox" id="burger-toggle">
<label for="burger-toggle" class="burger-menu">
  <div class="line"></div>
  <div class="line"></div>
  <div class="line"></div>
</label>
<div class="menu">
  <div class="menu-inner">
    <div class="container">
    <div class="search-box">
  		</div>
    </div>
    <ul class="menu-nav">
      <li class="menu-nav-item"><a class="menu-nav-link" href="navigation.php"><span>
            <div>HOME</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="../About Us/About Us.php"><span>
            <div>ABOUT</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="../Services/Services.php"><span>
            <div>SERVICE</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="../Team/Team.php"><span>
            <div>TEAM</div>
          </span></a></li>
          <li class="menu-nav-item"><a class="menu-nav-link" href="<?php 
          if($username=="USER") //bring them to the login page if the user havent log in 
          {
            echo "../Login SignUp/LogIn/login.php";
          }
          else //bring them to the profile page 
          {
            echo "../userProfile/userProfile.php";  //profile page
          }
          ?>"><span>
          <div name="table"><?php 
          if($username=="USER") // if the user didnt login to the account then this login button will appear
          {
            echo "Login";
          }
          else
          {
            echo $username;
          }
          ?></div> <!--this is loging into the user profile -->
        </span></a></li>
    </ul>
    <div class="gallery">
      <div class="title">
        <p>What Can Be Recycled?</p>
      </div>
      <div class="images">
        <a class="image-link" href="#">
          <div class="image" data-label="Cans"><img src="photo/evgeny-karchevsky-k1tUxfs8JYY-unsplash.jpg" alt=""></div>
        </a>
        <a class="image-link" href="#">
          <div class="image" data-label="Light Bulbs"><img src="photo/john-cameron-NenIuYCAmx8-unsplash.jpg" alt=""></div>
        </a>
        <a class="image-link" href="#">
          <div class="image" data-label="Paper"><img src="photo/8fa940c1-c526-46b2-bec3-ed6521231f8b.jpg" alt=""></div>
        </a>
        <a class="image-link" href="#">
          <div class="image" data-label="Plastic"><img src="photo/8a562e40-2bdf-4e28-9f76-8f6f80a9ee29.jpg" alt=""></div>
        </a>
      </div>
    </div>
  </div>
</div>
<!--body part-->
<div class="content">
  <img class="logo" src="./photo/un.png">
  <div class="content1">
    <span class="bord">
    EcoCycle Solutions </span>
    <form action="navigation.php" method="POST">
    <div><button class="b1" name="<?php 
    if($username=="USER") //distinguish the user and member
    {
      echo "signin";
    }
    else //if the user login account, the will show the recycle form for user to submit
    {
      echo "form";
    }
    ?>"><?php 
    if($username=="USER") //distinguish the user and member
    {
      echo "Sign In"; //show the sign in button
    }
    else 
    {
      echo "Pick Up";// show the pick up button 
    }
    ?></button>
    <?php 
    if($username=="USER")
    {
    ?>
    <button class="b1" name="form1">Pick Up</button>  
    <?php 
    
    }?>
    <button class="b1" name="form2">Walk In</button>  

  </div>
  </form>
  </div>
</div>
</body>
</html>