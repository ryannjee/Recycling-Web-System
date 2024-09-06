<?php

class fillUp #class name
{
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        //check database connection
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) 
        { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }

    }
    public function register($email,$fname,$lname,$contact,$address,$city,$zipcode,$country,$picname) 
    { //function for registering
        $errorP=" ";
        $check_query = "SELECT * FROM users";
        $result = mysqli_query($this->conn,$check_query); //connect to database for checking and getting the output
        $check_result = mysqli_num_rows($result);//check the number of rows

        if ($check_result >= 0) 
        {
            $sql="UPDATE users set fname='$fname', lname='$lname',contact='$contact',address='$address',city='$city',zipcode='$zipcode',country='$country',picname='$picname' 
            Where email='$email'"; //sql code
            $errorP=" "; //clear the reminder to be null;
            mysqli_query($this->conn,$sql);//connect to database for checking the output
            echo "<script>
            alert('Please Log into your account that you \'ve created');  
            window.location.href = '../Login SignUp/LogIn/login.php'; 
            </script>"; // header on login page with reminder
        } 
        else {
            $errorP="Fail to register"; //giving the default message
        }
        mysqli_close($this->conn);
        return $errorP;//return value for $errorP
    }
}

?>
<?php

class Validation
{


    private $fname,$lname,$contact,$address,$city,$zip,$country;
    public $register; // to restrict the login page and register page
    public function __construct($fname,$lname,$contact,$address,$city,$zip,$country)// constructer for the class
    {
        $this->fname=$fname;
        $this->lname=$lname;
        $this->contact=$contact;  

        $this->address=$address;          
        $this->city=$city;
        $this->zip=$zip;  
        $this->country=$country;    
        $this->register=0;
    }

    function test_input($data) // format the string
    {
        $data = trim($data); //delete the space if the input
        $data = stripslashes($data); // removes backslashes
        $data = htmlspecialchars($data); //converts special characters to their HTML entities
        return $data;
    }
    public function Errfname() //restrict the input for register's first name 
    {
        $error=$this->fname; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="*Name is required";
        }
        else //if the value is nnot empty
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<0) // count the string length 
            {
                $error="*At least 1 digit"; //will shows a message which requires the users to make the input
            }
            else if(strlen($error)<=200)//restrict users to enter 200 characters only
            {
                if (!preg_match("/^[a-zA-Z ]*$/",$tem))  // the users is only able to enter A-Z/a-z
                {
                    $error="Only letters and white space allowed";
                    $this->register=0; //return the value
                }
                else//if the users key in correctly within the scope will get enter to here
                {
                    $error=""; //clear the value
                    $this->register+=1;//can register
                }
            }
            else//if the user exceed the limitation of 200 characters
            {
                $error="Your Fname is too long";
            }
        }
        return $error;//return value
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
                $error="*At least 1 digit"; //will shows a message which requires the users to make the input
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
        $error=$this->contact; // showing the error message 
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
            }        }
        
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