<?php 
class status
{

    public $conn;
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

    public function update($SubmitID,$CurrentStatus,$LastUpdated)
    {
        $messsage="";
        $sql = "UPDATE recyclingform SET `CurrentStatus`='$CurrentStatus', `LastUpdated`='$LastUpdated' WHERE `SubmitID`='$SubmitID'";
        if (mysqli_query($this->conn, $sql)) 
        {
            $messsage="Status updated successfully.";
        } 
        else 
        {
            $messsage="Error updating status: " . mysqli_error($this->conn);
        }
        return $messsage;
    }
}



class notificationEmail
{ // this is send the advertisement to users

    public function Inprocess($email,$SubmitID,$name,$status) 
    {

        $to = "$email";
        $subject = "Recycling Pickup Update From Required From ID: $SubmitID";
        $message = "
Dear $name,

        We wanted to inform you that the status of your recycling pickup has been updated in our tracking system. Your recycling products are now ready to be picked up from your designated location.
        
        The current status of your pickup is: $status
        
        Please make sure to check the pickup status that you scheduled with us. If you have any questions or concerns, please do not hesitate to reply to this email.
        
        Thank you for your continued business with us.
        
Best regards,
CEO,PERTH,
EcoCycle Solutions";

        $headers = "From: phptesting00@gmail.com";

        mail($to, $subject, $message, $headers);
    }
}
?>