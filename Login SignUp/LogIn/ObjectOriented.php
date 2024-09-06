<?php
class Login {
    private $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }
    public function register($username, $email, $password) { //function for registering
        $email=strtolower($email); //lowercacse for the email
        $errorP=" ";
        $check_query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT); // secure the password for preventing hacker
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            $errorP=" "; //clear the reminder to be null;
            mysqli_query($this->conn,$sql);//connect to database for checking the output
            session_start();
            $_SESSION["email"]=$email;
            header("location: ../../register/wave form.php"); 
        } 
        else {
            $errorP="Email is repeated";
        }
        mysqli_close($this->conn);
        return $errorP;
    }
    public function login($email, $password) 
    {
        $email=strtolower($email); //lowercacse for the email
        $check_query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking the output and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) { //if the number is one that mean the account is existed
            $user = mysqli_fetch_assoc($result);//store the account as a array
            if (password_verify($password, $user['password'])) {  //verify the password matches a hash.
                $sql="SELECT * From users WHERE email='$email'";
                $result=mysqli_query($this->conn,$sql);
                $row=mysqli_fetch_assoc($result);
                $username=$row["username"];
                $userID=$row["userID"];
                session_start();
                $errorP=" "; //clear the reminder to be null;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['userID'] =$userID;
                header("location: ../../Navigation/navigation.php"); 
                exit();
            } 
            else 
            {
                $errorP="Username or password is incorrect";
            }
        } else {//the account is not existed or invalid password or ID
            $errorP="Username or password is incorrect";
        }
        mysqli_close($this->conn);
        return $errorP;
    }
    public function AdminLogin($email, $password)  // this is for admin login 
    {
        $email=strtolower($email); //lowercacse for the email
        $check_query = "SELECT * FROM admin WHERE email='$email' and password='$password'";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking the output and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result == 1) 
        { //if the number is one that mean the account is existed
                session_start();
                $errorP=" "; //clear the reminder to be null;
                $_SESSION['email'] = $email;
                header("location: ../admin design html css/admin.php"); 
                exit();
            } 
         else 
         {//the account is not existed or invalid password or ID
            $errorP="Username or password is incorrect";
        }
        mysqli_close($this->conn);
        return $errorP;
    }
}
?>
<?php
		function test_input($data) // format the string
        {
            $data = trim($data); //delete the space if the input
            $data = stripslashes($data); // removes backslashes
            $data = htmlspecialchars($data); //converts special characters to their HTML entities
            return $data;
        }
class Validation
{
    private $userErro,$passwordErr,$emailErr,$LpasswordErr,$LemailErr;
    public $register,$login; // for restricting the login and register
    public function __construct($userErro,$passwordErr,$emailErr,$LpasswordErr,$LemailErr)// construct the class
    {
        $this->userErro=$userErro;
        $this->passwordErr=$passwordErr;
        $this->emailErr=$emailErr;     
        $this->LpasswordErr=$LpasswordErr;
        $this->LemailErr=$LemailErr;    
        $this->register=0;
        $this->login=0;
    }
    public function ErrID() //restrict the input for username
    {
        $error=$this->userErro; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*Name is required";
        }
        else if($error=="USER") //user does not allow to put 'USER'
        {
            $error="*This user name is invalid ('USER')";   
        }
        else //the value is not empty 
        {
            $tem= test_input($error); //use the function 
            if(strlen($error)<4) // count the string length 
            {
                $error="*At least 4 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z0-9 ]*$/",$tem))  // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Only letters,number and white space allowed";
                    $this->register=0; //return the value
                }
                else
                {
                    $error=""; //clear the value
                    $this->register+=1;
                }
            }
            else
            {
                $error="Your Name is too long";
            }
        }
        return $error;
    }
    public function ErrPassword()
    {
        $error=$this->passwordErr ;
        if(empty($error))// showing the message if the value is empty 
        {
            $error="*Password is required";
        }
        else 
        {
            $tem= test_input($error); //use the function 
            if(strlen($error)<8)// count the string length 
            {
                $error="*At least 8 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z0-9]*$/",$tem)) // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Only letters and number allowed";
                    $this->register=0;//return the value

                }
                else
                {
                    $error="";//clear the value
                    $this->register+=1;                
                }
            }
            else
            {
                $error="Your Password is too long";
            }
        }
        return $error;
    }
    public function ErrEmail()
    {
        $error=$this->emailErr;
        if(empty($error))// showing the message if the value is empty 
        {
            $error="*Email is required";
        }
        else
        {
            $tem= test_input($error);//use the function 
                if (!filter_var($tem, FILTER_VALIDATE_EMAIL)) // the users is only able to enter email form
                {
                    $error = "Invalid email format";
                    $this->register=0;//return the value
                    
                }
                else
                {
                    $error="";//clear the value
                    $this->register+=1;                
                }
        }
        return $error;
    }

    /*This is for login validation*/ 
    public function LErrPassword()
    {
        $error=$this->LpasswordErr ;
        if(empty($error))// showing the message if the value is empty 
        {
            $error="*Password is required";
        }
        else
        {
            $tem= test_input($error); //use the function 
            if(strlen($error)<8)// count the string length 
            {
                $error="*At least 8 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z0-9]*$/",$tem)) // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Only letters and number allowed";
                    $this->login=0;//return the value

                }
                else
                {
                    $error="";//clear the value
                    $this->login+=1;                
                }
            }
            else
            {
                $error="Your Password is too long";
            }
        }
        return $error;
    }
    public function LErrEmail()
    {
        $error=$this->LemailErr;
        if(empty($error))// showing the message if the value is empty 
        {
            $error="*Email is required";
        }
        else
        {
            $tem= test_input($error);//use the function 
                if (!filter_var($tem, FILTER_VALIDATE_EMAIL)) // the users is only able to enter email form
                {
                    $error = "Invalid email format";
                    $this->login=0;//return the value
                }
                else
                {
                    $error="";//clear the value
                    $this->login+=1;                
                }
        }
        return $error;
    }
}
?>