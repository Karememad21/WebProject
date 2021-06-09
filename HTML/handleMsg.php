<?php

include 'config.php';
$conn = OpenCon();


//$sql1 = "INSERT INTO message (user1_email,body,user2_email)
//VALUES ('noha', 'bye', 'seif')";

//if (mysqli_query($conn, $sql)) {
//  echo "New record created successfully";
//} else {
//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

//echo "getting all contacts of seif";

//echo "<br>";


//$sql2 = "SELECT user2_email FROM message WHERE user1_email = 'seif'";

//$result1 = mysqli_query($conn, $sql2);

//if (mysqli_num_rows($result1) > 0) {
// output data of each row
//  while($row = mysqli_fetch_assoc($result1)) {
//      echo $row["user2_email"]."<br>";
//  }
// } else {
//  echo "0 results";
//}


echo "getting conversation from seif to noha ";

echo "<br>";


$sql3 = "SELECT body FROM message WHERE user1_email = 'seif' and user2_email ='noha' union SELECT body FROM message WHERE user1_email = 'noha' and user2_email ='seif'";

$result2 = mysqli_query($conn, $sql3);

if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    echo "<table border=2 width=50>";

    while ($row = mysqli_fetch_assoc($result2)) {
        echo "<tr>";
        echo "<td>" . $row["body"] . "<br>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
echo "</table";


CloseCon($conn);
?>