<?php 
        session_start();
        include "objectAdmin.php";
        $vali = new Validation ( isset($_POST["username"]) ? $_POST["username"] : "", "", isset($_POST["email"]) ? $_POST["email"] : "","","","","","","","");//connect to the object oriented of validation for showing the validation to users
        $admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
        $userID=isset($_SESSION["id"])?$_SESSION["id"]:"";
        $username=isset($_POST["username"])? $_POST["username"]:"";
        $email=isset($_POST["email"])? $_POST["email"]:"";
        $password=isset($_POST["password"])? $_POST["password"]:"";
        $userErro=$passwordErr=$emailErr="";
        $errorP="";
        $filter=isset($_POST["filter"])?$_POST["filter"]:"";
        $key=isset($_POST["title"])?$_POST["title"]:""; //for filter

        // Set the number of records to be displayed per page
        $records_per_page = 10;
        $conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
        if(isset($_GET['page']) && is_numeric($_GET['page'])){
            $_SESSION['current_page1'] = $_GET['page'];
            $page = $_GET['page'];
        } else if(isset($_SESSION['current_page1']) && is_numeric($_SESSION['current_page1'])) {
            $page = $_SESSION['current_page1'];
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




        if(isset($_POST["enter"])) // this button is revise the detail of users
        {
            $userErro=$vali->ErrID(); 
			$emailErr=$vali->ErrEmail(); 
            if($vali->register==2)
            {
                $admin->revise($userID,$username,$email);
            }
            else
            {
                echo "<script>
                alert('$userErro  $emailErr');
                </script>";
            }
        }
        if(isset($_POST["back"]))
        {
            header("location: admin.php"); // go back to the admin page
        }
        if(isset($_POST["change"]))
        {
            $_SESSION["identity"]=true;
            header ("location: change.php");
        }
        if(isset($_POST["delete"]))
        {
            $admin->userDelete($_POST["id"]); // this button is deleted button
            echo "<script>
            alert('Delete Successfully!!!!!');
            window.location.href = 'admin.php'; 
            </script>";  //header to the admin page with the reminder
        }
        if(isset($_POST["logout"])) //for log out button
        {
            session_destroy();//destroy the session for loging out the account
            echo "<script>
            alert('Logout  Successfully!!!!!');
            window.location.href = '../Navigation/navigation.php'; //header to the admin page with the reminder
            </script>";  
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
    <link rel="stylesheet" href="./Css/admin.css">
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
        <form action="adminRevise.php" method="POST">
            <li><i class="fas fa-chart-pie"></i><a href="#">Dashboard</a></li>
            <li><i class="fab fa-elementor"></i><a href="memberDetail.php">Required form</a></li>
            <li><i class="fas fa-table"></i><a href="./form/form.php">Requested Form</a></li>
            <li><i class="fab fa-wpforms"></i><a href="./FormPic/pic.php">NumberOfPicture</a></li>
            <li><i class="fab fa-wpforms"></i><a href="./Diagram/Collection.php">Total recycling products</a></li>
            <li><i class="fab fa-wpforms"></i><a href="./Tracking/track.php">RequiredForm status</a></li>
            <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
        <form>
        </div>
    </section>
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <form action="adminRevise.php" method="POST">
                        <select name="filter"> <!--Filter the result-->
                            <option value="all">ALL</option>
                            <option value="id">ID</option>
                            <option value="username">Username</option>
                            <option value="email">Email</option>
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
        Admin Dashboard
    </h3>

    <div class="values">
        <div class="val-box">
            <i class="fas fa-users"></i>
            <div>
                <h3><?php echo $admin->numOfClient()?></h3> 
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
            <thead>
                <tr>
                    <td>UserName</td>
                    <td>Email</td>
                    <td>Password</td>
                    <td>Status</td>
                    <td>Role</td>
                    <td></td>
                </tr>
            </thead>

            <?php 
            $sql="";
            if(isset($_POST["search"])) //filter the result
            {
                if($filter=="all") //Able to search ALL
                {
                    $sql="SELECT *from users Where userID like '%$key%' OR email like '%$key%' OR username like '%$key%' LIMIT $offset, $records_per_page ";
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
                if($row["userID"]=="$userID")
                {
            ?>
                <tbody>
                <tr>
                    <td class="people">
                    <img src="<?php 
                            echo '../userProfile/'.$row['picname'];
                    ?>" alt="">
                        <div class="people-de">
                        <form action="adminRevise.php" method="POST">
                            <h5><?php echo $row["userID"] ?></h5>
                            <p><input type="text" name="username" value="<?php echo $row["username"] ?>"></p>
                        </div>
                    </td>
                    <td class="people-des">
                        <h5><input type="text" name="email" value="<?php echo $row["email"] ?>" list="email-list"></h5>
                        <p></p>
                    </td>
                    <td class="people-des">
                        <h5><?php echo "<button name='change'><u>Change Password</u> </button>" ?></h5>
                    </td>

                    <td class="active"><p>Active</p></td>
                    <td class="role">
                        <p>Client</p>
                    </td>
                        <input type="hidden" name="id" value="<?php echo $row["userID"]?>">
                    <td class="edit"><button name="enter">Enter</button><button name="back">Back</button>
                    <button name="delete" onclick="return confirm('Are you sure you want to delete this record?')" >Delete</button></td>
                </form>
                </tr>
                <tr>
                <?php 

                }
                else
                { ?>
            </tbody>
            <?php 
            ?>
            <tbody>
                <tr>
                    <td class="people">
                    <img src="<?php 
                            echo '../userProfile/'.$row['picname'];
                    ?>" alt="">
                        <div class="people-de">
                            <h5><?php echo $row["userID"] ?></h5>
                            <p><?php echo $row["username"] ?></p>
                        </div>
                    </td>

                    <td class="people-des">
                        <h5><?php echo $row["email"] ?></h5>
                        <p></p>
                    </td>

                    <td class="people-des">
                        <h5><?php echo "**********" ?></h5>
                    </td>

                    <td class="active"><p>Active</p></td>
                    <td class="role">
                        <p>Client</p>
                    </td>
                    <form action="adminRevise.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row["userID"]?>">
                    <td class="edit"><button name="back">Back</button>
                    <button name="delete" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button></td>
                </form>
                </tr>
                <tr>
                <?php 
                }
                ?>
            </tbody>
            <?php }
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
                        <h5><?php echo "Not found" ?></h5>
                    </td>

                    <td class="active"><p>Not found</p></td>
                    <td class="role">
                        <p>Not found</p>
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

</body>

</html>