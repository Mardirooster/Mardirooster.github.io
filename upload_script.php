<?php
    $conn = mysql_connect('localhost', 'root', '');
    mysql_select_db('content', $conn);

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))
    && ($_FILES["file"]["size"] < 20000000)
    && in_array($extension, $allowedExts)) {

        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
        } else {
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
                $tag = $_POST["tag"];
                $file = $_FILES["file"]["name"];

                $name = mysql_real_escape_string($name);
                $tag = mysql_real_escape_string($tag);
                $file = mysql_real_escape_string($file);

                $query = "INSERT INTO file ( name, filename, tag)
                    VALUES ( '$name', '$file', '$tag' );";
                echo $query;
                mysql_query($query);


                echo "Stored in: " . "uploaded/" . $_FILES["file"]["name"] . " with tags: " . $_POST["tag"];
            }
        }
    } else {
        echo "Invalid file";
    }
?> 