<!DOCTYPE html>
<!---Coding By CoderGirl!--->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!--<title> An About Us Page | CoderGirl </title>-->
  <!---Custom Css File!--->
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    session_start();
    $username=isset($_SESSION["username"])?$_SESSION["username"]:"USER";
    if(isset($_POST["signin"]))
    {
      header ("location: ../Login SignUp/Login/login.php");
    }
    if(isset($_POST["form"]))
    {
      header ("location: ");
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
    <ul class="menu-nav">
      <li class="menu-nav-item"><a class="menu-nav-link" href="#"><span>
            <div>HOME</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="#"><span>
            <div>ABOUT</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="#"><span>
            <div>SERVICE</div>
          </span></a></li>
      <li class="menu-nav-item"><a class="menu-nav-link" href="#"><span>
            <div>TEAM</div>
          </span></a></li>
          <li class="menu-nav-item"><a class="menu-nav-link" href="<?php 
          if($username=="USER") //bring them to the login page if the user havent log in 
          {
            echo "../Login SignUp/LogIn/login.php";
          }
          else //bring them to the profile page 
          {
            echo "../userProfile/admin.php";  //profile page
          }
          
          ?>"><span>
            <div name="table"><?php echo $username;?></div> <!--this is loging into the user profile -->
          </span></a></li>
    </ul>
    <div class="gallery">
      <div class="title">
        <p>What Can Be Recycled?</p>
      </div>
      <div class="images">
        <a class="image-link" href="#">
          <div class="image" data-label="Cans"><img src="Navigation/photo/evgeny-karchevsky-k1tUxfs8JYY-unsplash.jpg" alt=""></div>
        </a>
        <a class="image-link" href="#">
          <div class="image" data-label="Light Bulbs"><img src="Navigation/photo/john-cameron-NenIuYCAmx8-unsplash.jpg" alt=""></div>
        </a>
        <a class="image-link" href="#">
          <div class="image" data-label="Paper"><img src="Navigation/photo/8fa940c1-c526-46b2-bec3-ed6521231f8b.jpg" alt=""></div>
        </a>
        <a class="image-link" href="#">
          <div class="image" data-label="Plastic"><img src="Navigation/photo/8a562e40-2bdf-4e28-9f76-8f6f80a9ee29.jpg" alt=""></div>
        </a>
      </div>
    </div>
  </div>
</div>

    <section class="about-us">
    <div class="about">
        <img src="Navigation/photo/thaiphirun-hul-oMyq9YjiZeE-unsplash.jpg" class="pic">
        <div class="text">
            <h2>About Us</h2>
            <h5>United Nations - <span>Support Sustainable Development & Climate Action</span></h5>
            <p>The United Nations launched its sustainable development agenda in 2015, reflecting the growing understanding by Member States that a development model that is sustainable for this and future generations offers the best path forward for reducing poverty and improving the lives of people everywhere. At the same time, climate change began making a profound impact on the consciousness of humanity. With the polar ice caps melting, global sea levels rising and cataclysmic weather events increasing in ferocity, no country in the world is safe from the effects of climate change.
            <br><br>
            Building a more sustainable global economy will help reduce the greenhouse gas emissions that cause climate change. It is, therefore, critically important that the international community meet the UN's Sustainable Development Goals – and also the targets for reducing emissions set in the Paris Climate Agreement of 2015.
            <br><br>
            Sustainable development and climate action are linked – and both are vital to the present and future well-being of humanity.</p>
        </div>
    </div>
  </section>

  <section class="about-us">
    <div class="about">
        <div class="text">
            <h5>The <span>Sustainable Development Agenda</span></h5>
            <p><span>MDGs</span> — Close to 40 per cent of the population of the developing world was living in extreme poverty only two decades ago. Since then, the world has halved extreme poverty, with the UN’s Millennium Development Goals (MDGs) greatly contributing to this progress.
            <br><br>
            <span>2030 Agenda</span> — Recognizing the success of the MDGs, and the need to complete the job of eradicating poverty, the UN adopted the ambitious 2030 Agenda for Sustainable Development, which includes ending poverty; zero hunger; good health and well being; quality education; gender equality; clean water and sanitation; affordable and clean energy; decent work and economic growth; industry, innovation and infrastructure; reduced inequalities; sustainable cities and communities; responsible consumption and production; climate action; life below water; life on land; peace, justice and strong institutions; and partnerships for the goals.
            <br><br>  
            <span>Paris Agreement</span> — While these goals were being formulated and approved, the United Nations supported the climate change negotiations, which led to the Paris Agreement on climate change in 2015. The central aim of the Paris Agreement is to strengthen the global response to the threat of climate change by keeping the global temperature rise well below 2 degrees Celsius above pre-industrial levels, or even below 1.5 degrees Celsius. Additionally, the Paris Agreement aims to strengthen the ability of countries to deal with the impacts of climate change. In order to reach these goals, financing, new technology and an enhanced capacity-building framework will be put in place. The Agreement also provides for enhanced transparency of action and support through a transparency framework.</p>
        </div>
        <img src="Navigation/photo/joshua-lawrence-E_ZJ6moimKE-unsplash.jpg" class="pic">
    </div>
  </section>

  <section class="about-us">
    <div class="about">
      <img src = "Navigation/photo/ishan-seefromthesky-4xmgrNUbyNA-unsplash.jpg" class="pic">
        <div class="text">
            <h5><span>2019 Sustainable Development Summit</span></h5>
            <p><span>In September 2019,</span><br> Heads of State and Government gathered at UN Headquarters in New York for the Sustainable Development Summit to follow up and comprehensively review progress in the implementation of the 2030 Agenda for Sustainable Development and the 17 Sustainable Development Goals (SDGs). The event was the first UN summit on the SDGs since the adoption of the 2030 Agenda in September 2015.
            <br><br>
            After the summit, the President of the 74th session of the General Assembly, Tijjani Muhammad-Bande, summarized its results, stating that “the commitment to the 2030 Agenda for Sustainable Development remains steadfast”, but “the world is not on track to meet the SDGs by 2030.”
            <br><br>
            In their Political Declaration, Member States said “We recognize the many efforts at all levels since 2015 to realize the vision of the 2030 Agenda and the Sustainable Development Goals.” But, they said, “we are concerned that progress is slow in many areas. Vulnerabilities are high and deprivations are becoming more entrenched. Assessments show that we are at risk of missing the poverty eradication target. Hunger is on the rise. Progress towards gender equality and the empowerment of all women and girls is too slow. Inequalities in wealth, incomes and opportunities are increasing in and between countries. Biodiversity loss, environmental degradation, discharge of plastic litter into the oceans, climate change and increasing disaster risk continue at rates that bring potentially disastrous consequences for humanity”.
            <br><br>
          </div>
    </div>
  </section>
</body>
</html>