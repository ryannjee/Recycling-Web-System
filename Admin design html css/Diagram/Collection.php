<?php  
session_start();


include "../objectAdmin.php";
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="../Css/admin6.css">
    <style>
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
                <li><i class="fas fa-chart-pie"></i><a href="../admin.php">Dashboard</a></li>
                <li><i class="fab fa-elementor"></i><a href="../memberDetail.php">Member Detail</a></li>
                <li><i class="fas fa-table"></i><a href="../form/form.php">Requested Form</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../FormPic/pic.php">NumberOfPicture</a></li>
                <li><i class="fab fa-wpforms"></i><a href="Collection.php">Total recycling products</a></li>
                <li><i class="fab fa-wpforms"></i><a href="../Tracking/track.php">RequiredForm status</a></li>
                <li><i class="fas fa-chart-line"></i><button type="submit" name="logout" name="logout" onclick="return confirm('Are you sure you want to Log out this account?')">Log out </button></li>
            </form>
        </div>

    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">

            </div>

        <div class="profile">
            <i class="far fa-bell"></i>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Anonymous_emblem.svg/1200px-Anonymous_emblem.svg.png">
        </div>
    </div>
    <h3 class="i-name">
        Collection Diagram
    </h3>

    <div class="values">
        <div class="val-box">
            <i class="fas fa-users"></i>
            <div>
                <h3><?php echo $admin->numOfClient()?></h3> <!--Number of member-->
                <span>Total Users</span>
            </div>
        </div>
        <div class="val-box" style="margin-right:60%;">
        <i class="fab fa-wpforms"></i>
            <div>
            <h3><?php echo $admin->numOfSubmit()?></h3><!--Number of Submit form-->
                <span>Total Requests</span>
            </div>
        </div>
    
    </div>

    <dir class="board">
        <table width="100%">
        <tbody>
        <canvas id="myChart"></canvas>

        <script type="text/javascript">
            var ctx = document.getElementById("myChart").getContext('2d');

            fetch('data.php')
            .then(response => response.json())
            .then(data => {
                var products = data.map(function(item) {
                    return item.product;
                });

                var quantities = data.map(function(item) {
                    return item.quantity;
                });

                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: products,
                        datasets: [{
                            label: '# of Products',
                            data: quantities,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 159, 64, 0.8)',
                                'rgba(255, 0, 0, 0.8)',
                                'rgba(0, 255, 0, 0.8)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            })
            .catch(error => {
                console.log(error);
            });
        </script>
        </tbody>


        </table>
    </dir>
    </section>
</script>

</body>

</html>
  