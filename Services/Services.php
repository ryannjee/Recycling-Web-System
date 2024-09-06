<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Services We Provide</title>
	<link rel="stylesheet" href="services.css">
</head>

<body>
    <!--navigation bar-->
<input type="checkbox" id="burger-toggle">
<label for="burger-toggle" class="burger-menu">
  <div class="line"></div>
  <div class="line"></div>
  <div class="line"></div>
</label>
<div class="menu">
  <div class="menu-inner">
    <ul class="menu-nav">
    <li class="menu-nav-item"><a class="menu-nav-link" href="../Navigation/navigation.php"><span>
            <div>HOME</div>
          </span></a></li>
          <li class="menu-nav-item"><a class="menu-nav-link" href="../About Us/About Us.php"><span>
            <div>ABOUT</div>
          </span></a></li>
          <li class="menu-nav-item"><a class="menu-nav-link" href="Services.php"><span>
            <div>SERVICE</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="../Team/Team.php"><span>
            <div>TEAM</div>
          </span></a></li>
          <li class="menu-nav-item"><a class="menu-nav-link" href="<?php 
            session_start();
            $username=isset($_SESSION["username"])?$_SESSION["username"]:"USER";
          if($username=="USER") //bring them to the login page if the user havent log in 
          {
            echo "../Login SignUp/LogIn/login.php";
          }
          else //bring them to the profile page 
          {
            echo "../userProfile/userProfile.php";  //profile page
          }
          
          ?>">
          <span>
          <div name="table"><?php 
          if($username=="USER")
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

    <div class="content">
        <div class="content1">
            <h2>01</h2><img src="photo/greenpartnerprogram.png" style="width: 60px;padding-top: 10px;">
            <h3>Green Partner Program</h3>
            <p>Assist organization who keen to attain more Sustainable Development Goals (SDGs) with the program designed.</p>
        </div>
        <div class="content1">
            <h2>02</h2><img src="photo/recyclingcampaign.png" style="width: 60px;padding-top: 10px;">
            <h3>Green Partner Program</h3>
            <h3>Green Recycling Campaigns</h3>
            <p>In assisting with corporate/community to organize and kick start unique recycling event using Point Reward System.</p>
        </div>
        <div class="content1">
            <h2>03</h2><img src="photo/ewasterecycling.png" style="width: 60px;padding-top: 10px;">
            <h3>Green Partner Program</h3>
            <h3>Electrical & Electronic (Ewaste) Recycling</h3>
            <p>Household and office are welcome to adopt an stainless steel Ewaste Recycling Bin for sustainable collection.</p>
        </div>
    </div>
</body>
</html>