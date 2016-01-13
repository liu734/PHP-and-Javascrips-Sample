<?php // Do not put any HTML above this line

// session_start() and header() fail if any (even one
// character) of output has been sent.
require_once "pdo.php";
session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);

$salt = 'XyZzy12*_';
//$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123





// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        header('Location: index.php');
    	exit();
    } else {
    
    
        $check = hash('md5', $salt.$_POST['pass']);
        
        $stmt = $pdo->prepare('SELECT user_id, name FROM users 
        WHERE email = :em AND password = :pw');
		$stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        if ( $row !== false  ) {
			$_SESSION['name'] = $row['name'];
    		$_SESSION['user_id'] = $row['user_id'];
    		// Redirect the browser to autos.php
    		header("Location: index.php");
    		exit();
        } else {
        	$_SESSION['error'] = "Incorrect password";
        	header('Location: login.php');
    		exit();

        }
    }
}


if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
    }
    
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}




// Fall through into the View 
?>
<!DOCTYPE html>
<html>
<head>
<title>Jingye Liu's Login Page</title>
</head>
<body style="font-family: sans-serif;">
<h1>Please Log In</h1>

<form method="POST" action="login.php">
<label for="nam">Email</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>



<input type="submit" value="Log In">


</form>


<p>
For a password hint, view source and find a password hint 
in the HTML comments.
<!-- Hint: The password is php followed by 123 -->
</p>
</p>



</body>
</html>