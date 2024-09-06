<?php 
session_start();
include "userProfileObject.php";
$userID=isset($_SESSION['userID'])?$_SESSION['userID']:"";
$message="";
$SubmitID=isset($_POST["SubmitID"])?$_POST["SubmitID"]:"";


$fname=isset($_POST["fname"])? $_POST["fname"]:"";
$lname=isset($_POST["lname"])? $_POST["lname"]:"";
$email=isset($_POST["email"])? $_POST["email"]:"";
$phone=isset($_POST["phone"])? $_POST["phone"]:"";
$member=isset($_POST["member"])? $_POST["member"]:"";
$saddress=isset($_POST["saddress"])? $_POST["saddress"]:"";
$city=isset($_POST["city"])? $_POST["city"]:"";
$zip=isset($_POST["zip"])? $_POST["zip"]:"";
$country=isset($_POST["country"])? $_POST["country"]:"";
$date=isset($_POST["date"])? $_POST["date"]:"";
$time=isset($_POST["time"])? $_POST["time"]:"";
$paper=isset($_POST["paper"])? $_POST["paper"]:"";
$plastic=isset($_POST["plastic"])? $_POST["plastic"]:"";
$metal=isset($_POST["metal"])? $_POST["metal"]:"";
$electronic=isset($_POST["electronic"])? $_POST["electronic"]:"";
$wood=isset($_POST["wood"])? $_POST["wood"]:"";
$glass=isset($_POST["glass"])? $_POST["glass"]:"";
$clothes=isset($_POST["clothes"])? $_POST["clothes"]:"";
$bricks=isset($_POST["bricks"])? $_POST["bricks"]:"";
$Erremail=$message=$Errfname=$Errlname=$Errphone=$Errsaddress=$Errcity=$Errzip=$Errcountry="";
$dest_path="";
$vali = new Validation ("","",$email,$fname,$lname,$phone,$saddress,$city,$zip,$country);//connect to the object oriented of validation for showing the validation to users
$totalPoints=0;
$userDetail= new userDetail("localhost", "email", "password", "recycling");
$numberP=0;//for upload image
$result="";$photo="";
$num1=0;//for edit button


// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page5'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page5']) && is_numeric($_SESSION['current_page5'])) {
    $page = $_SESSION['current_page5'];
} else {
    $page = 1;
}
// Get the offset value for the SQL query
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM recyclingform where member='$userID'";
$result_total = mysqli_query($conn, $total_query);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];


if(isset($_POST["logout"])) //for user to log out
{
    session_destroy();
    echo "<script>
    alert('Logout  Successfully!!!!!');
    window.location.href = '../Navigation/navigation.php'; //header to the admin page with the reminder
    </script>";  
}
if(isset($_POST["cancel"]))
{
    $num1=0;//for edit button
    header("location: userForm.php");
}
if(isset($_POST["edit"]))
{
    $num1=1;//for edit button
}


if(isset($_POST['submit']) && isset($_FILES['file']))
{
    $num1=1;//for edit button
    if($paper>0 || $plastic>0 ||$metal>0 ||$electronic>0 ||$wood>0 ||$glass>0 ||$clothes>0 ||$bricks>0) //ensure the users got recycling the product 
    {
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
                $uploadFileDir = "../recyclingform/pictures/". $newFileName;
                //$dest_path = $uploadFileDir . $fileName;
                $dest_path = "pictures/". $newFileName;
                
                if(move_uploaded_file($fileTmpPath,$uploadFileDir)) 
                {
                    $message="";
                    $num1=0;//for edit button
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
            window.location.href = 'userForm.php'; //header to the admin page with the reminder
            </script>"; //this is a reminder for user to know the account is successful to change 
        }
    }
    else  //users did not choose any product from the website to recycle
    {
    echo "<script>
            alert('Please Choose the product you would want to recycle');
            window.location.href = 'userForm.php';
            </script>"; //go back to the Recyclingform page with the reminder
    }
  }
  if(isset($_POST["submit"]))// click the submit button
  {
        $num1=1;//for edit button
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
          $userDetail->reviseFormDetail($SubmitID,$fname,$lname,$email,$phone,$saddress,$city,$zip,$country,$date,$time,$paper,$plastic,$metal,$electronic,$wood,$glass,$clothes,$bricks,$totalPoints);
          if(isset($_POST['submit']) && isset($_FILES['file']))
          {
              $message =$userDetail->recordUploadDataRecyclingForm($SubmitID,$dest_path);
              $num1=0;//for edit button
          }
      }
      }
      else  //users did not choose any product from the website to recycle
      {
        echo "<script>
                alert('Please Choose the product you would want to recycle');
                window.location.href = 'userForm.php';
              </script>"; //go back to the Recyclingform page with the reminder
      }
  }
