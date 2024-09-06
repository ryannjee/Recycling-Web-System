<?php  
session_start();
include "formObject.php";

$admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$userID=isset($_SESSION['userID'])?$_SESSION['userID']:"";
$fname= isset($_POST["fname"])?$_POST["fname"]:"";
$lname= isset($_POST["lname"])?$_POST["lname"]:"";
$email= isset($_POST["email"])?$_POST["email"]:"";
$phone= isset($_POST["phone"])?$_POST["phone"]:"";
$member= isset($_POST["member"])?$_POST["member"]:"";
$saddress= isset($_POST["saddress"])?$_POST["saddress"]:"";
$city= isset($_POST["city"])?$_POST["city"]:"";
$zip= isset($_POST["zip"])?$_POST["zip"]:"";
$country= isset($_POST["country"])?$_POST["country"]:"";
$date= isset($_POST["date"])?$_POST["date"]:"";
$time= isset($_POST["time"])?$_POST["time"]:"";
$paper= isset($_POST["paper"])?$_POST["paper"]:"";
$plastic= isset($_POST["plastic"])?$_POST["plastic"]:"";
$metal= isset($_POST["metal"])?$_POST["metal"]:"";
$electronic= isset($_POST["electronic"])?$_POST["electronic"]:"";
$wood= isset($_POST["wood"])?$_POST["wood"]:"";
$glass= isset($_POST["glass"])?$_POST["glass"]:"";
$clothes= isset($_POST["clothes"])?$_POST["clothes"]:"";
$bricks= isset($_POST["bricks"])?$_POST["bricks"]:"";
$message=$Errfname=$Errlname=$Erremail=$Errphone=$Errsaddress=$Errcity=$Errzip=$Errcountry="";
$terms=isset($_POST["terms"])?$_POST["terms"]:"";
$dest_path="";
$totalPoints=0;
$vali = new Validation ($fname,$lname,$email,$phone,"",$saddress,$city,$zip,$country);//connect to the object oriented of validation for showing the validation to users


if(isset($_POST["logout"])) //for user to log out
{
    session_destroy();//destroy the session for loging out the account
    echo "<script>
    alert('Logout  Successfully!!!!!');
    window.location.href = '../../Navigation/navigation.php'; //header to the admin page with the reminder
    </script>";  
}

if(isset($_POST["cancel"])) //for user to log out
{
    session_destroy();//destroy the session for loging out the account
    echo "<script>
    alert('Cancel to add record!!!!!');
    window.location.href = 'form.php'; //header to the admin page with the reminder
    </script>";  
}

if(isset($_POST['submit']) && isset($_FILES['fileUpload']))
{

    if($paper>0 || $plastic>0 ||$metal>0 ||$electronic>0 ||$wood>0 ||$glass>0 ||$clothes>0 ||$bricks>0) //ensure the users got recycling the product 
    {
        if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK)
        {
          // get details of the uploaded file
          $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
          $fileName = $_FILES['fileUpload']['name'];
          $fileSize = $_FILES['fileUpload']['size'];
          $fileType = $_FILES['fileUpload']['type'];
          $fileNameCmps = explode(".", $fileName);
          $fileExtension = strtolower(end($fileNameCmps));

            // sanitize file-name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // check if file has one of the following extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'bmp');

            if (in_array($fileExtension, $allowedfileExtensions)){
                // directory in which the uploaded file will be moved
                $uploadFileDir = "../../recyclingform/pictures/". $newFileName;
                //$dest_path = $uploadFileDir . $fileName;
                $dest_path = "/pictures/". $newFileName;
                
                if(move_uploaded_file($fileTmpPath,$uploadFileDir)) 
                {
                  $message ='';
                }
                else
                {
                    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                }
            }
            else
            {
                $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
          }
      }
      else
      {
            $message=""; //if the user did not choose one of the product to recycle
      }
  }
  else
  {
    $message=""; //if the user did not update the image
  }
  if($message!="")//mention of file submit
  {
      echo "<script>
      alert('$message');
      </script>";
  }


