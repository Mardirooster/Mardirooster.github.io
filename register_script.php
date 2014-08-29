<?php
	$username = $_POST['username'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$email = $_POST['email'];
	 
	if($password1 != $password2)
		header('Location: registration.html');
	 
	if(strlen($username) > 30)
		header('Location: registration.html');
	echo $password1;
	$hash = hash('sha256', $password1);
	echo $hash; 
	function createSalt()
	{
		$text = md5(uniqid(rand(), true));
		return substr($text, 0, 3);
	}
	 
	$salt = createSalt();
	$password = hash('sha256', $salt . $hash);

	$conn = mysql_connect('localhost', 'root', '');
	mysql_select_db('content', $conn);
	 
	//sanitize username to prevent injection
	$username = mysql_real_escape_string($username);
	 
	$query = "INSERT INTO user ( username, password, email, salt )
	VALUES ( '$username', '$password', '$email', '$salt' );";
	echo $query;
	mysql_query($query);
	 
	$id = mysql_insert_id();
	$query = "CREATE USER '".$username."'@'localhost' IDENTIFIED BY ''" ;
	mysql_query($query);

	$query = "GRANT INSERT ON content.tags TO '".$username."'@'localhost'";
	mysql_query($query);
	$query = "GRANT INSERT ON content.file TO '".$username."'@'localhost'";
	mysql_query($query);
	$query = "GRANT DELETE ON content.tags TO '".$username."'@'localhost'";
	mysql_query($query);
	$query = "GRANT DELETE ON content.file TO '".$username."'@'localhost'";
	mysql_query($query);
	$query = "GRANT SELECT ON content.tags TO '".$username."'@'localhost'";
	mysql_query($query);
	$query = "GRANT SELECT ON content.file TO '".$username."'@'localhost'";
	mysql_query($query);
	$query = "FLUSH PRIVILEGES;";
	mysql_query($query);
	mysql_close();

	echo "here";
	 
	header('Location: login.php');
?>