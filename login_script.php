<?php
    
    ob_start();
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];
     
    $conn = mysql_connect('localhost', 'viewer', 'pass');
    mysql_select_db('content', $conn);
     
    $username = mysql_real_escape_string($username);
    $query = "SELECT id, username, password, salt, account_type
    FROM user
    WHERE username = '$username';";

    echo $query;
     
    $result = mysql_query($query);
     
    if(mysql_num_rows($result) == 0) // User not found. So, redirect to login_form again.
    {
        echo "not found";
        header('Location: login.html');
    }
     
    $userData = mysql_fetch_array($result, MYSQL_ASSOC);
    $hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
    echo $hash;
     
    if($hash != $userData['password']) // Incorrect password. So, redirect to login_form again.
    {
        header('Location: login.php');
    }else{ // successful login.
        
        session_regenerate_id();
        $_SESSION['sess_user_id'] = $userData['id'];
        $_SESSION['sess_username'] = $userData['username'];
        $_SESSION['sess_sql_pass'] = $userData['password'];
        $_SESSION['sess_user_type'] = $userData['account_type'];
        echo $userData['account_type'];
        session_write_close();


        header('Location: index.php');
    }
?>