if(isset($_POST["submit"]))// click the submit button
  { 
  
        if($paper>0 || $plastic>0 ||$metal>0 ||$electronic>0 ||$wood>0 ||$glass>0 ||$clothes>0 ||$bricks>0) //ensure the users got recycling the product 
        {
          $Errfname=$vali->Errfname();
          $Errlname=$vali->Errlname();
          $Erremail=$vali->ErrEmail();
          $Errphone=$vali->Errcontact();
          $Errsaddress=$vali->Errsaddress();
          $Errcity=$vali->Errcity();
          $Errzip=$vali->Errzip();
          $Errcountry=$vali->Errcountry();
      
          if($vali->register==8) // ensure the user to type the detail correctly
          { 
                $totalPoints += floor($paper/5); // 1 point for every 5kg paper
                $totalPoints += floor($plastic/5); // 1 point for every 5kg plastic
                $totalPoints += floor($metal/2); // 1 point for every 2kg metal
                $totalPoints += $electronic; // 1 point for every 1kg electronic
                $totalPoints += floor($wood/3); // 1 point for every 3kg wood
                $totalPoints += floor($glass/5); // 1 point for every 5kg glass
                $totalPoints += $clothes; // 1 point for every 1kg clothes
                $totalPoints += $bricks; // 1 point for every 1kg bricks
                $message=$admin->recordUploadData($fname,$lname,$email,$phone,$saddress,$city,$zip,$country,$date,$time,$paper,$plastic,$metal,$electronic,$wood,$glass,$clothes,$bricks,$dest_path,$totalPoints);
                echo "<script>
                alert('Successfuk to submit!!!!!');
                window.location.href = 'form.php';
                </script>"; //header to the navigation page with the reminder
          }
        }
        else  //users did not choose any product from the website to recycle
        {
          echo "<script>
                  alert('Please Choose the product you would want to recycle');
                  window.location.href = 'update.php';
                </script>"; //go back to the Recyclingform page with the reminder
      }

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="../Css/admin5.css">
    <style>
        select{
            border-color:transparent;
            margin-right:5px;
        }
    </style>
</head>

<body>
    <section id="menu">
        <div class="logo">
            <img class="logo" src=".././un.png" alt="">
            <h2> Dynamic</h2>
        </div>
        <div class="items">
        <form action="update.php" method="POST">
                <li><i class="fas fa-chart-pie"></i><a href="../admin.php">Dashboard</a></li>
                <li><i class="fab fa-elementor"></i><a href="../memberDetail.php">Member Detail</a></li>
                <li><i class="fas fa-table"></i><a href="form.php">Requested Form</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../FormPic/pic.php">NumberOfPicture</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../Diagram/Collection.php">Total recycling products</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../Tracking/track.php">RequiredForm status</a></li>
                <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
            </form>
        </div>

    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
            </div>

        <div class="profile">
            <i class="far fa-bell"></i>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Anonymous_emblem.svg/1200px-Anonymous_emblem.svg.png">
        </div>
    </div>
    <h3 class="i-name">
        Number of Submit Form
    </h3>

    <div class="values">
        <div class="val-box">
            <i class="fas fa-users"></i>
            <div>
                <h3><?php echo $admin->numOfClient()?></h3> <!--Number of member-->
                <span>Total Users</span>
            </div>
        </div>
        <div class="val-box">
        <i class="fab fa-wpforms"></i>
            <div>
            <h3><?php echo $admin->numOfSubmit()?></h3><!--Number of Submit form-->
                <span>Total Requests</span>
            </div>
        </div>
        <div class="val-box">
        <i class="fas fa-plus"></i>
        <form action="admin.php" method="POST">
            <div>
            <span><button name="add" value="1" onclick="return confirm('Are you sure you want to add?')" style="color:black; font-size:16px; margin-left:50%;">Add</button></span>
            </div>
        </form>
        </div>
    </div>


    <dir class="board">
        <table width="100%">
        <div class="testbox">
    <form action="update.php" method="post" enctype="multipart/form-data">
      <div class="banner">
        <h1>Recycling Form</h1>
      </div>
      <br/>
      <fieldset>
        <legend>Personal Information</legend>
        <div class="colums">
          <div class="item">
            <label for="fname">First Name<span><?php echo $Errfname;?></span></label>
            <input id="fname" type="text" name="fname">
          </div>
          <div class="item">
            <label for="lname"> Last Name<span><?php echo $Errlname;?></span></label>
            <input id="lname" type="text" name="lname">
          </div>
          <div class="item">
            <label for="email">Email Address<span><?php echo $Erremail;?></span></label>
            <input id="email" type="text"  list="email-list" name="email">
          </div>
          <div class="item">
            <label for="phone">Personal Contact(WhatsApp)<span><?php echo $Errphone;?></span></label>
            <input id="phone" type="tel"   name="phone" value="+60" >
          </div> 
        </div>
    </fieldset><br>

    <fieldset>
        <legend>Schedule</legend>
        <div class="colums">
          <div class="item">
            <label for="saddress">Street Address<span><?php echo $Errsaddress;?></span></label>
            <input id="saddress" type="text"   name="saddress">
          </div>
          <div class="item">
            <label for="city">City<span><?php echo $Errcity;?></span></label>
            <input list="city" id="city-input" name="city">
          </div>
          <div class="item">
            <label for="zip">Zip/Postal Code<span><?php echo $Errzip;?></span></label>
            <input id="zip" type="text"   name="zip">
          </div>
          <div class="item">
            <label for="country">Country<span><?php echo $Errcountry;?></span></label>
            <input id="country" type="text"   name="country" list="nationality-list">
          </div>
          <div class="item">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" min="<?= date("Y-m-d")?>" required>
          </div>
          <div class="item">
            <label for="time">Time</label>
            <input type="time" id="time" name="time" min="<?= date('09:00')?>" max="<?= date('17:00')?>" required>
          </div>
        </div>
    </fieldset><br>
    
    <fieldset>
    <legend>Item List</legend> 
        <h3>Please note that all item weights are given in kilograms (kg).</h3>
        <div class="colums">
          <div class="item">
            <label for="amount">Waste Paper and Cardboard</label>
            <input id="amount" type="number"  min="0" max="100" name="paper" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Plastic Recycling</label>
            <input id="amount" type="number"  min="0" max="100" name="plastic" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Metal Recycling</label>
            <input id="amount" type="number" min="0" max="100"  name="metal" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Electronic Devices Recycling</label>
             <input id="amount" type="number" min="0" max="100"  name="electronic" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Wood Recycling</label>
            <input id="amount" type="number" min="0" max="100"  name="wood" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Glass Recycling</label>
            <input id="amount" type="number" min="0" max="100"  name="glass" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Clothes and Textile Recycling</label>
            <input id="amount" type="number" min="0" max="100"  name="clothes" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Bricks and Inert Waste Recycling</label>
            <input id="amount" type="number"  min="0" max="100" name="bricks" value="0" required/>
          </div>
        </div> 
    </fieldset><br>

    <fieldset>
    <legend>Photos Upload</legend>
        <input type="file" name="fileUpload" id="fileUpload">
    </fieldset>
    <br>

    <div class="btn-block">
    <button type="order"  name="submit" style="    
    width: 100%;
    height:50px;
    padding: 10px;
    border: none;
    border-radius: 5px; 
    background:  #1c87c9;
    font-size: 16px;
    color: #fff;
    cursor: pointer;">Submit</button>
    </div>
    </form>
  </div>

        </table>
    </dir>
    </section>



    <datalist id="city">
  <option value="Kuala Lumpur">
  <option value="Petaling Jaya">
  <option value="Shah Alam">
  <option value="Klang">
  <option value="Subang Jaya">
  <option value="Johor Bahru">
  <option value="Melaka">
  <option value="Penang">
  <option value="Kota Kinabalu">
  <option value="Kuching">
    </datalist>

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

<datalist id="nationality-list">
  <option value="American">
  <option value="Australian">
  <option value="British">
  <option value="Canadian">
  <option value="Chinese">
  <option value="French">
  <option value="German">
  <option value="Indian">
  <option value="Indonesian">
  <option value="Italian">
  <option value="Japanese">
  <option value="Korean">
  <option value="Malaysian">
  <option value="Mexican">
  <option value="Russian">
  <option value="Singaporean">
  <option value="Spanish">
  <option value="Thai">
</datalist>


</script>

</body>

</html>
  