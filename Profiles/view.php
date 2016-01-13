<?php
require_once "pdo.php";
session_start();


if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}




$stmt = $pdo->prepare('SELECT * FROM Profile
WHERE profile_id = :pid');
$stmt->execute(array( ':pid' => $_GET['profile_id']));

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Could not load profile';
    header( 'Location: index.php' ) ;
    return;
}


	echo '<h1>Profile information</h1>';

	
	

	echo ('<br/><p>');
    echo ("First Name: ".htmlentities($row['first_name']));
    echo ('</p><p>');
    echo ("Email: ".htmlentities($row['email']));
    echo ('</p><p>');
    echo ("Headline: ");
    echo ('</p><p>');
    echo (htmlentities($row['headline']));
    echo ('</p><p>');
    echo ("Summary: ");
    echo ('</p><p>');
    echo (htmlentities($row['summary']));
    echo ('</p><br/>');

?>


<html>
<head>
<title>Jingye Liu's View Page</title>
</head>
<body>



<a href="index.php">Done</a>

</body>
</html>

