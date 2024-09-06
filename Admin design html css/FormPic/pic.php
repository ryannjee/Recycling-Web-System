<?php  
session_start();
include "PicObject.php";
$admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$filter=isset($_POST["filter"])?$_POST["filter"]:"";
$key=isset($_POST["title"])?$_POST["title"]:"";
$SubmitID=isset($_POST["SubmitID"])?$_POST["SubmitID"]:"";
$message="";
$number=0;
$p=1;



// Set the number of records to be displayed per page
$records_per_page = 10;

// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page4'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page4']) && is_numeric($_SESSION['current_page4'])) {
    $page = $_SESSION['current_page4'];
} else {
    $page = 1;
}

// Get the offset value for the SQL query
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM recyclingform";
$result_total = mysqli_query($admin->conn, $total_query);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];




if(isset($_POST["delete"]))
{
    $admin->formDelete($_POST["id"]); // this button is deleted button
    echo "<script>
    alert('Delete Successfully!!!!!');
    window.location.href = 'pic.php'; //header to the admin page with the reminder
    </script>";    
} 
if(isset($_POST["edit"]))
{
    $number=1;
}
if(isset($_POST["add"]))
{
    header("location:../form/update.php");
}
if(isset($_POST["cancel"]))//cancel the uplaod button
{
    $number=0;
    header("location: pic.php");
}
if(isset($_POST["logout"])) //for user to log out
{
    session_destroy();//destroy the session for loging out the account
    echo "<script>
    alert('Logout  Successfully!!!!!');
    window.location.href = '../../Navigation/navigation.php'; //header to the admin page with the reminder
    </script>";  
}


