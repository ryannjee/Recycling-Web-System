<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Operational Hours</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
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
    <div class="container">
    <div class="search-box">
  		</div>
    </div>
    <ul class="menu-nav">
      <li class="menu-nav-item"><a class="menu-nav-link" href="../Navigation/navigation.php"><span>
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
          ?>"><span>
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

    <h1>Our Branches & Hours</h1>

    <div class="op">
        <div class="column">
        <p><span>Klang Branch</span>
            <br>Open at 9:00am - 5:00pm Daily<br>
        <br>No. 25, Lorong Teluk Batu 4A, 
        <br>Off Jalan Kebun Industrial Park, Kampung Jawa,
        <br>Klang, Selangor, 41000</p>
            <br>
        <p><span>Kepong Branch</span>
            <br>Open at 9:00am - 5:00pm Daily<br>
        <br>50, Jalan Jinjang Permai,
        <br>Jinjang Utara, 
        <br>52000 WP Kuala Lumpur</p>
            <br>
        <p><span>Cyberjaya Branch</span>
            <br>Open at 9:00am - 5:00pm Daily<br>
        <br>Jalan Teknokrat 6, G-3A, 
        <br>Kanvas Retail @ Prima 15, 
        <br>63000 Cyberjaya, Selangor</p>
        </div>

        <div class="column">
        <p><span>Penang Branch</span>
            <br>Open at 9:00am - 5:00pm Daily<br>
        <br>Lot 534, 44 B, 
        <br>Lebuh Victoria, 
        <br>10300 George Town, Pulau Pinang</p>
            <br>    
        <p><span>Johor Branch</span>
            <br>Open at 9:00am - 5:00pm Daily<br>
        <br>No. 20, PTD 165724, Jalan Riang 21,
        <br>Kawasan, Taman Perindustrian Gembira, 
        <br>81200 Tampoi, Johor</p>
            <br>
        <p><span>Kuantan Branch</span>
            <br>Open at 9:00am - 5:00pm Daily<br>
        <br>1, Jalan Industri Semambu, 
        <br>Kawasan Perindustrian Semambu, 
        <br>25350 Kuantan, Pahang</p>
        </div>

        <div class="column">
            <img src="photo/800px_COLOURBOX5544860.jpg">
    </div>
</body>
</html>