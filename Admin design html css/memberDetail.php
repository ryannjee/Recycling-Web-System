<?php  
session_start();
include "objectAdmin.php";
$admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$filter=isset($_POST["filter"])?$_POST["filter"]:"";
$key=isset($_POST["title"])?$_POST["title"]:"";



// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
// Get the current page number
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $_SESSION['current_page2'] = $_GET['page'];
    $page = $_GET['page'];
} else if(isset($_SESSION['current_page2']) && is_numeric($_SESSION['current_page2'])) {
    $page = $_SESSION['current_page2'];
} else {
    $page = 1;
}
// Get the offset value for the SQL query
$offset = ($page - 1) * $records_per_page;

// Query to get the total number of records
$total_query = "SELECT COUNT(*) as total FROM users";
$result_total = mysqli_query($conn, $total_query);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];



if(isset($_POST["delete"]))
{
    $admin->userDelete($_POST["id"]); // this button is deleted button
    echo "<script>
    alert('Delete Successfully!!!!!');
    window.location.href = 'memberDetail.php'; //header to the admin page with the reminder
    </script>";    
} 
if(isset($_POST["edit"]))
{           
    $_SESSION["id"]=$_POST["id"];
    header("location: memberDetailRevise.php"); 
}

if(isset($_POST["logout"])) //for user to log out
{
    session_destroy();//destroy the session for loging out the account
    echo "<script>
    alert('Logout  Successfully!!!!!');
    window.location.href = '../Navigation/navigation.php'; //header to the admin page with the reminder
    </script>";  
}

if(isset($_POST["add"]))
{
    $new=1;
    $_SESSION['new']=$new;
    $_SESSION['door']=10; //for come back to this page
    header("location:admin.php");
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
    <link rel="stylesheet" href="./Css/admin2.css">
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
            <img class="logo" src="./un.png" alt="">
            <h2> EcoCycle Solutions</h2>
        </div>
        <div class="items">
            <form action="memberDetail.php" method="POST">
                <li><i class="fas fa-chart-pie"></i><a href="admin.php">Dashboard</a></li>
                <li><i class="fab fa-elementor"></i><a href="memberDetail.php">Member Detail</a></li>
                <li><i class="fas fa-table"></i><a href="./form/form.php">Requested Form</a></li>
                <li><i class="fab fa-wpforms"></i><a href="./FormPic/pic.php">NumberOfPicture</a></li>
                <li><i class="fab fa-wpforms"></i><a href="./Diagram/Collection.php">Total recycling products</a></li>
                <li><i class="fab fa-wpforms"></i><a href="./Tracking/track.php">RequiredForm status</a></li>
                <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
            </form>
        </div>

    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <form action="memberDetail.php" method="POST">
                        <select name="filter"> <!--Filter the result-->
                            <option value="all" selected>ALL</option>
                            <option value="id">ID</option>
                            <option value="username">Username</option>
                            <option value="contact">contact</option>
                            <option value="address">address</option>
                            <option value="city">city</option>
                            <option value="zipcode">zipcode</option>
                            <option value="country">country</option>
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
        Member Detail
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
        <form action="memberDetail.php" method="POST">
            <div>
            <span><button name="add" value="1" onclick="return confirm('Are you sure you want to add?')" style="color:black; font-size:16px; margin-left:50%;">Add</button></span>            </div>
        </form>
    </div>

    <dir class="board">
        <table width="100%">
            <thead>
                <tr>
                    <td>UserName</td>
                    <td>Email</td>
                    <td>Contact</td>
                    <td>Address</td>
                    <td>City</td>
                    <td>ZIP</td>
                    <td>Country</td>
                    <td>Button</td>
                </tr>
            </thead>

            <?php 
            $sql="";
            if(isset($_POST["search"])) //filter the result
            {
                if($filter=="all") //Able to search ALL
                {
                    $sql="SELECT *from users Where userID like '%$key%' OR email like '%$key%' OR username like '%$key%' OR contact like '%$key%'OR address like '%$key%'OR city like '%$key%'OR zipcode like '%$key%'OR country like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }

                else if($filter=="id") // search for id 
                {
                    $sql="SELECT *from users Where userID ='$key' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="email") //search for email 
                {
                    $sql="SELECT *from users Where email like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="username") //search for username
                {
                    $sql="SELECT *from users Where username like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="contact") //search for contact
                {
                    $sql="SELECT *from users Where contact like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="address") //search for address
                {
                    $sql="SELECT *from users Where address like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="city") //search for city
                {
                    $sql="SELECT *from users Where city like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="zipcode") //search for zipcode
                {
                    $sql="SELECT *from users Where zipcode like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
                else if($filter=="country") //search for country
                {
                    $sql="SELECT *from users Where country like '%$key%' LIMIT $offset, $records_per_page";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page";
                    }
                }
            }
            else //does not search 
            {
                $sql="SELECT *from users LIMIT $offset, $records_per_page";
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
                    <img src="<?php 
                            echo '../userProfile/'.$row['picname'];
                    ?>" alt="">
                        <div class="people-de">
                            <h5><?php echo $row["userID"] ?></h5>
                            <p><?php echo $row["lname"].$row["fname"] ?></p>
                        </div>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["email"] ?></h5>
                        <p></p>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["contact"] ?></h5>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["address"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["city"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["zipcode"] ?></h5>
                    </td>
                    <td class="people-des">
                        <h5><?php echo $row["country"] ?></h5>
                    </td>


                    <form action="memberDetail.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row["userID"]?>">
                    <td class="edit"><button name="edit" value="1" onclick="return confirm('Are you sure you want to Edit?')">Edit</button>
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
  