if(isset($_POST['submit']) && isset($_FILES['file']))
{
        $number=0;
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
                $uploadFileDir = "../../recyclingform/pictures/". $newFileName;
                //$dest_path = $uploadFileDir . $fileName;
                $dest_path = "pictures/". $newFileName;
                
                if(move_uploaded_file($fileTmpPath,$uploadFileDir)) 
                {
                  $message =$admin->recordUploadData($SubmitID,$dest_path);
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
        window.location.href = 'pic.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
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
    <link rel="stylesheet" href="../Css/admin4.css">
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
            <h2> EcoCycle Solutions</h2>
        </div>
        <div class="items">
            <form action="pic.php" method="POST">
                <li><i class="fas fa-chart-pie"></i><a href="../admin.php">Dashboard</a></li>
                <li><i class="fab fa-elementor"></i><a href="../memberDetail.php">Member Detail</a></li>
                <li><i class="fas fa-table"></i><a href="../form/form.php">Requested Form</a></li>
                <li><i class="fab fa-wpforms"></i><a href="pic.php">NumberOfPicture</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../Diagram/Collection.php">Total recycling products</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../Tracking/track.php">RequiredForm status</a></li>
                <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
            </form>
        </div>

    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <form action="pic.php" method="POST">
                    <select name="filter"> <!--Filter the result-->
                            <option value="all" selected>ALL</option>
                            <option value="SubmitID">SubmitID </option>
                            <option value="fname">Fname</option>
                            <option value="lname">Lname</option>
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                            <option value="member">Member</option>
                            <option value="saddress">Saddress</option>
                            <option value="city">City </option>
                            <option value="zip">Zip</option>
                            <option value="country">Country</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                            <option value="paper">Paper</option>
                            <option value="plastic">Plastic</option>
                            <option value="metal">Metal </option>
                            <option value="electronic">Electronic</option>
                            <option value="wood">Wood</option>
                            <option value="glass">Glass</option>
                            <option value="clothes">clothes</option>
                            <option value="bricks">Bricks</option>
                        </select>
                    <input type="text" placeholder="Search" name="title">
                    <button type="submit" name="search">Search</button> 
                    </form>

                </div>
            </div>

        <div class="profile">
            <i class="far fa-bell"></i>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Anonymous_emblem.svg/1200px-Anonymous_emblem.svg.png">
        </div>
    </div>
    <h3 class="i-name">
        Number of Picture
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
        <form action="pic.php" method="POST">
            <div>
            <span><button name="add" value="1" onclick="return confirm('Are you sure you want to add?')" style="color:black; font-size:16px; margin-left:50%;">Add</button></span>            </div>
        </form>
        </div>
    </div>


    <dir class="board">
        <table width="100%">
            <thead>
                <tr>
                    <td>userName</td>
                    <td>RequiredForm ID</td>
                    <td>Picture</td>
                    <td>Button</td>

                </tr>
            </thead>

            <?php 
            $sql="";
            if(isset($_POST["search"])) //filter the result
            {
                if($filter=="all") //Able to search ALL
                {
                    $sql="SELECT *from recyclingform Where SubmitID like '%$key%' OR email like '%$key%' OR fname like '%$key%' OR lname like '%$key%'OR phone like '%$key%'OR member like '%$key%'OR saddress like '%$key%'OR city like '%$key%' 
                    OR zip like '%$key%'OR country like '%$key%'OR date like '%$key%'OR time like '%$key%'OR paper like '%$key%'OR plastic like '%$key%' OR metal like '%$key%' OR electronic like '%$key%' OR wood like '%$key%' OR glass like '%$key%' OR clothes like '%$key%' OR bricks like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }

                else if($filter=="SubmitID") // search for id 
                {
                    $sql="SELECT *from recyclingform Where SubmitID ='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="email") //search for email 
                {
                    $sql="SELECT *from recyclingform Where email like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="fname") //search for fname
                {
                    $sql="SELECT *from recyclingform Where fname like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="lname") //search for lname
                {
                    $sql="SELECT *from recyclingform Where  lname like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="phone") //search for phone
                {
                    $sql="SELECT *from recyclingform Where  phone like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="member") //search for member
                {
                    $sql="SELECT *from recyclingform Where member like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="saddress") //search for saddress
                {
                    $sql="SELECT *from recyclingform Where  saddress like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="city") //search for city
                {
                    $sql="SELECT *from recyclingform Where  city like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="zip") //search for zip
                {
                    $sql="SELECT *from recyclingform Where zip like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="country") //search for country
                {
                    $sql="SELECT *from recyclingform Where country like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="date") //search for date
                {
                    $sql="SELECT *from recyclingform Where date like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="time") //search for time
                {
                    $sql="SELECT *from recyclingform Where time like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="paper") //search for paper
                {
                    $sql="SELECT *from recyclingform Where paper='$key'  LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="plastic") //search for plastic
                {
                    $sql="SELECT *from recyclingform Where plastic='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="metal") //search for metal
                {
                    $sql="SELECT *from recyclingform Where metal='$key'  LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="electronic") //search for electronic
                {
                    $sql="SELECT *from recyclingform Where electronic='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="wood") //search for wood
                {
                    $sql="SELECT *from recyclingform Where wood='$key'  LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="glass") //search for glass
                {
                    $sql="SELECT *from recyclingform Where glass='$key'  LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="clothes") //search for clothes
                {
                    $sql="SELECT *from recyclingform Where clothes='$key'  LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="bricks") //search for brick
                {
                    $sql="SELECT *from recyclingform Where bricks='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }

            }
            else //does not search 
            {
                $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
            }
            $result=mysqli_query($admin->conn,$sql);
            $num=mysqli_num_rows($result); //count the number of rows
            if($num>0) //the row more than 0
            {
                while($row=mysqli_fetch_assoc($result))
                {

            ?>
            <form action="pic.php" method="POST" enctype="multipart/form-data">
                <tbody>
                <tr>
                        <td class="people-des">
                            <h5><?php echo $row["fname"].$row["lname"]?></h5>
                        </td>

                        <td class="people-des">
                        <h5><?php echo $row["SubmitID"] ?></h5>
                        <input type="hidden" name="SubmitID" value="<?php echo $row["SubmitID"] ?>">
                    </td>
                    <td class="people-des">
                        <?php 
                        
                        if($number!=1)
                        {
                            if($row["picname"]!="")
                            {
                        ?>
                        <h5><img class="submit" src="../../recyclingform/<?php echo $row["picname"]?>" style=" width:50%; border-radius:0; height:50%;"></h5>
                        <?php 
                            }
                            else
                            {
                                ?>
                                <img src="data:image/jpeg;base64,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">
                                <?php 
                            }
                        }
                        else
                        {
                            if($row["picname"]!="")
                            {
                        ?>

                        <div class="image-container">
                         <img src="../../recyclingform/<?php echo $row["picname"]?>"  alt="Upload image" class="upload-btn-img" style=" width:50%; border-radius:0; height:50%; opacity:0.5;">
                         </div>
                         <?php 
                        }
                        else
                        {
                        ?> 
                        <img src="data:image/jpeg;base64,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">
                        <?php
                        }
                         ?>
                         <input type="file" name="file" id="file" accept="image/*" style="">
                        <?php    
                        }
                        ?>
                    </td>

                        <input type="hidden" name="id" value="<?php echo $row["SubmitID"]?>">
                    <td class="edit">
                    <div>
                    <?php 
                        
                        if($number!=1)
                        {
                    ?>
                    <div><button name="edit" onclick="return confirm('Are you sure you want to edit this record?')" style="margin-right:25px;">Edit</button></div>
                    <?php 
                        }
                        else
                        {
                            
                    ?>
                    <div><button name="submit" onclick="return confirm('Are you sure you want to upload this record?')" style="margin-right:25px;">Upload</button></div>
                    <?php    
                        }
                    ?>

                    <?php 
                        
                        if($number!=1)
                        {
                    ?>
                    <div><button name="delete" value="1" onclick="return confirm('Are you sure you want to delete this record?')" style="margin-right:25px;">Delete</button></td></div>
                    <?php 
                        }
                        else
                        {
                    ?>
                    <div><button name="cancel" value="1" onclick="return confirm('Are you sure you want to cancel this record?')" style="margin-right:25px;">Cancel</button></td></div>
                    <?php    
                        }
                    ?>
                
                    </form>
                </tr>
            </tbody>
            <?php        
            }
            
            }
            else// the number of rows less than 1
            {
            ?>
                <tbody>
                <tr>
                    <td class="people">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Anonymous_emblem.svg/800px-Anonymous_emblem.svg.png"alt="">
                        <div class="people-de">
                            <h5><?php echo "Not found" ?></h5>
                            <p><?php echo "Not found" ?></p>
                        </div>
                    </td>

                    <td class="people-des">
                        <h5><?php echo "Not found" ?></h5>
                        <p></p>
                    </td>
                    <td class="people-des">
                        <h5><?php echo "Not found"?></h5>
                    </td>

                    <td class="people-des">
                        <h5><?php echo "Not found" ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo "Not found" ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo "Not found" ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo "Not found" ?></h5>
                    </td>
                </tr>
            </tbody>                
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

</script>
<script>
    const uploadBtn = document.querySelector('.upload-btn-img');
    const fileInput = document.querySelector('#file');
    uploadBtn.addEventListener('click', function() {
    fileInput.click();
    });

</script>

</body>

</html>
  