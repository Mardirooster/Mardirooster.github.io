<?php
	session_start();
	$conn = mysql_connect('localhost', $_SESSION['sess_username'], $_SESSION['sess_sql_pass']);
	if (!$conn){
  		die('Could not connect: ' . mysql_error());
  	}
	mysql_select_db('login', $conn);


	 
	//sanitize input to prevent injection
	$name = mysql_real_escape_string($_POST["name"]);
	$description = mysql_real_escape_string($_POST["description"]);
	$subject = mysql_real_escape_string($_POST["subject"]);
	$name = mysql_real_escape_string($_POST["name"]);
	 

	$id = $_SESSION["edited_content"];
	 
	$query = "UPDATE file
				SET name='$name', description='$description', subject='$subject'
				WHERE id='$id';";
	echo $query;
	mysql_query($query);
	 
	mysql_close();	 
	header('Location: content.php?query='.$id);
?>