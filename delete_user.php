<?php
	session_start();

	$conn = mysql_connect('localhost', 'root', '');
        mysql_select_db('content', $conn);

	if($_SESSION["sess_user_type"] != 'admin'){
		header("Location: index.php");
		exit();
	}
	$id = mysql_real_escape_string($_POST["id"]);
	$query = "SELECT * FROM user WHERE id='$id'";
	echo $query;
	$result = mysql_query($query);

	$query = "DELETE FROM user WHERE id='$id'";
	echo $query;
	mysql_query($query);

	$row = mysql_fetch_array($result);
	$username = $row["username"];
	$query = "DROP USER '$username'@'localhost';";
	echo $query;
	mysql_query($query);
	 
	mysql_close();	 
	//header('Location: index.php');
?>