$row=$userDetail->showDetailPicture($userID,$offset,$records_per_page);//show the user detail

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle Solutions</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="./Css/Profile2.css">
</head>

<body>

    <section id="menu">
        <div class="logo">
            <img class="logo" src="un.png" alt="">
            <h2> EcoCycle Solutions</h2>
        </div>
        <div class="items">
            <form action="userForm.php" method="POST">
            <li><i class="fas fa-chart-pie"></i><a href="userProfile.php">Personal Detail</a></li>
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
        RequiredForm
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
                    <td><b>RequiredForm ID</b></td>
                    <td><b>Fname</b></td>
                    <td><b>Lname</b></td>
                    <td><b>Email</b></td>
                    <td><b>Contact</b></td>
                    <td><b>Member</b></td>
                    <td><b>Saddress</b></td>
                    <td><b>City</b></td>
                    <td><b>Zip</b></td>
                    <td><b>Country</b></td>
                    <td><b>Date</b></td>
                    <td><b>Time</b></td>
                    <td><b>Paper (kg)</b></td>
                    <td><b>Plastic (kg)</b></td>
                    <td><b>Metal (kg)</b></td>
                    <td><b>Electronic (kg)</b></td>
                    <td><b>Wood (kg)</b></td>
                    <td><b>Glass (kg)</b></td>
                    <td><b>Clothes (kg)</b></td>
                    <td><b>Bricks (kg)</b></td>
                    <td><b>Point (RM)</b></td>
                    <td><b>Requested form</b></td>
                    <td><b>Button</b></td>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                $sql="SELECT *from recyclingform where member='$userID' LIMIT $offset, $records_per_page";
                $result=mysqli_query($userDetail->conn,$sql);
                $num=mysqli_num_rows($result);
                while($photo=mysqli_fetch_assoc($result))
                {
                ?>
                <form action="userForm.php" method="POST" enctype="multipart/form-data">
                <tr>
                    <td class="people-des">
                        <h5><?php 
                        echo "$photo[SubmitID]";
                        ?></h5>
                    </td>
                <?php
               if($SubmitID==$photo["SubmitID"])//user could revise the required form that he was chosen but other required form could not revise
               {  
                if($num1==1)
                {  
                ?>
                    <td class="people-des">
                        <?php 
                        
                        if($Errfname=="")
                        {

                        }
                        else
                        {
                        ?>
                        <span class="Error"><?php echo $Errfname?></span>
                        <?php }?>
                        <h5><input type="text" name="fname" value="<?php echo $photo["fname"] ?>"></h5>
                    </td>

                    <td class="people-des">
                        <?php 
                        
                        if($Errlname=="")
                        {

                        }
                        else
                        {
                        ?>
                        <span class="Error"><?php echo $Errlname?></span>
                        <?php }?>
                        <h5><input type="text" name="lname" value="<?php echo $photo["lname"] ?>" ></h5>
                    </td>
  

                    <td class="people-des">
                        <?php 
                        
                        if($Erremail=="")
                        {

                        }
                        else
                        {
                        ?>
                        <span class="Error"><?php echo $Erremail?></span>
                        <?php }?>
                        <h5><input type="text" name="email" value="<?php echo $photo["email"] ?>" list="email-list"></h5>
                    </td>
                    <td class="people-des">
                    <?php
                    if($Errphone=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>
                        <span class="Error"><?php echo $Errphone?></span>
                    <?php
                    }
                    ?>
                        <h5><input type="text" name="phone" value="<?php echo $photo["phone"] ?>"></h5>
                    </td>

                    <td class="people-des">                       
                        <h5><?php echo $photo["member"]?></h5>
                    </td>
                    <td class="people-des">
                    <?php
                    if($Errsaddress=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>                        
                        <span class="Error"><?php echo $Errsaddress?></span>
                        <?php
                    }
                    ?>                        
                        <h5><input type="text" name="saddress" value="<?php echo $photo["saddress"] ?>"></h5>
                    </td>
                    <td class="people-des">
                    <?php
                    if($Errcity=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>                        
                        <span class="Error"><?php echo $Errcity?></span>
                        <?php
                    }
                    ?>                        
                        <h5><input type="text" list="city" name="city" value="<?php echo $photo["city"] ?>"></h5>
                    </td>
                    <td class="people-des">
                    <?php
                    if($Errzip=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>                        
                        <span class="Error"><?php echo $Errzip?></span>
                    <?php
                    }
                    ?>                        
                        <h5><input type="text" name="zip" value="<?php echo $photo["zip"] ?>"></h5>
                    </td>
                    <td class="people-des">
                    <?php
                   if($Errcountry=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>                        
                        <span class="Error"><?php echo $Errcountry?></span>
                    <?php
                    }
                    ?>                        
                        <h5><input type="text" name="country" value="<?php echo $photo["country"] ?>" list="nationality-list"></h5>
                    </td>
                    <td class="people-des">                      
                        <h5><input type="date" id="date" name="date" min="<?= date("Y-m-d")?>" value="<?php echo $photo['date']?>"></h5>
                    </td>
                    <td class="people-des">                       
                        <h5><input type="time" id="time" name="time" min="<?= date('09:00')?>" max="<?= date('17:00')?>" value="<?php echo $photo['time']?>"></h5>
                    </td>

                    <td class="people-des">
                    <h5><input id="amount" type="number"  min="0" max="100" name="paper" required value="<?php echo $photo["paper"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="plastic" required value="<?php echo $photo["plastic"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="metal" required value="<?php echo $photo["metal"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="electronic" required value="<?php echo $photo["electronic"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="wood" required value="<?php echo $photo["wood"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="glass" required value="<?php echo $photo["glass"] ?>" /></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="clothes" required  value="<?php echo $photo["clothes"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                    <h5><input id="amount" type="number" min="0" max="100"  name="bricks" required  value="<?php echo $photo["bricks"] ?>"/></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["point"] ?></h5>
                    </td>  
                <?php 
                }}
                else
                {
                ?>
                    <td class="people-des">
                        <h5><?php 
                        echo "$photo[fname]";
                        ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php 
                        echo "$photo[lname]";
                        ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["email"] ?></h5>
                        <p></p>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $photo["phone"] ?></h5>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $photo["member"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["saddress"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["city"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["zip"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["country"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["date"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["time"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["paper"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["plastic"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["metal"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["electronic"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["wood"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["glass"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["clothes"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $photo["bricks"] ?></h5>
                    </td>        
                    <td class="people-des">
                        <h5><?php echo $photo["point"] ?></h5>
                    </td>             
                <?php 
                }

                if($userID==$photo["member"])
                {
                    if($num!=0)//if the accout is existed the photo
                    {
                ?>
                    <td class="people-des">
                    <div class="image-container">
                    <?php 
                    if($photo["picname"]!="")
                    {
                    ?>
                        <img img src="
                    <?php 
                        echo "../recyclingform/".$photo["picname"];
                    ?>
                    " alt="Upload image" class="upload-btn-img" style=" width:300px; border-radius:0; height:80%;">
                    <?php
                    }
                    else
                    {
                    }
                    ?>
                    </div>    
                    <?php 
                    if($num1==1 && $SubmitID==$photo["SubmitID"])
                    {

                    ?>
                    <input type="file" name="file" id="file" accept="image/*" style="" value="../recyclingform/<?php echo $photo['picname'];?>">
                    <?php 
                    }?>
                    <input type="hidden" name="SubmitID" value="<?php echo $photo["SubmitID"]?>">
                    </td>
                    <td><div>
                        <?php 
                        if($num1==0)
                        {
                        ?>
                        <button name="edit" onclick="return confirm('Are you sure you want to upload this record?')" style="margin-right:25px;">Edit</button>
                        <?php 
                        }
                        else
                        {
                        ?>
                            <button name="submit" onclick="return confirm('Are you sure you want to upload this record?')" style="margin-right:25px;">Upload</button>
                            <button name="cancel" onclick="return confirm('Are you sure you want to upload this record?')" style="margin-right:25px;">Cancel</button>
                        <?php
                        }
                        ?>
                    </div></td>
                    </form>
                    <?php 
                    }
                }?>
                </tr>
            </tbody>
            <td></td>
            <td></td>
            <td></td>
            <?php 
            }
            ?>
        </table>
        <?php
    // Generate pagination links
    $pagination = '';
    if($total_records > $records_per_page){
        $total_pages = ceil($total_records / $records_per_page);
        $current_page = $page;

        $pagination .= '<ul class="pagination">';
        for($i=1; $i<=$total_pages; $i++){
            if($i == $current_page){
                $pagination .= '<li><a href="?page='.$i.'" class="active">'.$i.'</a></li>';
            } else {
                $pagination .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
            }
        }
        $pagination .= '</ul>';

    echo $pagination;
}
?>

    </dir>
    </section>
</body>

</html>