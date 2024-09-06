<?php 

class userDetail
{
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = mysqli_connect($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

    public function showDetailPicture($userID,$offset,$records_per_page)
    {
        $sql="SELECT *FROM users Where userID='$userID' LIMIT $offset, $records_per_page";
        $result=mysqli_query($this->conn,$sql);
        $row=mysqli_fetch_assoc($result);
        return $row;
    }
    public function showDetail($userID)
    {
        $sql="SELECT *FROM users Where userID='$userID'";
        $result=mysqli_query($this->conn,$sql);
        $row=mysqli_fetch_assoc($result);
        return $row;
    }

    public function numOfSubmit($userID) //delete table
    {
        $sql="SELECT * FROM `recyclingform` where member='$userID'";
        $result=mysqli_query($this->conn,$sql);
        $row=mysqli_num_rows($result);
        return $row;
    }

    public function numOfPoint($userID) //delete table
    {
        $sql = "SELECT SUM(point) AS total_points FROM `recyclingform` WHERE member='$userID'";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total_points'];
    }
    public function updateEmail($userID,$key)
    {
        $sql="UPDATE users Set email='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the email";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }


    public function updateFname($userID,$key)
    {
        $sql="UPDATE users Set fname='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the fname";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }
    public function updateLname($userID,$key)
    {
        $sql="UPDATE users Set lname='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the lname";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }
    public function updatecontact($userID,$key)
    {
        $sql="UPDATE users Set contact='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the contact";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }
    public function updateaddress($userID,$key)
    {
        $sql="UPDATE users Set address='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the address";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }
    public function updatecity($userID,$key)
    {
        $sql="UPDATE users Set city='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the city";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }
    public function updatezipcode($userID,$key)
    {
        $sql="UPDATE users Set zipcode='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the zipcode";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }
    public function updatecountry($userID,$key)
    {
        $sql="UPDATE users Set country='$key' where userID='$userID' ";
        if(mysqli_query($this->conn,$sql))
        {
            $message="Successful to change the country";
        }
        $message="<script>
        alert('$message');
        window.location.href = 'userProfile.php'; //header to the admin page with the reminder
        </script>"; //this is a reminder for user to know the account is successful to change 
        return $message;
    }

    function recordUploadData($userID,$picname) // reload file
    {
        $sql = "UPDATE users set picname='$picname' where userID='$userID'";        
        if (mysqli_query($this->conn, $sql)) 
        {
          $message ="Upload profile is successful";
        }
        else 
        {
            $message= "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
        return $message;
      }

      function recordUploadDataRecyclingForm($SubmitID,$picname) // reload file
      {
          $sql = "UPDATE recyclingform set picname='$picname' where SubmitID='$SubmitID'";        
          if (mysqli_query($this->conn, $sql)) 
          {
            $message ="Upload profile is successful";
          }
          else 
          {
              $message= "Error: " . $sql . "<br>" . mysqli_error($this->conn);
          }
          return $message;
        }


        public function reviseFormDetail($userID,$fname,$lname,$email,$phone,$saddress,$city,$zip,$country,$date,$time,$paper,$plastic,$metal,$electronic,$wood,$glass,$clothes,$bricks,$point) 
        {
            $sql="UPDATE recyclingform set fname='$fname',lname='$lname', email='$email',phone='$phone',saddress='$saddress',city='$city',
            zip='$zip',country='$country',date='$date',time='$time',paper='$paper',plastic='$plastic',metal='$metal',electronic='$electronic',wood='$wood',glass='$glass',clothes='$clothes',bricks='$bricks',point='$point' Where SubmitID ='$userID'";
            if(mysqli_query($this->conn,$sql))
            {
                echo "<script>
                alert('Successful!!!!!');
                window.location.href = 'userForm.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('Fail !!!');
                </script>";
            }
        }
}





class Validation
{
    function test_input($data) // format the string
    {
    $data = trim($data); //delete the space if the input
    $data = stripslashes($data); // removes backslashes
    $data = htmlspecialchars($data); //converts special characters to their HTML entities
    return $data;
    }
    private $userErro,$passwordErr,$emailErr,$fname,$lname,$phone,$address,$city,$zip,$country;
    public $register; // for restricting the login and register
    public function __construct($userErro,$passwordErr,$emailErr,$fname,$lname,$phone,$address,$city,$zip,$country)// construct the class
    {
        $this->userErro=$userErro;
        $this->passwordErr=$passwordErr;
        $this->emailErr=$emailErr;    

        $this->fname=$fname;
        $this->lname=$lname;      
        $this->phone=$phone;

        $this->address=$address;          
        $this->city=$city;
        $this->zip=$zip;  
        $this->country=$country;


        $this->register=0;
    }
    public function ErrID() //restrict the input for username
    {
        $error=$this->userErro; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*Name is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
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
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<8)// count the string length 
            {
                $error="*At least 8 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z0-9]*$/",$tem)) // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="*Only letters and number allowed";
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
            $tem= $this->   test_input($error);//use the function 
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


    public function Errfname() //restrict the input for register's first name 
    {
        $error=$this->fname; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*Name is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<0) // count the string length 
            {
                $error="*At least 1 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z ]*$/",$tem))  // the users is only able to enter A-Z/a-z
                {
                    $error="Only letters and white space allowed";
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
                $error="Your Fname is too long";
            }
        }
        return $error;
    }
    public function Errlname() //restrict the input for register's last name 
    {
        $error=$this->lname; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*Name is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<0) // count the string length 
            {
                $error="*At least 1 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z ]*$/",$tem))  // the users is only able to enter A-Z/a-z
                {
                    $error="Only letters and white space allowed";
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
                $error="Your Lname is too long";
            }
        }
        return $error;
    }

    public function Errcontact() //restrict the input for register's contact
    {
        $error=$this->phone; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*contact is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<10) // count the string length 
            {
                $error="*At least 10 digit";
            }
            else
            {
                if (!preg_match('/^\+?60(\d{1,2}-?\d{7,8}|\d{3}-\d{6,7})$/',$tem))  // The users is only allow to type the phone number format
                {
                    $error="Number format is not correct (+60xxxx) ";
                    $this->register=0; //return the value
                }
                else
                {
                    $error=""; //clear the value
                    $this->register+=1;
                }
            }
        }
        return $error;
    }
    public function Errsaddress() //restrict the input for username
    {
        $error=$this->address; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="* Street Address is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<2) // count the string length 
            {
                $error="*At least 2 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z0-9\,\.\/\\ ]*$/",$tem))  // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Only letters,number,symbol and white space allowed";
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
                $error="Your Address is too long";
            }
        }
        return $error;
    }

    public function Errcity() //restrict the input for username
    {
        $error=$this->city; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*City is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<2) // count the string length 
            {
                $error="*At least 2 digit";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z ]*$/",$tem))  // the users is only able to enter A-Z/a-z
                {
                    $error="Only letters and white space allowed";
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
                $error="Your City is too long";
            }
        }
        return $error;
    }

    public function Errzip() //restrict the input for register's contact
    {
        $error=$this->zip; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*Zip is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<5) // count the string length 
            {
                $error="*Must within 5 digit";
            }
            else if(strlen($error)==5)
            {
                if (!preg_match("/^[0-9 ]*$/",$tem))  // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Only number and white space allowed";
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
                $error="Your Zip is too long";
            }
        }
        return $error;
    }
    
    public function Errcountry() //restrict the input for username
    {
        $error=$this->country; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*country is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<2) // count the string length 
            {
                $error="*At least 2 character is required";
            }
            else if(strlen($error)<=200)
            {
                if (!preg_match("/^[a-zA-Z ]*$/",$tem))  // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Only letters and white space allowed";
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
                $error="Your Country is too long";
            }
        }
        return $error;
    }


}
?>