<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save-button"])) {
    $id = $_POST["id"];
    $newname = $_POST["newname"];
    
     // Update the newname in the database
    $updateSql = "UPDATE locations__cities__translations SET newname = '$newname' WHERE id = $id";
    $conn->query($updateSql);
    $array = explode(" ", $newname);
    $concatenated = strtolower(implode("-", $array));
    $en="en-";
    $concatenated =strtolower($en.$concatenated);
    $updateSql1 = "UPDATE locations__cities__translations SET newslug = '$concatenated' WHERE id = $id";
    $conn->query($updateSql1);

}
header('location:filldata.php');
?>