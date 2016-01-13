<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
<title>Jingye Liu's View Page</title>
</head>
<body>


<?php

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}


if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
echo('<table border="1">'."\n");



$stmt = $pdo->prepare('SELECT auto_id, make, model,  year, mileage, price FROM autos 
WHERE user_id = :uid');
$stmt->execute(array( ':uid' => $_SESSION['user_id']));

	
	
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
	echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo(htmlentities($row['price']));
    echo("</td><td>");
    echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
    echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
?>


</table>
<a href="add.php">Add New</a>
<a href="index.php?logout=True">Logout</a>

</body>

