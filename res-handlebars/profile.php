<?php
// This script works even if you are not logged in
require_once 'pdo.php';
header("Content-type: application/json; charset=utf-8");
if ( !isset($_GET['profile_id']) ) die('Missing required parameter');
	
	
if ( ! isset($_COOKIE[session_name()]) ) {
    die("Must be logged in");
}

session_start();

if ( ! isset($_SESSION['user_id']) ) {
    die("ACCESS DENIED");
}

	
$retval = array();
	
$profile_id = $_GET['profile_id'];


$stmt = $pdo->prepare('SELECT * FROM Profile where profile_id like :profile_id;');
$stmt->execute(array( ':profile_id' => $profile_id));

$retval['profile'] = array();


while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    $retval['profile']['profile_id'] = $row['profile_id'];
	$retval['profile']['user_id'] = $row['user_id'];
	$retval['profile']['first_name'] = $row['first_name'];
	$retval['profile']['last_name'] = $row['last_name'];
	$retval['profile']['email'] = $row['email'];
	$retval['profile']['headline'] = $row['headline'];
	$retval['profile']['summary'] = $row['summary'];	

}




$stmt = $pdo->prepare('SELECT * FROM Position where profile_id like :profile_id order by rank;');
$stmt->execute(array( ':profile_id' => $profile_id));
$retval['positions'] = array();

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
	$positions=array();
    $positions['position_id'] = $row['position_id'];
    $positions['profile_id'] = $row['profile_id'];
    $positions['rank'] = $row['rank'];
    $positions['year'] = $row['year'];
    $positions['description'] = $row['description'];
	$retval['positions'][] = $positions;

}



$stmt = $pdo->prepare('SELECT name, year FROM Education, Institution 
where Education.institution_id = Institution.institution_id and profile_id like :profile_id order by rank;');
$stmt->execute(array( ':profile_id' => $profile_id));
$retval['schools'] = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

	$educations=array();

    $educations['year'] = $row['year'];
	$educations['name'] = $row['name'];
	$retval['schools'][]=$educations;
	
	
}

/*

$stmt = $pdo->prepare('SELECT * FROM Institution;');
$retval['schools'] = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

	$schools=array();
    $schools['institution_id'] = $row['institution_id'];
    $schools['name'] = $row['name'];
	$retval['schools'][]=$schools;


}

*/




echo(json_encode($retval));

?>
