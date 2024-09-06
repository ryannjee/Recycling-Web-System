<?php 
session_start();
include "userProfileObject.php";
$userID=isset($_SESSION['userID'])?$_SESSION['userID']:"";
$message="";
$number0=$number1=$number2=$number3=$number4=$number5=$number6=$number7=0;
$email=isset($_POST["email"])?$_POST["email"]:"";

$fname=isset($_POST["fname"])?$_POST["fname"]:"";
$lname=isset($_POST["lname"])?$_POST["lname"]:"";
$contact=isset($_POST["contact"])?$_POST["contact"]:"";
$address=isset($_POST["address"])?$_POST["address"]:"";
$city=isset($_POST["city"])?$_POST["city"]:"";
$zipcode=isset($_POST["zipcode"])?$_POST["zipcode"]:"";
$country=isset($_POST["country"])?$_POST["country"]:"";
$userDetail= new userDetail("localhost", "email", "password", "recycling");
$numberP=0;//for upload image
$errorP=$emailErr=$fnameErr=$lnameErr=$contactErr=$addressErr=$cityErr=$zipcodeErr=$countryErr=""; //ensure the value is empty;
$vali = new Validation ("","","$email",$fname,$lname,$contact,$address,$city,$zipcode,$country);//connect to the object oriented of validation for showing the validation to users



if(isset($_POST["logout"])) //for user to log out
{
    session_destroy();
    echo "<script>
    alert('Logout  Successfully!!!!!');
    window.location.href = '../Navigation/navigation.php'; //header to the admin page with the reminder
    </script>";  
}
if(isset($_POST["emailB"]))
{
    $number0=1;
    if($_POST["emailB"]=="yes")
    {
        $emailErr=$vali->ErrEmail();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updateEmail($userID,$email); //it will invoke if the user revise the detail and press the enter button 
            $number0=0;
        }
    }
}

if(isset($_POST["passwordB"]))
{
    $_SESSION["identity"]=false;
    header("location: ../admin design html css/change.php");
}


if(isset($_POST["fnameB"]))
{
    $number1=1;
    if($_POST["fnameB"]=="yes")
    {
        $fnameErr=$vali->Errfname();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updateFname($userID,$fname); //it will invoke if the user revise the detail and press the enter button 
            $number1=0;
        }
    }
}
if(isset($_POST["lnameB"]))
{
    $number2=1;
    if($_POST["lnameB"]=="yes")
    {
        $lnameErr=$vali->Errlname();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updateLname($userID,$lname); //it will invoke if the user revise the detail and press the enter button 
            $number2=0;
        }
    }
}
if(isset($_POST["contactB"]))
{
    $number3=1;
    if($_POST["contactB"]=="yes")
    {
        $contactErr=$vali->Errcontact();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updatecontact($userID,$contact); //it will invoke if the user revise the detail and press the enter button 
            $number3=0;
        }
    }
}
if(isset($_POST["addressB"]))
{
    $number4=1;
    if($_POST["addressB"]=="yes")
    {
        $addressErr=$vali->Errsaddress();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updateaddress($userID,$address); //it will invoke if the user revise the detail and press the enter button 
            $number4=0;
        }
    }
}
if(isset($_POST["cityB"]))
{
    $number5=1;
    if($_POST["cityB"]=="yes")
    {
        $cityErr=$vali->Errcity();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updatecity($userID,$city); //it will invoke if the user revise the detail and press the enter button 
            $number5=0;
        }
    }
}
if(isset($_POST["zipcodeB"]))
{
    $number6=1;
    if($_POST["zipcodeB"]=="yes")
    {
        $zipcodeErr=$vali->Errzip();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updatezipcode($userID,$zipcode); //it will invoke if the user revise the detail and press the enter button 
            $number6=0;
        }
    }
}
if(isset($_POST["countryB"]))
{
    $number7=1;
    if($_POST["countryB"]=="yes")
    {
        $countryErr=$vali->Errcountry();
        if($vali->register==1) //ensurethe user does not invoke the validation
        {
            echo $message=$userDetail->updatecountry($userID,$country); //it will invoke if the user revise the detail and press the enter button 
            $number7=0;

        }
    }
}
if(isset($_POST["cancel"]))
{
    header("location: userProfile.php");
    $number1=$number2=$number3=$number4=$number5=$number6=$number7=0;//cancel the input that user want to change
}

