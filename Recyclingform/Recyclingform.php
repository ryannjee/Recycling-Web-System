<?php
session_start();
include "formObject.php";
$userID=isset($_SESSION['userID'])?$_SESSION['userID']:"";
$upload= new upload("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
//get from data
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
$paper= isset($_POST["paper"])?$_POST["paper"]:0;
$plastic= isset($_POST["plastic"])?$_POST["plastic"]:0;
$metal= isset($_POST["metal"])?$_POST["metal"]:0;
$electronic= isset($_POST["electronic"])?$_POST["electronic"]:0;
$wood= isset($_POST["wood"])?$_POST["wood"]:0;
$glass= isset($_POST["glass"])?$_POST["glass"]:0;
$clothes= isset($_POST["clothes"])?$_POST["clothes"]:0;
$bricks= isset($_POST["bricks"])?$_POST["bricks"]:0;
$message=$Errfname=$Errlname=$Erremail=$Errphone=$Errsaddress=$Errcity=$Errzip=$Errcountry="";
$terms=isset($_POST["terms"])?$_POST["terms"]:"";
$totalPoints=0;
$dest_path="";
$vali = new Validation ($fname,$lname,$email,$phone,$saddress,$city,$zip,$country);//connect to the object oriented of validation for showing the validation to users
$email1= new email();
$NEmail= new notificationEmail();

if(isset($_POST["sub"])) // send the advertisement to the user through email  if they tick the sub checkbox
{
  $email1->Sub($email);
}

if(isset($_POST['submit']) && isset($_FILES['fileUpload']))
{
  if($terms=="yes")  //user must tick the terms and condition checkbox
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
                $uploadFileDir = "pictures/";
                //$dest_path = $uploadFileDir . $fileName;
                $dest_path = $uploadFileDir . $newFileName;
                
                if(move_uploaded_file($fileTmpPath,$dest_path)) 
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
          $message=""; //if the user did not tick the terms and condition
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

    if($terms=="yes")  //user must tick the terms and condition checkbox
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
          
              $message=$upload->recordUploadData($fname,$lname,$email,$phone,$userID,$saddress,$city,$zip,$country,$date,$time,$paper,$plastic,$metal,$electronic,$wood,$glass,$clothes,$bricks,$dest_path,$totalPoints);
              $NEmail->Sub($email,$date,$time,$fname);
              echo "<script>
              alert('Successful to submit!!!!!');
              window.location.href = '../Navigation/navigation.php';
              </script>"; //header to the navigation page with the reminder
        }
      }
      else  //users did not choose any product from the website to recycle
      {
        echo "<script>
                alert('Please Choose the product you would want to recycle');
                window.location.href = 'Recyclingform.php';
              </script>"; //go back to the Recyclingform page with the reminder
    }
    }
    else //user did not tick the terms and conditions checkbox 
    {
      echo "<script>
      alert('Please tick the Terms and Conditions');
      window.location.href = 'Recyclingform.php';
      </script>"; //go back to the Recyclingform page with the reminder
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Recycling Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="Recyclingform.css">
  </head>

  <body>
    <div class="testbox">
    <form action="Recyclingform.php" method="post" enctype="multipart/form-data">
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
          <?php 
          if($userID!="") //user is able to see this input if users log into the account 
          {
          ?>   
          <div class="item">
            <label for="member">Member ID(Optional)</label>
            <input id="member" type="text"   name="member" value="<?php echo $userID;?>" disabled>
          </div> 
          <?php 
          }
          ?>  
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
            <input id="amount" type="number"  min="0" max="100" name="plastic" value="0" required />
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
            <input id="amount" type="number" min="0" max="100"  name="glass" value="0" required />
          </div>
          <div class="item">
            <label for="amount">Clothes and Textile Recycling</label>
            <input id="amount" type="number" min="0" max="100"  name="clothes" value="0" required/>
          </div>
          <div class="item">
            <label for="amount">Bricks and Inert Waste Recycling</label>
            <input id="amount" type="number"  min="0" max="100" name="bricks" value="0"  required/>
          </div>
        </div> 
    </fieldset><br>

    <fieldset>
    <legend>Photos Upload</legend>
        <input type="file" name="fileUpload" id="fileUpload">
    </fieldset>
    <br>

    <div class="checkbox">
      <input type="checkbox" id="terms" name="terms" value="yes">
      <label for="terms">I have read and agree the <a href="T&C.php" target="_blank">Terms and Conditions</a>.</label><br>
      <input type="checkbox" id="sub" name="sub">
      <label for="sub">I would like to receive details about recycling.</label>
    </div> 


    <div class="btn-block">
    <a href="../Navigation/navigation.php" class="back">Back</a>
    <button type="order"  name="submit">Submit</button>
    </div>
    </form>
  </div>


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


  </body>
</html>