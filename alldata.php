<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "countrynames";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$limit = 20;
$pagenum = $_GET['page'];
$offset = ($pagenum-1)*$limit;

$sql = "SELECT city.*, country.id AS country_id, country.name AS country_name
FROM locations__cities__translations AS city
INNER JOIN locations__countries_translations AS country ON city.country_id = country.country_id and country.locale='en'
WHERE city.locale = 'en' 
LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<style>
   

</style>

<!DOCTYPE html>
<html lang="en" title="Coding design">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Responsive HTML Table With Pure CSS - Web Design/UI Design</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="table">
        <section class="table__header">
            <h1>locations_cities_translations</h1>
            <div>
            <form action="sumit" class="links">
               <a  href="index.php?page=1">Show Null</a>
               <a  href="filldata.php?page=1">Show Filled</a>
              
                <a  href="alldata.php?page=1">Show All</a>
               </form>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> SN </th>
                        <th>cuntry </th>
                        <th> city old Name </th>
                        <th> City New Name </th>
                        <th> City old slug </th>
                        <th> City new slug  </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $num = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td> " . $num++ . "</td>";
                            echo "<td> <input type='text' name='newname' value='" . $row["country_name"] . "'></td>";
                            echo "<td><input type='text' name='newname' value='" . $row["name"] . "'></td>";
                            echo "<form method='post' action=''>";
                            echo "<td><input type='text' name='id' value='" . $row["newname"] . "'></td>";
                            echo "<td><input type='text' name='newname' value='" . $row["slug"] . "'></td>";
                            echo "<td><input type='text' name='newname' value='" . $row["newslug"] . "'></td>";
                            echo "</form>";
                            echo "</tr>";
                            
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <div class="Pagination">
    <?php
     echo '<ul>';
     echo '<li><a href="alldata.php?page=1">First</a></li>';
    $sql2 = "SELECT * FROM locations__cities__translations WHERE locale = 'en'";
    $result2 = $conn->query($sql2);
    $totalpages = mysqli_num_rows($result2)/20;
    $totalpages = ceil($totalpages);
 
    if (mysqli_num_rows($result2) > 0) {
        $total_records = mysqli_num_rows($result2);
        $total_page = ceil($total_records / $limit);
       
              if (isset($_GET['page'])) {
            $current_page = $_GET['page'];
        } else {
            $current_page = 1;
        }
                $start = max(1, $current_page - 2);
        $end = min($total_page, $current_page + 2);
        
       
        if ($current_page > 1) {
            echo '<li><a href="alldata.php?page='.($current_page - 1).'">Prev</a></li>';
        }
        
        for ($i = $start; $i <= $end; $i++) {
            echo '<li><a href="alldata.php?page='.$i.'"';
         
            if ($i == $current_page) {
                echo ' class="current"';
            }
            
            echo '>'.$i.'</a></li>';
        }
                if ($current_page < $total_page) {
            echo '<li><a href="alldata.php?page='.($current_page + 1).'">Next</a></li>';
        }
        echo '<li><a href="alldata.php?page='.$totalpages.'">Last</a></li>';
        echo '</ul>';
    }
    ?>
</div>

    </main>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save-button"])) {
    $id = $_POST["id"];
    $newname = $_POST["newname"];
    
     // Update the newname in the database
    $updateSql = "UPDATE locations__cities__translations SET newname = '$newname' WHERE id = $id";
    $conn->query($updateSql);
    $array = explode(" ", $newname);
    $concatenated = implode("_", $array);
    $en="en_";
    $concatenated =strtolower($en.$concatenated);
    $updateSql1 = "UPDATE locations__cities__translations SET newslug = '$concatenated' WHERE id = $id";
    $conn->query($updateSql1);
}
?>
