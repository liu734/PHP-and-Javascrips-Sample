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


if ( isset($_POST['first_name']) && isset($_POST['last_name']) 
     && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) ) {


	if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
		$_SESSION['error'] = "All fields are required";
    	header("Location: add.php");
    	exit();		
	}
	
	elseif (strlen(strstr($_POST['email'],'@'))<=0){
		$_SESSION['error'] = "Email address must contain @";
    	header("Location: add.php");
    	exit();
	
	}

	else {$stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary) VALUES ( :user_id, :first_name, :last_name, :email, :headline, :summary)');


    	$stmt->execute(array(
		':user_id' => $_SESSION['user_id'],
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary']
        ));
    	
    	$_SESSION['success'] = 'Record Added';
	    header("Location: index.php");
    	exit();	
	
	}
	
	
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}


if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
?>


<html>
<head>
<title>Jingye Liu's Add Page</title>
</head>
<body>





<h1>Adding Profile for Jingye</h1>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80">
</textarea>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>

</body>
</html>