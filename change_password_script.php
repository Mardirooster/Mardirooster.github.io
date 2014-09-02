<?php
    
    ob_start();
    session_start();

    $username = $_POST['username'];
    $password = $_POST['curr_password'];
    $newpass = $_POST['new_password1'];
    $newpass_confirm = $_POST['new_password2'];

    $curruser = $_SESSION['sess_username'];

    if($newpass_confirm != $newpass){
        header("Location: account.php");
    }
     
    $conn = mysql_connect('localhost', 'root', '');
    mysql_select_db('content', $conn);
     
    $curruser = mysql_real_escape_string($curruser);
    $query = "SELECT id, username, password, salt
    FROM user
    WHERE username = '$curruser';";

    echo $query;
     
    $result = mysql_query($query);
     

    $userData = mysql_fetch_array($result, MYSQL_ASSOC);
    $hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
    echo $hash;
     
    if($hash != $userData["password"])
    {
        header('Location: account.php');
    }else if($_SESSION["sess_user_typ"] == 'admin'){

        function createSalt()
        {
            $text = md5(uniqid(rand(), true));
            return substr($text, 0, 3);
        }
     
        $salt = createSalt();
        $hashedpass = hash('sha256', $salt . hash('sha256', $newpass) );


        $query = "UPDATE user 
            SET password='$hashedpass', salt='$salt'
            WHERE username='$username'";
        $query = "SET PASSWORD FOR '$username'@'localhost' = PASSWORD('$hashedpass');"
        mysql_query($query);

        header('Location: index.php');
    }
?>