<?php 
class admin
{
    public $conn;
    
    public function __construct($server, $username, $password, $database) // Constructor method
	{
        $this->conn = new mysqli($server, $username, $password, $database); //connect to the database
        if (!$this->conn) { // if connect fail 
            die("Connect failed: " .$this->conn.mysqli_connect_error()); 
        }
    }

    public function formDelete($id) //delete table
    {
        $sql="DELETE from recyclingform where SubmitID='$id'";
        if(mysqli_query($this->conn,$sql))
        {
            echo "Delete Successfully";
        }
    }

    public function numOfClient() //delete table
    {
        $sql="SELECT *from users";
        $result=mysqli_query($this->conn,$sql);
        $row=mysqli_num_rows($result);
        return $row;
    }

    public function numOfSubmit() //delete table
    {
        $sql="SELECT * FROM `recyclingform`";
        $result=mysqli_query($this->conn,$sql);
        $row=mysqli_num_rows($result);
        return $row;
    }


    function recordUploadData($SubmitID,$picname) // reload file
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
}

?>