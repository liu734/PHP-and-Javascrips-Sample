<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':auto_id' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: view.php' ) ;
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: view.php' ) ;
    return;
}

?>


<html>
<head>
<title>Jingye Liu's Delete Page</title>
</head>
<body>

<p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>

<form method="post"><input type="hidden"
name="auto_id" value="<?= $row['auto_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="view.php">Cancel</a>
</form>

</body>
