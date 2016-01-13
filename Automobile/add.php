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
    	header("Location: autos.php");
    	exit();
	
	}
	elseif(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1){
		$_SESSION['error'] = "Make and Model is required";
    	header("Location: autos.php");
    	exit();		
	}

	else {$stmt = $pdo->prepare('INSERT INTO autos
        (user_id, make, model, year, mileage, price) VALUES ( :user_id, :make, :model, :year, :mileage, :price)');


    	$stmt->execute(array(
		':user_id' => $_SESSION['user_id'],
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':price' => $_POST['price']
        ));
    	
    	$_SESSION['success'] = 'Record Added';
	    header("Location: view.php");
    	exit();	
	
	}
	
	
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>


<html>
<head>
<title>Jingye Liu's Add Page</title>
</head>
<body>

<p>Add A New User</p>
<form method="post">

<p>Make:
<input type="text" name="make" ></p>
<p>Model:
<input type="text" name="model" ></p>
<p>Year:
<input type="text" name="year" ></p>
<p>Mileage:
<input type="text" name="mileage" ></p>
<p>Price:
<input type="text" name="price"></p>

<p><input type="submit" value="Add New"/>
<a href="view.php">Cancel</a></p>
</form>

</body>