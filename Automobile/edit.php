<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['make']) && isset($_POST['model']) 
     && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['price']) ) {
     
     
     
    if ((!is_numeric($_POST['year'])) || (!is_numeric($_POST['mileage']))|| (!is_numeric($_POST['price']))){
		$_SESSION['error'] = "Mileage, year and price must be numeric";
    	header("Location: view.php");
    	exit();
	
	}
	elseif(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1){
		$_SESSION['error'] = "Make and Model is required";
    	header("Location: view.php");
    	exit();		
	}


    // Data validation should go here (see add.php)
    else{$sql = 'UPDATE autos SET make = :make, 
    		model = :model,
            year = :year, 
            mileage = :mileage,
            price = :price
            WHERE auto_id = :auto_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':price' => $_POST['price'],
        ':auto_id' => $_POST['auto_id']
        ));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: view.php' ) ;
    return;
    
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: view.php' ) ;
    return;
}

$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
$price = htmlentities($row['price']);
$auto_id = htmlentities($row['auto_id']);


?>

<html>
<head>
<title>Jingye Liu's Edit Page</title>
</head>
<body>


<p>Edit User</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $make ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $model ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $year ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mileage ?>"></p>
<p>Price:
<input type="text" name="price" value="<?= $price ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Update"/>
<a href="view.php">Cancel</a></p>
</form>

</body>