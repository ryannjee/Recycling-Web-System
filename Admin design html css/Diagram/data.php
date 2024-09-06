
<?php

$paper = $plastic = $metal = $electronic = $wood = $glass = $clothes = $bricks = 0;

$conn = mysqli_connect("localhost","user","password","recycling");
if(!$conn) {
    die("Connect failed: " . mysqli_connect_error());
}

$sql1 = "SELECT sum(paper) FROM recyclingform"; // count the number of recycling item 
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);
$paper = $row1["sum(paper)"];

$sql2 = "SELECT sum(plastic) FROM recyclingform"; // count the number of recycling item 
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$plastic = $row2["sum(plastic)"];

$sql3 = "SELECT sum(metal) FROM recyclingform"; // count the number of recycling item 
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_assoc($result3);
$metal = $row3["sum(metal)"];

$sql4 = "SELECT sum(electronic) FROM recyclingform"; // count the number of recycling item 
$result4 = mysqli_query($conn, $sql4);
$row4 = mysqli_fetch_assoc($result4);
$electronic = $row4["sum(electronic)"];

$sql5 = "SELECT sum(wood) FROM recyclingform"; // count the number of recycling item 
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$wood = $row5["sum(wood)"];

$sql6 = "SELECT sum(glass) FROM recyclingform"; // count the number of recycling item 
$result6 = mysqli_query($conn, $sql6);
$row6 = mysqli_fetch_assoc($result6);
$glass = $row6["sum(glass)"];

$sql7 = "SELECT sum(clothes) FROM recyclingform"; // count the number of recycling item 
$result7 = mysqli_query($conn, $sql7);
$row7 = mysqli_fetch_assoc($result7);
$clothes = $row7["sum(clothes)"];

$sql8 = "SELECT sum(bricks) FROM recyclingform"; // count the number of recycling item 
$result8 = mysqli_query($conn, $sql8);
$row8 = mysqli_fetch_assoc($result8);
$bricks = $row8["sum(bricks)"];

mysqli_close($conn);





$data = array(
    array("product" => "Paper(kg)", "quantity" => $paper),
    array("product" => "Plastic(kg)", "quantity" => $plastic),
    array("product" => "Metal(kg)", "quantity" => $metal),
    array("product" => "Electronic(kg)", "quantity" => $electronic),
    array("product" => "Wood(kg)", "quantity" => $wood),
    array("product" => "Glass(kg)", "quantity" => $glass),
    array("product" => "Clothes(kg)", "quantity" => $clothes),
    array("product" => "Bricks(kg)", "quantity" => $bricks),

);

echo json_encode($data); // converts array or object into a JSON string

?>