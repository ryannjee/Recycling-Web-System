<?php 
session_start();
include "userProfileObject.php";
$userID=isset($_SESSION['userID'])?$_SESSION['userID']:"";
$key=isset($_POST["title"])?$_POST["title"]:"";
$filter=isset($_POST["filter"])?$_POST["filter"]:"";


$userDetail= new userDetail("localhost", "email", "password", "recycling");
$numberP=0;//for upload image
$result="";$photo="";
$num1=0;//for edit button

// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page9'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page9']) && is_numeric($_SESSION['current_page9'])) {
    $page = $_SESSION['current_page9'];
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
    <link rel="stylesheet" href="./Css/Profile3.css">
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
                <div class="search">
                    <i class="fas fa-search"></i>
                    <form action="tracking.php" method="POST">
                        <select name="filter" style="border:transparent;"> <!--Filter the result-->
                            <option value="Submit">Submit</option>
                        </select>
                    <input type="text" placeholder="Search" name="title">
                    <button type="submit" name="search">Search</button> 
                    </form>

                </div>
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
                    <td><b>RequiredForm ID</b></td>
                    <td><b>Email</b></td>
                    <td>Current Status</td>
                    <td>Last Updated</td>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                $sql="";
                if(isset($_POST["search"])) //filter the result
                {
                    if($filter=="Submit") //Able to search ALL
                    {
                        $sql="SELECT *from recyclingform where member='$userID' and SubmitID='$key' LIMIT $offset, $records_per_page";
                        if($key=="")
                        {
                            $sql="SELECT *from recyclingform Where member='$userID' LIMIT $offset, $records_per_page ";
                        }
                    }

                }
                else //does not search 
                {
                    $sql="SELECT *from recyclingform Where member='$userID' LIMIT $offset, $records_per_page";
                }                
                $result=mysqli_query($userDetail->conn,$sql);
                $num=mysqli_num_rows($result);
                if($num>0) //the row more than 0
                {
                while($photo=mysqli_fetch_assoc($result))
                {
            ?>
                <tr>
                    <td>
                        <div class="people-de">
                            <h5><?php echo $photo["SubmitID"] ?></h5>
                        </div>
                    </td>  
                    <td>
                        <div class="people-de">
                            <h5><?php echo $photo["email"] ?></h5>
                        </div>
                    </td>  
                    <td>
                        <div class="people-de">
                            <h5><?php echo $photo["CurrentStatus"] ?></h5>
                        </div>
                    </td>  
                    <td>
                        <div class="people-de">
                            <h5><?php echo $photo["LastUpdated"] ?></h5>
                        </div>
                    </td>  
                    
                </tr>                  
            <?php 
                }
            }
            else
            {
?>
                <tr>
                    <td class="people-des">
                        <h5><?php echo "Not found" ?></h5>
                        <p></p>
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
<?php
            }
            ?>
            </tbody>
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