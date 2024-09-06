<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Our Team</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="styles.css">
</head>

<body>
<?php 
    session_start();
    $username=isset($_SESSION["username"])?$_SESSION["username"]:"USER";
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
      <li class="menu-nav-item"><a class="menu-nav-link" href="Team.php"><span>
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

<div class="main">
  <h1>Our Team</h1>
  <p>MAKING THE<span> UNITED NATIONS </span>RELEVANT TO<span> ALL PEOPLE </span></p>
</div>

<div class="wrapper">
  <div class="our_team">
     <div class="team team_1"> <!--1st Team Member Profile-->
         <div class="team_img">
           <img src="photo/perth.jpg" alt="team_member">  
       </div>
       <div class="team_role">Co-founder</div>
       
          <div class="dot">
            <div></div>
            <div></div>
            <div></div>
         </div>
         
         <div class="info"> <!--Javascript message-->
           <h4>Wong Loo Perth</h4>
           <p>I am very handsome so come and recycle tq.</p>
         </div>
     </div>
     <div class="team team_2"> <!--2nd Team Member Profile-->
        <div class="team_img">
           <img src="photo/zhiyun.jpg" alt="team_member">  
       </div>
       <div class="team_role">HR Manager</div>
       <div class="dot">
            <div></div>
            <div></div>
            <div></div>
         </div>
         
         <div class="info"> <!--Javascript message-->
           <h4>Gan Zhi Yun</h4>
           <p>If u don't recycle, I will dislike you.</p>
         </div>
    </div>
     <div class="team team_3"> <!--3rd Team Member Profile-->
       <div class="team_img">
           <img src="photo/zheqian.jpg" alt="team_member">  
       </div>
       <div class="team_role">Developer</div>
       <div class="dot">
            <div></div>
            <div></div>
            <div></div>
         </div>
         
         <div class="info"> <!--Javascript message-->
           <h4>Ng Zheqian</h4>
           <p>If you recycle, I will fly you to somewhere you like.</p>
         </div>
    </div>
     <div class="team team_4"> <!--4th Team Member Profile-->
       <div class="team_img">
           <img src="photo/ryan.jpg" alt="team_member">  
       </div>
       <div class="team_role">Support Manager</div>
       <div class="dot">
            <div></div>
            <div></div>
            <div></div>
         </div>
         <div class="info"> <!--Javascript message-->
           <h4>Ryan Jee</h4>
           <p>If you don't recycle, I will kick you.</p>
         </div>
    </div>
</div>
</div>

<script> 
var dot_items = document.querySelectorAll(".dot");


Array.from(dot_items).forEach(function(dot){
  dot.addEventListener("click", function(){ //click to show or hide team members info
    this.classList.toggle("active")
  });
});
</script>

</body>
</html>