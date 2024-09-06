<?php 
session_start();
include "registerObject.php";//takes all the text/code/markup that exists in the same file and copies it into the here
$fillUp=new fillUp("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database
$email=isset($_SESSION["email"])?$_SESSION["email"]:"";// validation 
$userID=isset($_SESSION["userID"])?$_SESSION["userID"]:"";
$fname=isset($_POST["fname"])?$_POST["fname"]:"";
$lname=isset($_POST["lname"])?$_POST["lname"]:"";
$contact=isset($_POST["contact"])?$_POST["contact"]:"";
$address=isset($_POST["address"])?$_POST["address"]:"";
$city=isset($_POST["city"])?$_POST["city"]:"";
$zipcode=isset($_POST["zipcode"])?$_POST["zipcode"]:"";
$country=isset($_POST["country"])?$_POST["country"]:"";
$vali = new Validation ($fname,$lname,$contact,$address,$city,$zipcode,$country);//connect to the object oriented of validation for showing the validation to users
$errorP=$fnameErr=$lnameErr=$contactErr=$addressErr=$cityErr=$zipcodeErr=$countryErr=""; //ensure the value is empty;

if(isset($_POST["register"]))
{
    $fnameErr=$vali->Errfname();
    $lnameErr=$vali->Errlname();
    $contactErr=$vali->Errcontact();
    $addressErr=$vali->Errsaddress();
    $cityErr=$vali->Errcity();
    $zipcodeErr=$vali->Errzip();
    $countryErr=$vali->Errcountry();

    if($vali->register==7)
    {
        $errorP=$fillUp->register($email,$fname,$lname,$contact,$address,$city,$zipcode,$country,"pictures/face.png");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="wave.css">
    <?php
    ?>

</head>
<body>
    <form class="regis" action="wave form.php" method="POST" >
        <h2>Registration</h2>
        <?php 
        if($errorP=="") //if the error is empty this row does not appear
        {

        }
        else//if the error is not empty this row does not appear
        {
        ?>
        <div class="Error"><?php echo $errorP; ?></div>
        <?php }
        if($fnameErr=="")//if the error is empty this row does not appear
        {
        
        }
        else//if the error is not empty this row does not appear
        {
        ?>
		<span class="Error"><?php echo $fnameErr;?></span>
        <?php 
        }      
        ?>
        <input class="fname" type=text name="fname" placeholder="First Name*">
        <?php 
            if($lnameErr=="")//if the error is empty this row does not appear
            {
                
            }
            else//if the error is not empty this row does not appear
            {  
        ?>
        <span class="Error"><?php echo $lnameErr;?></span>
        <?php }?>
        <input class="lname" type=text name="lname" placeholder="Last name*">
        <?php 
        if($contactErr=="")//if the error null this row does not appear
        {
                        
        }
        else //if the error is not empty this row does not appear
        {  
        ?>
        <span class="Error"><?php echo $contactErr;?></span>
        <?php 
        }?>
        <input class="contact" type=text name="contact" placeholder="Personal contact*">
        <?php 
        if($addressErr=="")//if the error null this row does not appear
        {
                        
        }
        else //if the error is not empty this row does not appear
        {  
        ?>
        <span class="Error"><?php echo $addressErr;?></span>
        <?php 
        }?>
        <input class="address"type=text name="address" placeholder="Street Address">
        <?php 
        if($cityErr=="")//if the error null this row does not appear
        {
                        
        }
        else //if the error is not empty this row does not appear
        {  
        ?>
        <span class="Error"><?php echo $cityErr;?></span>
        <?php 
        }?>
        <input class="city" type=text name="city" placeholder="City" list="city">
        <?php 
        if($zipcodeErr=="")//if the error null this row does not appear
        {
                        
        }
        else //if the error is not empty this row does not appear
        {  
        ?>
        <span class="Error"><?php echo $zipcodeErr;?></span>
        <?php 
        }?>
        <input class="zipcode" type=text name="zipcode" placeholder="Zip/Postal Code">
        <?php 
        if($countryErr=="")//if the error null this row does not appear
        {
                        
        }
        else //if the error is not empty this row does not appear
        {  
        ?>
        <span class="Error"><?php echo $countryErr;?></span>
        <?php 
        }?>
        <input class="country" type=text name="country" placeholder="Country" list="nationality-list">
        <button name="register">Register</button>
      </form>
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