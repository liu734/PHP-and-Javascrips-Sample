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

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}




if ( isset($_POST['first_name']) && isset($_POST['last_name']) 
     && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) ) {
     
     

	if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
		$_SESSION['error'] = "All fields are required";
    	header('Location: edit.php?profile_id='.$_GET['profile_id']);
    	exit();		
	}
	elseif (strlen(strstr($_POST['email'],'@'))<=0){
		$_SESSION['error'] = "Email address must contain @";
    	header('Location: edit.php?profile_id='.$_GET['profile_id']);
    	exit();
	
	}



    // Data validation should go here (see add.php)
    else{$sql = 'UPDATE Profile SET  first_name= :first_name, 
    		last_name = :last_name,
            email = :email, 
            headline = :headline,
            summary = :summary
            WHERE profile_id = :profile_id';
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_GET['profile_id']
        ));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
    
    }
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Could not load profile';
    header( 'Location: index.php' ) ;
    return;
}

$first_name = htmlentities($row['first_name']);
$last_name = htmlentities($row['last_name']);
$email = htmlentities($row['email']);
$headline = htmlentities($row['headline']);
$summary = htmlentities($row['summary']);




?>

<html>
<head>
<title>Jingye Liu's Edit Page</title>
</head>
<body>


<h1>Edit Profile for Jingye</h1>



<form method="post">
<p>First Name:
<input type="text" name="first_name" value="<?= $first_name ?>" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" value="<?= $last_name ?>" size="60"/></p>
<p>Email:
<input type="text" name="email" value="<?= $email ?>" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" value="<?= $headline ?>" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary"  rows="8" cols="80"> <?= $summary ?>
</textarea>
<input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>">

<p>
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>

</form>


</body>
</html>