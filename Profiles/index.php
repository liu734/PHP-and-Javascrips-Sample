<?php
require_once "pdo.php";
session_start();
?>


<html>
<head>
<title>Jingye Liu's View Page</title>
</head>
<body style="font-family: sans-serif;">
<h1>Jingye's Resume Registry</h1>

<?php



if ( ! isset($_SESSION['name']) ) {
    echo '<p><a href="login.php">Login</a></p>';
}
else {


	echo '<p><a href="logout.php">Logout</a></p>';
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



$stmt = $pdo->prepare('SELECT * FROM Profile');
$stmt->execute();

	
echo "<tr><th>Name</th><th>Headline</th>";

if ( isset($_SESSION['name']) ) {
echo "<th>Action</th>";
}
 
echo "</tr>\n";

 
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    $fullname=htmlentities($row['first_name'].' '.$row['last_name']);
    
	echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$fullname.'</a> ');
    echo("</td><td>");
	echo(htmlentities($row['headline']));

    
    if ( isset($_SESSION['name']) ) {
	echo("</td><td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    }
    
    echo("</td></tr>\n");
}

echo("</table>"."\n");

if ( isset($_SESSION['name']) ) {
	echo '<p><a href="add.php">Add New</a></p>';
	}



?>


</body>
</html>
