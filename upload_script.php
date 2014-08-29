<?php
    session_start();
    ini_set("allow_url_fopen", true);
    $conn = mysql_connect('localhost', $_SESSION['sess_username'], $_SESSION['sess_sql_pass']);
    mysql_select_db('content', $conn);

    $allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "mp4");
    $allowedFileType = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png", "application/pdf", "video/mp4");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

    if (in_array($_FILES["file"]["type"], $allowedFileType)
    && ($_FILES["file"]["size"] < 20000000)
    && in_array($extension, $allowedExts)) {

        if ($_FILES["file"]["error"] > 0) {
            // Error in file upload
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
        } else {
            // Give info on uploaded file
            echo "Upload: " . $_FILES["file"]["name"] . "<br>";
            echo "Type: " . $_FILES["file"]["type"] . "<br>";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

            if (file_exists("uploaded/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                "uploaded/" . $_FILES["file"]["name"]);

                $name = $_POST["name"];
                $tag = $_POST["tags"];
                $description = $_POST["description"];
                $subject = $_POST["subject"];
                $level = $_POST["level"];
                $file = $_FILES["file"]["name"];
                $uploaded_by = $_SESSION['sess_user_id'];

                $name = mysql_real_escape_string($name);
                $tag = mysql_real_escape_string($tag);
                $file = mysql_real_escape_string($file);
                $description = mysql_real_escape_string($description);
                $subject = mysql_real_escape_string($subject);
                $level = mysql_real_escape_string($level);

                $tags = explode(',', $tag);

                $query = "INSERT INTO file ( name, filename, extension, description, subject, level, uploaded_by )
                    VALUES ( '$name', '$file', '$extension', '$description', '$subject', 'level', '$uploaded_by' );";
                echo $query;
                mysql_query($query);

                $id = mysql_insert_id();
                foreach ($tags as $curr_tag) {
                    $curr_tag = mysql_real_escape_string(trim($curr_tag));
                    mysql_query("INSERT INTO tags ( file_id, tag )
                        VALUES ( '$id', '$curr_tag' );");
                }

                /*
                $url = 'http://example.com/image.php';
                $img = '/my/folder/flower.gif';
                file_put_contents($img, file_get_contents($url));


                */



                echo "Stored in: " . "uploaded/" . $_FILES["file"]["name"];
            }
        }
    } else {
        echo "Invalid file";
    }
?> 