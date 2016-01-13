<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['cancel'])){
	header("Location: index.php");
    exit();

}



if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM profile WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':profile_id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Profile deleted';
    header( 'Location: index.php' ) ;
    return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = "Can't load the data";
    header( 'Location: index.php' ) ;
    return;
}

?>


<html>
<head>
<title>Jingye Liu's Delete Page</title>
</head>
<body>

<h1>Deleteing Profile</h1>
<p>First Name: <?= htmlentities($row['first_name']) ?></p>
<p>Last Name: <?= htmlentities($row['last_name']) ?></p>

<form method="post">
<input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
<input type="submit" value="Delete" name="delete">
<input type="submit" value="Cancel" name="cancel">
</form>

</body>
</html>
