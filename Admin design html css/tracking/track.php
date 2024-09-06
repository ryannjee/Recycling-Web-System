<?php  
session_start();
include "../form/formObject.php";
include "trackObject.php";
$status= new status("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$Sendemail=new notificationEmail();
$admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$filter=isset($_POST["filter"])?$_POST["filter"]:"";
$key=isset($_POST["title"])?$_POST["title"]:"";
$SubmitID=isset($_POST["SubmitID"])?$_POST["SubmitID"]:"";
$num1=0;
$LastUpdated=isset($_POST["LastUpdated"])?$_POST["LastUpdated"]:"";
$CurrentStatus=isset($_POST["CurrentStatus"])?$_POST["CurrentStatus"]:"";
$email=isset($_POST["email"])?$_POST["email"]:"";
$fname=isset($_POST["fname"])?$_POST["fname"]:"";

// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page7'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page7']) && is_numeric($_SESSION['current_page7'])) {
    $page = $_SESSION['current_page7'];
} else {
    $page = 1;
}
// Get the offset value for the SQL query
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM recyclingform";
$result_total = mysqli_query($conn, $total_query);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];

if(isset($_POST["update"])) //for user to update
{
    $num1=1;
}

if(isset($_POST["cancel"])) //for user to cancel the update
{
    $num1=0;
}

if(isset($_POST["submit"])) //for user to cancel the Submit and update the status
{
    $message=$status->update($SubmitID,$CurrentStatus,$LastUpdated);
    $Sendemail->Inprocess($email,$SubmitID,$fname,$CurrentStatus);
    echo "<script>
    alert(' $message!!!!!');
    window.location.href = 'track.php'; 
    </script>"; 
}
if(isset($_POST["logout"])) //for user to log out
{
    session_destroy();//destroy the session for loging out the account
    echo "<script>
    alert('Logout  Successfully!!!!!');
    window.location.href = '../../Navigation/navigation.php'; //header to the admin page with the reminder
    </script>";  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle Solutions</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="../Css/admin7.css">
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
            <form action="track.php" method="POST">
                <li><i class="fas fa-chart-pie"></i><a href="../admin.php">Dashboard</a></li>
                <li><i class="fab fa-elementor"></i><a href="../memberDetail.php">Member Detail</a></li>
                <li><i class="fas fa-table"></i><a href="../form/form.php">Requested Form</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../FormPic/pic.php">NumberOfPicture</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../Diagram/Collection.php">Total recycling products</a></li>
                <li><i class="fab fa-wpforms"></i><a href="track.php">RequiredForm status</a></li>
                <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
            </form>
        </div>

    </section>

    <section id="interface">
        <div class="navigation">
        <div class="n1">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <form action="track.php" method="POST">
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
    <h3 class="i-name" style="margin-top:150px;">
    Tracking Status
    </h3>

    <div class="values">
        <div class="val-box">
            <i class="fas fa-users"></i>
            <div>
                <h3><?php echo $admin->numOfClient()?></h3> <!--Number of member-->
                <span>Total Users</span>
            </div>
        </div>
        <div class="val-box" style="margin-right:50%; ">
        <i class="fab fa-wpforms"></i>
            <div>
            <h3><?php echo $admin->numOfSubmit()?></h3><!--Number of Submit form-->
                <span >Total Requests</span>
            </div>
        </div>
    </div>


    <dir class="board">
        <table width="100%">
            <thead>
                <tr>
				<td>RequiredForm ID</td>
				<td>Current Status</td>
				<td>Last Updated</td>
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
                    $sql="SELECT *from recyclingform Where lname like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="phone") //search for phone
                {
                    $sql="SELECT *from recyclingform Where phone like '%$key%' LIMIT $offset, $records_per_page";
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
                    $sql="SELECT *from recyclingform Where saddress like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="city") //search for city
                {
                    $sql="SELECT *from recyclingform Where city like '%$key%' LIMIT $offset, $records_per_page";
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
                    $sql="SELECT *from recyclingform Where paper='$key' LIMIT $offset, $records_per_page";
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
                    $sql="SELECT *from recyclingform Where metal='$key' LIMIT $offset, $records_per_page";
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
                    $sql="SELECT *from recyclingform Where wood='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="glass") //search for glass
                {
                    $sql="SELECT *from recyclingform Where glass='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from recyclingform LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="clothes") //search for clothes
                {
                    $sql="SELECT *from recyclingform Where clothes='$key' LIMIT $offset, $records_per_page";
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
                <form method="POST" action="track.php">
                        <tbody>
                        <tr>
                        <?php 
                        if($row["SubmitID"]==$SubmitID && $num1==1)
                        {
                        ?>
                                <td class="people">
                                    <div class="people-de">
                                        <h5><?php echo $row["SubmitID"] ?></h5>
                                    </div>
                                </td>
                                <td class="people-des">
                                <select id="status" name="CurrentStatus">
                                    <?php 
                                    if($row["CurrentStatus"]=="In Process")
                                    {
                                    ?>
                                        <option value="Departing">Departing</option>
                                        <option value="Collected">Collected</option>                                    
                                    <?php 
                                    }
                                    else if($row["CurrentStatus"]=="Departing")
                                    {
                                    ?>
                                    <option value="Collected">Collected</option>
                                    <?php 
                                    }
                                    else
                                    {
                                    ?>
                                        <option value="In Process">In Process</option>
                                        <option value="Departing">Departing</option>
                                        <option value="Collected">Collected</option>
                                    <?php }?>
                                    </select>
                                </td>                                
                                <td class="people-des">
                                    <h5><?php echo $row["LastUpdated"]?></h5>
                                </td>
                                <input type="hidden" name="email" value="<?php echo $row["email"]?>">
                                <input type="hidden" name="fname" value="<?php echo $row["fname"]?>">
                                <td class="Submit"><button name="submit" value="1" onclick="return confirm('Are you sure you want to Update?')">Submit</button><button name="cancel" value="1" onclick="return confirm('Are you sure you want to Cancel?')">Cancel</button></td>
                        <?php 
                        }
                        else
                        {?>

                                <td class="people">
                                    <div class="people-de">
                                        <h5><?php echo $row["SubmitID"] ?></h5>
                                    </div>
                                </td>

                                <td class="people-des">
                                    <h5><?php echo $row["CurrentStatus"] ?></h5>
                                    <p></p>
                                </td>
                                <td class="people-des">
                                    <h5><?php echo $row["LastUpdated"]?></h5>
                                </td>

                                    <?php 
                                if($num1==1)
                                {
                                ?>
                                <td class="Cancel"><button name="cancel" value="1" onclick="return confirm('Are you sure you want to Cancel?')">Cancel</button>
                            <?php 
                                }
                                else
                                {?>
                                    <td class="Update"><button name="update" value="1" onclick="return confirm('Are you sure you want to Update?')">update</button>

                                <?php 
                                }
                                ?>

                            </tr>
                        <?php    
                        }
                        ?>
                    </tbody>   
                    <input type="hidden" name="SubmitID" value="<?php echo $row["SubmitID"]?>">
                    <input type="hidden" name="LastUpdated" value="<?php echo $row["CurrentStatus"] //store the previous value?>">
                    </form>
                <?php  
                }
            }
            else // the number of rows less than 1
            {
            ?>
                <tbody>
                <tr>
                    <td class="people">
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

</body>

</html>
  