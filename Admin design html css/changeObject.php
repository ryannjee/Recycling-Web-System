<?php 

class change
{
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = mysqli_connect($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

//generate a random verify
    function generate_random_password() 
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; //random the number from these char
        $password = "";
        for ($i = 0; $i < 8; $i++) 
        {
          $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
      }

    //send the Verify to the user's email
    function send_password_email($email, $new_verify) 
    {
        $to = "$email";
        $subject = "Request For Password Change";
        $message = "Hello, We Had Received A Request To Change Your Password For Your Account. 
        This Is Your Verification Code To Change Your Password:
        $new_verify";
        $headers = "From: phptesting00@gmail.com";

        mail($to, $subject, $message, $headers);
    }
    public function getVerify($email)
    {
        $check_query="SELECT * FROM users WHERE email = '$email'";
        $result=mysqli_query($this->conn,$check_query);
        $row=mysqli_num_rows($result);
        if($row==1)
        {
            $verify = $this->generate_random_password();//use  the function for generating the random password

            // Send the new password to the user's email
            $this->send_password_email($email, $verify);
            echo "Your new verification code has been sent to your email.";
            session_start();//save the code value;
            $_SESSION["code"]=$verify;  
            $_SESSION["email"]=$email;
            header("location:changePwd.php");//go revise the password
        }
        else
        {
            echo "Email not found";
        }
        mysqli_close($this->conn);
    }
    public function changePwd($email,$pwd,$identity) //identify the user or admin
    {
        $email=strtolower($email); //lowercacse for the email
        $check_query="SELECT *From users Where email='$email'";
        $row=mysqli_num_rows(mysqli_query($this->conn,$check_query));

        if($row==1)
        {
            $pwd = password_hash($pwd, PASSWORD_DEFAULT); // secure the password for preventing hacker
            $sql="UPDATE users set 
            password='$pwd' where email='$email'";
            mysqli_query($this->conn,$sql);
            if($identity!=true)
            {
                echo "<script>
                alert(' Successful to change the password!!!!!');
                window.location.href = '../userProfile/userProfile.php'; 
                </script>";
            }//header to the userprofile page with the reminder
            
            else
            {
                echo "<script>
                alert(' Successful to change the password!!!!!');
                window.location.href = 'admin.php'; 
                </script>";
            }//header to the admin page with the reminder

        }    
        else
        {
            echo "We Are Currently Facing Technical Issue 
            Please Try Again Later";
        }
        mysqli_close($this->conn);
    }
}

?>