if(isset($_POST['profile']))
{
    $numberP=1;
}

if(isset($_POST['submit']) && isset($_FILES['file']))
{
        $numberP=0;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK)
        {
          // get details of the uploaded file
          $fileTmpPath = $_FILES['file']['tmp_name'];
          $fileName = $_FILES['file']['name'];
          $fileSize = $_FILES['file']['size'];
          $fileType = $_FILES['file']['type'];
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
                  $message =$userDetail->recordUploadData($userID,$dest_path);
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
    if($message!="")//does not create the reminder
    {
        echo "<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
    }
  }
$row=$userDetail->showDetail($userID);//show the user detail
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle Solutions</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="./Css/Profile.css">


</head>

<body>

    <section id="menu">
        <div class="logo">
            <img class="logo" src="un.png" alt="">
            <h2> EcoCycle Solutions</h2>
        </div>
        <div class="items">
            <form action="userProfile.php" method="POST">
            <li><i class="fas fa-chart-pie"></i><a href="#">Personal Detail</a></li>
            <li><i class="fab fa-elementor"></i><a href="userForm.php">Requested form</a></li>
            <li><i class="fas fa-hamburger"></i><a href="tracking.php">Tracking Status</a></li>
                <li><i class="fas fa-hamburger"></i><a href="../Navigation/navigation.php">HomePage</a></li>
                <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
            </form>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
            </div>

        <div class="profile">
            <i class="far fa-bell"></i>
            <img src="
                    <?php 
                    echo $row["picname"];
                    ?>
                    ">
        </div>
    </div>
    <h3 class="i-name">
        UserDetail
    </h3>

    <div class="values">
        <div class="val-box">
        <i class="fab fa-wpforms"></i>
            <div>
                <h3><?php  echo $userDetail->numOfSubmit($userID)?></h3>
                <span>Total Requested Form</span>
            </div>
        </div>        
        <div class="val-box" style="margin-right:50%;">
        <i class="fab fa-wpforms"></i>
            <div>
                
                <h3><?php  
                echo $userDetail->numOfPoint($userID);?></h3>
                <span>Total Point</span>
            </div>
        </div> 
    </div>

    <dir class="board">
        <table width="100%">
            <thead>
                <tr>
                    <td><b>UserDetail</b></td>
                </tr>
            </thead>
            <form action="userProfile.php" method="POST" enctype="multipart/form-data">

            <tbody>
                <?php 
                ?>
                <tr>
                    <td>
                    <div class="upload-btn-wrapper" style="  width:50%;">
                    <?php 
                    if($numberP!=1)
                    {
                    ?>
                    <img src="
                    <?php 
                    echo $row["picname"];
                    ?>
                    "  class="upload-btn-img" style=" width:50%; border-radius:0; height:50%;">
                    <?php
                    } 
                    else//allow users to change the profile picture if they click the change button
                    {
                    ?>
                        <img img src="
                    <?php 
                        echo $row["picname"];
                    ?>
                    " alt="Upload image" class="upload-btn-img" style=" width:50%; border-radius:0; height:50%;">
                         </div>    
                    <input type="file" name="file" id="file" accept="image/*">
                    <?php 

                    }?>
                        </div>
                    </td>
                    <td>
                        <?php 
                        if($numberP!=1) //show the button of changing the profile picture
                        {
                        ?>
                        <button name="profile" style="font-size:10px; color:red;">Change</submit> 
                        <?php
                        }
                        else
                        {
                        ?>
                        <button name="submit" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">UpdateProfile</submit> 
                        <?php }?>
                    </td>
                </tr>


                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Member ID: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        echo "$row[userID]";
                        ?>
                    </td>
                </tr>



                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Email: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number0!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[email]";
                        }
                        else
                        {
                            if($emailErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $emailErr;?></span>
                            <?php 
                            }      
                            ?>

                            <input type="text" name="email" list="email-list" value="<?php echo $row["email"]?>">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number0!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="emailB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="emailB" style="font-size:10px; color:red;" value="yes">Enter</button>
                            <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Password: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        echo "************";
                        ?>                    
                    </td>
                    <td>
                    <button name="passwordB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change your password?')">Edit</button>
                    </td>
                </tr>





                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Fname: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number1!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[fname]";
                        }
                        else
                        {
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

                            <input type="text" name="fname" value="<?php echo $row["fname"]?>">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number1!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="fnameB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="fnameB" style="font-size:10px; color:red;" value="yes">Enter</button>
                            <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Lname: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number2!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[lname]";
                        }
                        else
                        {
                            if($lnameErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $lnameErr;?></span>
                            <?php 
                            }      
                            ?>
                        <input type="text" name="lname" value="<?php echo $row["lname"]?>">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number2!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="lnameB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="lnameB" style="font-size:10px; color:red;" value="yes">Enter</button>
                        <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Contact: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number3!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[contact]";
                        }
                        else
                        {
                            if($contactErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $contactErr;?></span>
                            <?php 
                            }      
                            ?>
                        <input type="text" name="contact" value="<?php echo $row["contact"]?>">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number3!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="contactB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')"> Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="contactB" style="font-size:10px; color:red;" value="yes">Enter</button>
                        <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Address: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number4!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[address]";
                        }
                        else
                        {
                            if($addressErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $addressErr;?></span>
                            <?php 
                            }      
                            ?>
                        <input type="text" name="address" value="<?php echo $row["address"]?>">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number4!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="addressB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="addressB" style="font-size:10px; color:red;" value="yes">Enter</button>
                        <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>



                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>City: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number5!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[city]";
                        }
                        else
                        {
                            if($cityErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $cityErr;?></span>
                            <?php 
                            }      
                            ?>
                        <input type="text" name="city" value="<?php echo $row["city"]?>" list="city">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number5!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="cityB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="cityB" style="font-size:10px; color:red;" value="yes">Enter</button>
                        <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Zipcode: 
                                
                                </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number6!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[zipcode]";
                        }
                        else
                        {
                            if($zipcodeErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $zipcodeErr;?></span>
                            <?php 
                            }      
                            ?>
                        <input type="text" name="zipcode" value="<?php echo $row["zipcode"]?>">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number6!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="zipcodeB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="zipcodeB" style="font-size:10px; color:red;" value="yes">Enter</button>
                        <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>

                
                <tr>
                    <td class="people-des">
                            <div class="people-de">
                                <h5>Country: </h5>
                            </div>
                    </td>
                    <td>
                        <?php 
                        if($number7!=1) //it will invoke if the ueser click the edit button 
                        {
                        echo "$row[country]";
                        }
                        else
                        {
                            if($countryErr=="")//if the error is empty this row does not appear
                            {
                            
                            }
                            else//if the error is not empty this row does not appear
                            {
                        ?>
                            <span class="Error"><?php echo $countryErr;?></span>
                            <?php 
                            }      
                            ?>
                        <input type="text" name="country" value="<?php echo $row["country"]?>" list="nationality-list">
                        <?php 
                        }
                        ?>
                    </td>
                    <td>
                    <?php 
                        if($number7!=1) //it will invoke if the ueser click the edit button 
                        {
                     ?>
                        <button name="countryB" style="font-size:10px; color:red;" onclick="return confirm('Are you sure you want to change?')">Edit</button>
                    <?php
                        }
                        else
                        {
                        ?>
                        <button name="countryB" style="font-size:10px; color:red;" value="yes">Enter</button>
                        <button name="cancel" style="font-size:10px; color:red;" >Cancel</button>
                    <?php 
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
            <?php 
        
            ?>
        </form>
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
<script>
    const uploadBtn = document.querySelector('.upload-btn-img');
    const fileInput = document.querySelector('#file');
    uploadBtn.addEventListener('click', function() {
    fileInput.click();
    });
</script>
</body>

</html>
  