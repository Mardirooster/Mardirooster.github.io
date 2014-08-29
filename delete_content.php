<?php
	session_start();

	$conn = mysql_connect('localhost', $_SESSION['sess_username'], $_SESSION['sess_sql_pass']);
        mysql_select_db('content', $conn);

	$id = mysql_real_escape_string($_GET["content"]);
	$query = "SELECT * FROM file WHERE id='$id';";
	echo $query;
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	unlink('./uploaded/'.$row['filename']);
	$query = "DELETE FROM file WHERE id=$id;";
	echo $query;
	mysql_query($query);
	 
	mysql_close();	 
	//header('Location: index.php');
?>