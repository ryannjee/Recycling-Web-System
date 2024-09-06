<?php  
session_start();
include "formObject.php";
$admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$filter=isset($_POST["filter"])?$_POST["filter"]:"";
$key=isset($_POST["title"])?$_POST["title"]:"";


// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page3'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page3']) && is_numeric($_SESSION['current_page3'])) {
    $page = $_SESSION['current_page3'];
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



if(isset($_POST["add"]))
{
    header("location:update.php");
}

if(isset($_POST["delete"]))
{
    $admin->formDelete($_POST["id"]); // this button is deleted button
    echo "<script>
    alert('Delete Successfully!!!!!');
    window.location.href = 'form.php'; //header to the admin page with the reminder
    </script>";    
} 
if(isset($_POST["edit"]))
{           
    $_SESSION["SubmitID"]=$_POST["id"];
    header("location: formRevise.php"); 
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
    <link rel="stylesheet" href="../Css/admin3.css">
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
            <form action="form.php" method="POST">
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
                <div class="search">
                    <i class="fas fa-search"></i>
                    <form action="form.php" method="POST">
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
    Requested Form
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
        <form action="form.php" method="POST">
            <div>
            <span><button name="add" value="1" onclick="return confirm('Are you sure you want to add?')" style="color:black; font-size:16px; margin-left:50%;">Add</button></span>
            </div>
        </form>
        </div>
    </div>


    <dir class="board">
        <table width="100%">
            <thead>
                <tr>
                <td>RequiredForm ID</td>
                    <td>Email</td>
                    <td>Contact</td>
                    <td>Member</td>
                    <td>Saddress</td>
                    <td>City</td>
                    <td>Zip</td>
                    <td>Country</td>
                    <td>Date</td>
                    <td>Time</td>
                    <td>Paper (kg)</td>
                    <td>Plastic (kg)</td>
                    <td>Metal (kg)</td>
                    <td>Electronic (kg)</td>
                    <td>Wood (kg)</td>
                    <td>Glass (kg)</td>
                    <td>Clothes (kg)</td>
                    <td>Bricks (kg)</td>
                    <td>Point (RM)</td>
                    <td>Button (kg)</td>
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
                <tbody>
                <tr>
                    <td class="people">
                        <div class="people-de">
                            <h5><?php echo $row["SubmitID"] ?></h5>
                            <p><?php echo $row["lname"].$row["fname"] ?></p>
                        </div>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["email"] ?></h5>
                        <p></p>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["phone"] ?></h5>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["member"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["saddress"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["city"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["zip"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["country"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["date"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["time"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["paper"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["plastic"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["metal"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["electronic"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["wood"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["glass"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["clothes"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["bricks"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["point"] ?></h5>
                    </td>
                    <form action="form.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row["SubmitID"]?>">
                    <td class="edit"><button name="edit" value="1" onclick="return confirm('Are you sure you want to edit?')">Edit</button>
                    <button name="delete" value="1" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button></td>
                    </form>
                </tr>
            </tbody>
            <?php  }
            }
            else // the number of rows less than 1
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

</body>

</html>
  