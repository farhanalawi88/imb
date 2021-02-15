<?php
session_start();
include "config/inc.connection.php";
$txtUsername 	= $_POST['username'];
$txtPassword	= $_POST['password'];

$query 		= "SELECT * FROM ms_user 
				WHERE username_user='".$txtUsername."' 
				AND password_user='".md5($txtPassword)."' 
				AND status_user='Active'";
$stmt 		= $koneksidb->prepare($query);
$stmt->execute();
$num = $stmt->rowCount();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($num >=1 ){
	$_SESSION['kode_user'] 	= $row['kode_user'];
	echo '<script>window.location="media.php"</script>';
}else{
	$_SESSION['pesan'] = 'Username dan password anda salah';
	echo '<script>window.location="index.php"</script>';
}


 	
	
	

?>