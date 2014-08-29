<?php
    session_start();
    ini_set("allow_url_fopen", true);
    $conn = mysql_connect('localhost', $_SESSION['sess_username'], $_SESSION['sess_sql_pass']);
    mysql_select_db('content', $conn);

    $name = $_POST["name"];
    $tag = $_POST["tags"];
    $description = $_POST["description"];
    $url = $_POST["url"];
    $uploaded_by = $_SESSION['sess_user_id'];

    $temp = explode("/", $url);
    $file = end($temp);

    $name = mysql_real_escape_string($name);
    $tag = mysql_real_escape_string($tag);
    $file = mysql_real_escape_string($file);
    $description = mysql_real_escape_string($description);

    $tags = explode(',', $tag);

    $query = "INSERT INTO file ( name, filename, extension, description, uploaded_by )
        VALUES ( '$name', '$file', '$extension', '$description', '$uploaded_by' );";
    echo $query;
    mysql_query($query);

    $id = mysql_insert_id();
    foreach ($tags as $curr_tag) {
        $curr_tag = mysql_real_escape_string(trim($curr_tag));
        mysql_query("INSERT INTO tags ( file_id, tag )
            VALUES ( '$id', '$curr_tag' );");
    }

    copy($url, 'uploaded/'.$file);
?> 