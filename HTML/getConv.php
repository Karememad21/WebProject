<?php
include 'config.php';
$conn = OpenCon();
function resultToArray($result)
{
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

$user1 = $_POST['user1'];
$user2 = $_POST['user2'];

//$sql1 = "SELECT * FROM message WHERE user1_email = '$user1' and user2_email ='$user2'";
//$sql2 = "SELECT * FROM message WHERE user1_email = '$user2' and user2_email ='$user1'";
$sql = "SELECT * FROM message WHERE user1_email = '$user1' and user2_email ='$user2' 
        union 
        SELECT * FROM message WHERE user1_email = '$user2' and user2_email ='$user1'
        ORDER BY id";

$result = mysqli_query($conn, $sql);
$rows = resultToArray($result);
//$result1 = mysqli_query($conn, $sql1);
//$rows1 = resultToArray($result1);
//$result2 = mysqli_query($conn, $sql2);
//$rows2 = resultToArray($result2);
header('Content-Type: application/json');
echo json_encode(array('messages' => $rows));
//echo json_encode(array('sender' => $rows1, 'receiver' => $rows2));
exit;

//if (mysqli_num_rows($result2) > 0) {
//    // output data of each row
//    echo "<table border=2 width=50>";
//
//    while ($row = mysqli_fetch_assoc($result2)) {
//        echo "<tr>";
//        echo "<td>" . $row["body"] . "<br>";
//        echo "</tr>";
//    }
//} else {
//    echo "0 results";
//}
//echo "</table";
