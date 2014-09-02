<?php
	$username = $_POST['username'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$type = $_POST['type'];
//	$email = $_POST['email'];
	 
	if($password1 != $password2)
		header('Location: registration.html');
	 
	if(strlen($username) > 30)
		header('Location: registration.html');
	$hash = hash('sha256', $password1);
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

	$query = "SELECT * FROM user WHERE username='$username'";
	$result = mysql_query($query);

	if(mysql_num_rows($result)){
		header('Location: register.php');
		exit();
	}
	 
	$query = "INSERT INTO user ( username, password, salt, account_type )
	VALUES ( '$username', '$password', '$salt', '$type' );";
	mysql_query($query);
	 
	$id = mysql_insert_id();
	$query = "CREATE USER '".$username."'@'localhost' IDENTIFIED BY '$password'" ;
	echo $query;
	mysql_query($query);

	if($account_type == 'admin'){
		$query = "GRANT ALL PRIVILEGES ON * . * TO '".$username."'@'localhost'";
		mysql_query($query);
	} else {
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
	}
	mysql_close();
	 
	header('Location: login.php');
?>