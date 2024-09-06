<?php  
session_start();


include "objectAdmin.php";
$admin= new admin("localhost", "email", "password", "recycling"); //connect to the object oriented of SQL for connecting the database;
$filter=isset($_POST["filter"])?$_POST["filter"]:"";
$username=isset($_POST["username"])?$_POST["username"]:"";
$email=isset($_POST["email"])?$_POST["email"]:"";
$password=isset($_POST["password"])?$_POST["password"]:"";

$fname=isset($_POST["fname"])? $_POST["fname"]:"";
$lname=isset($_POST["lname"])? $_POST["lname"]:"";
$contact=isset($_POST["contact"])? $_POST["contact"]:"";
$address=isset($_POST["address"])? $_POST["address"]:"";
$city=isset($_POST["city"])? $_POST["city"]:"";
$zipcode=isset($_POST["zipcode"])? $_POST["zipcode"]:"";
$country=isset($_POST["country"])? $_POST["country"]:"";

$userErro=$passwordErr=$emailErr=$Errfname=$Errlname=$Errphone=$Erraddress=$Errcity=$Errzip=$Errcountry="";
$key=isset($_POST["title"])?$_POST["title"]:"";
$new=isset($_SESSION["new"])?$_SESSION["new"]:0;
$door=isset($_SESSION["door"])?$_SESSION["door"]:0;

$errorP="";
$vali = new Validation ($username,$password,$email,$fname,$lname,$contact,$address,$city,$zipcode,$country);//connect to the object oriented of validation for showing the validation to users


// Set the number of records to be displayed per page
$records_per_page = 10;
$conn=mysqli_connect("localhost", "email", "password", "recycling"); 	
// Get the current page number
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


if(isset($_POST["res"]))
{
    $new=1;
    $userErro=$vali->ErrID(); 
    $passwordErr=$vali->ErrPassword();
    $emailErr=$vali->ErrEmail(); 
    $Errfname=$vali->Errfname();
    $Errlname=$vali->Errlname();
    $Errphone=$vali->Errcontact();
    $Erraddress=$vali->Errsaddress();
    $Errcity=$vali->Errcity();
    $Errzip=$vali->Errzip();
    $Errcountry=$vali->Errcountry();
    if($vali->register==10)
    {
        $errorP=$admin->register($username,$email,$password,$fname,$lname,$contact,$address,$city,$zipcode,$country) ;
        $new=0;

        if($errorP=="")
        {
            if($door==2)//going to memberDEtail
            {
                echo "<script>
                alert('Successful!!!!!');
                window.location.href = 'memberDetail.php';
                </script>";     
            }
            else
            {
                echo "<script>
                alert('Successful!!!!!');
                window.location.href = 'admin.php';
                </script>";     
            }
        }
        else if($errorP!="")
        {
            echo "<script>
            alert('$errorP');
            window.location.href = 'admin.php';
            </script>";       
        }

    }

}
if(isset($_POST["cancel"])) 
{
    if($door==10)//going to memberDEtail
    {
        $_SESSION["door"]=0; //reset the value in case showing the add detail rows
        $_SESSION["new"]=0; //reset the value in case showing the add detail rows
        header("location: memberDetail.php");
    }
    else//going back to the memberDetailpage
    {
        $_SESSION["new"]=0;  //reset the value in case showing the add detail rows
        $_SESSION["door"]=0;//reset the value in case showing the add detail rows
        header("location: admin.php");
    }
}


if(isset($_POST["delete"]))
{
    $admin->userDelete($_POST["id"]); // this button is deleted button
    echo "<script>
    alert('Delete Successfully!!!!!');
    window.location.href = 'admin.php'; //header to the admin page with the reminder
    </script>";    
} 

if(isset($_POST["edit"]))
{           
                 
    $_SESSION["id"]=$_POST["id"];
    header("location: adminRevise.php"); 
}
if(isset($_POST["add"]))
{
    $new=1;
}

