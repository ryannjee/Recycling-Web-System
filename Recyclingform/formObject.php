<?php 
class upload
{
    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = mysqli_connect($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

    function recordUploadData($fname,$lname,$email,$phone,$member,$saddress,$city,$zip,$country,$date,$time,$paper,$plastic,$metal,$electronic,$wood,$glass,$clothes,$bricks,$picname,$point) // reload file
    {
        $sql = "INSERT INTO recyclingform (fname, lname, email, phone, member, 
        saddress, city, zip, country, date, time, paper, plastic, metal, electronic, 
        wood, glass, clothes, bricks, picname, point) VALUES
        ('$fname','$lname','$email','$phone','$member', '$saddress', '$city', '$zip', '$country',
        '$date', '$time', '$paper', '$plastic', '$metal', '$electronic', '$wood', '$glass', '$clothes',
        '$bricks', '$picname',$point);";        
        if (mysqli_query($this->conn, $sql)) 
        {
          $message ="New record created successfully";
        }
        else 
        {
            $message= "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
        return $message;
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
    private $fname,$lname,$email,$phone,$saddress,$city,$zip,$country;
    public $register; // for restricting the login and register
    public function __construct($fname,$lname,$email,$phone,$saddress,$city,$zip,$country)// construct the class
    {
        $this->fname=$fname;
        $this->lname=$lname;
        $this->email=$email;       
        $this->phone=$phone;
        $this->saddress=$saddress;
        $this->city=$city;   
        $this->zip=$zip;
        $this->country=$country;

        $this->register=0;
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
                $error="*At least 1 digi";
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
                $error="*At least 1 digi";
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
    public function ErrEmail()
    {
        $error=$this->email;
        if(empty($error))// showing the message if the value is empty 
        {
            $error="*Email is required";
        }
        else
        {
            $tem= $this->test_input($error);//use the function 
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
                $error="*At least 10 digi";
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
        $error=$this->saddress; // showing the error message 
        if(empty($error)) // showing the message if the value is empty 
        {
            $error="* Street Address is required";
        }
        else //the value is not empty 
        {
            $tem= $this->test_input($error); //use the function 
            if(strlen($error)<2) // count the string length 
            {
                $error="*At least 2 digi";
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
                $error="*At least 2 digi";
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
                $error="*Must within 5 digi";
            }
            else if(strlen($error)==5)
            {
                if (!preg_match("/^[0-9 ]*$/",$tem))  // the users is only able to enter A-Z/a-z/0-9
                {
                    $error="Number and white space allowed";
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
                $error="*At least 2 digi";
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



class Email{ // this is send the advertisement to users

    public function Sub($email) 
    {
        $to = "$email";
        $subject = "Recycling Information and Tips for a Greener Planet";
        $message = "
Dear Volunteer,

        We hope this email finds you well. As part of our commitment to the environment, we would like to share with you some useful recycling information and tips that can help reduce waste and contribute to a greener planet.
        Recycling is a simple yet effective way to conserve natural resources, reduce greenhouse gas emissions, and minimize the amount of waste that ends up in landfills. Here are some important facts and tips about recycling that you may find helpful:
        
        1. Recycling reduces the need for raw materials. By recycling, we can conserve natural resources such as trees, water, and minerals, which are often used to make new products.
        
        2. Recycling helps reduce greenhouse gas emissions. When waste is buried in landfills, it produces methane gas, which is a potent greenhouse gas that contributes to climate change. Recycling helps reduce the amount of waste that goes into landfills, which in turn reduces methane emissions.
        
        3. Recycling is easy and convenient. Most communities have curbside recycling programs that make it easy to recycle common materials such as paper, plastic, glass, and metal. You can also find recycling bins in many public places, such as parks, airports, and schools.
        
        4. You can recycle more than you think. In addition to common materials like paper and plastic, you can also recycle items such as electronics, batteries, and even clothes. Check with your local recycling program to find out what items they accept.
        
        5. Recycling saves energy. When we recycle, we use less energy than we would if we were to make products from raw materials. This is because recycling requires less processing and transportation, which in turn reduces energy consumption.
        
        We hope these recycling tips and information are helpful to you. By making small changes in our daily habits, we can all make a big difference in protecting the planet for future generations.
        Thank you for your attention to this important matter.
        
Best regards,
EcoCycle Solutions";

        $headers = "From: phptesting00@gmail.com";

        mail($to, $subject, $message, $headers);
    }
}


class notificationEmail{ // this is send the advertisement to users

    public function Sub($email,$date,$time,$fname) 
    {

        $to = "$email";
        $subject = "Scheduled Recycling Pickup Service for Your Home - $date and $time";
        $message = "
Dear [$fname],

    At [EcoCycle Solutions], we are committed to helping our community reduce waste and minimize its impact on the environment. As a part of our ongoing efforts, we are pleased to inform you that our team will be coming to your home on [$date] at [$time] to pick up your recyclable materials.
        
    We understand that it can be difficult to find the time and energy to drop off your recyclables at a designated center. With our pickup service, we'll come to your house at a scheduled time that works for you and pick up your recyclable materials, making it easy for you to participate in the recycling program.
        
    To prepare for our visit, please ensure that your recyclable materials are separated and ready for pickup. Our team will arrive at your home with all the necessary equipment to collect your recyclables safely and efficiently. We'll then transport the materials to our recycling center where they'll be processed and prepared for reuse.
        
    Our pickup service is available on a regular basis or as a one-time event, depending on your needs. Whether you're looking for a convenient way to dispose of your recyclables or want to make a positive impact on the environment, our pickup service is the perfect solution.
        
    If you have any questions or concerns regarding our pickup service, please do not hesitate to reply to this email .
        
    Thank you for your commitment to a sustainable future, and we look forward to seeing you soon.
        
Best regards,
CEO,PERTH,    
EcoCycle Solutions";

        $headers = "From: phptesting00@gmail.com";

        mail($to, $subject, $message, $headers);
    }
}
?>