if(isset($_POST["logout"])) //for user to log out
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
            <form action="admin.php" method="POST">
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
                    <form action="admin.php" method="POST">
                        <select name="filter"> <!--Filter the result-->
                            <option value="all" selected>ALL</option>
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
        <form action="admin.php" method="POST">
            <div>
                <span><button name="add" value="1" onclick="return confirm('Are you sure you want to add?')" style="color:black; font-size:16px; margin-left:50%;">Add</button></span>
            </div>
        </form> 
        </div>
    
    </div>

    <dir class="board">
        <table width="100%">
            
        <?php
             if($new==1)//if customer press the add button
             {
            ?>
            <thead>
                <tr>
                    <td>UserName</td>
                    <td>Email</td>
                    <td>Password</td>
                    <td>Fname</td>
                    <td>Lname</td>
                    <td>Contact</td>
                    <td>Address</td>
                    <td>City</td>
                    <td>ZIP</td>
                    <td>Country</td>
                    <td>Button</td>
                    <td></td>
                </tr>
            </thead>
                <tbody>
                <tr>
                    <td class="people">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Anonymous_emblem.svg/800px-Anonymous_emblem.svg.png"alt="">
                        <div class="people-de">
                        <form action="admin.php" method="POST">
                        <?php 
                        if($userErro!="")
                        {
                        ?>
                        <span class="Error"><?php echo $userErro;?></span>
                        <?php
                        }
                        ?>                   
                            <p><input type="text" name="username" placeholder="Username"></p>
                        </div>
                    </td>
                    <td class="people-des">
                    <?php 
                    if($emailErr!="")
                    {
                    ?>
                    <span class="Error"><?php echo $emailErr;?></span>
                    <?php
                    }
                    ?>
                    <p><input type="text" name="email" placeholder="Email"></p>
                    </td>

                    <td class="people-des">
                    <?php 
                    if($passwordErr!="")
                    {
                    ?>
                    <span class="Error"><?php echo $passwordErr;?></span>
                    <?php
                    }
                    ?>
                    <p><input type="text" name="password" placeholder="Password"></p>
                    </td>
                    <td class="people-des">
                    <?php 
                    if($Errfname!="")
                    {
                    ?>
                    <span class="Error"><?php echo $Errfname;?></span>
                    <?php
                    }
                    ?>                    
                    <p><input type="text" name="fname" placeholder="fname"></p>
                    </td>

                    <td class="people-des">
                    <?php
                    if($Errlname=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>
                        <span class="Error"><?php echo $Errlname?></span>
                    <?php
                    }
                    ?>
                        <h5><input type="text" name="lname" placeholder="Lname"></h5>
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
                        <h5><input type="text" name="contact" value="+60"></h5>
                    </td>
                    
                    <td class="people-des">
                    <?php
                    if($Erraddress=="")//if the error is empty this row does not appear
                    {
                                                                                    
                    }
                    else
                    {
                    ?>                        
                        <span class="Error"><?php echo $Erraddress?></span>
                        <?php
                    }
                    ?>                        
                        <h5><input type="text" name="address" placeholder="Address"></h5>
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
                        <h5><input type="text" name="city"  list="city" placeholder="City"></h5>
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
                        <h5><input type="text" name="zipcode" placeholder="ZIPCODE" ></h5>
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
                        <h5><input type="text" name="country"  list="nationality-list" placeholder="Country"></h5>
                    </td>

                        <input type="hidden" name="id" value="<?php echo $row["userID"]?>">
                    <td class="edit">
                    <?php 
                    if($new==1)
                    {
                    ?>
                    <div><button name="cancel" value="1" onclick="return confirm('Are you sure you want to cancel?')">Cancel</button></div>
                    <?php
                    }
                    else//press the cancel button 
                    {
                    ?>
                    <div><button name="add" value="1" onclick="return confirm('Are you sure you want to add?')">Add</button></div>
                    <?php 
                    }
                    ?>
                    <div><button name="res" value="1" onclick="return confirm('Are you sure you want to register?')">Enter</button></div>
                    </td>
                    </form>
                </tr>
            </tbody>                
            <?php
             }
             else//if the user cancel the button
             {
             ?>
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
                        $sql="SELECT *from users LIMIT $offset, $records_per_page ";
                    }
                }

                else if($filter=="id") // search for id 
                {
                    $sql="SELECT *from users Where userID ='$key' LIMIT $offset, $records_per_page ";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page ";
                    }
                }
                else if($filter=="email") //search for email 
                {
                    $sql="SELECT *from users Where email like '%$key%' LIMIT $offset, $records_per_page ";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page ";
                    }
                }
                else if($filter=="username") //search for username
                {
                    $sql="SELECT *from users Where username like '%$key%' LIMIT $offset, $records_per_page ";
                    if($key=="")
                    {
                        $sql="SELECT *from users LIMIT $offset, $records_per_page ";
                    }
                }
            }
            else //does not search 
            {
                $sql="SELECT *from users LIMIT $offset, $records_per_page";
            }
            $result=mysqli_query($admin->conn,$sql);
            $num=mysqli_num_rows($result); //count the number of rows
            ?>
             <?php
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
                    <form action="admin.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row["userID"]?>">
                    <td class="edit">
                    <div><button name="edit" value="1" onclick="return confirm('Are you sure you want to Edit?')">Edit</button></div>
                    <div><button name="delete" value="1" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button></div>
                    </td>
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

</script>

</body>

</html>
  