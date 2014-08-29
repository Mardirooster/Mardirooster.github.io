<?php
    // Start session
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="shortcut icon" href="/favicon.ico?">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Network Schools</title>
<style type="text/css">
#container
{
    width:900px;
    margin:0 auto;
/*  overflow:auto;*/
}
#header
{
    height:30px;
    border:solid 2px #000000
}
#nav
{
    overflow:auto;
    border:solid 2px #000000;
    margin-top:3px;
}

#main
{
    overflow:auto;
    margin-top:3px;
}

#main_left
{
    float:left;
    width:600px;
    background-color:#FFFFFF;
    min-height:400px;
}

#main_right
{
    float:right;
    width:200px;
    background-color:#FFFFFF;
    min-height:400px;
}

#footer
{
    float:bottom;
    height:40px;
    border:solid 2px #FFFFFF;
}
</style>
</head>

<body>
<FONT FACE="arial">
<div id="container">
<p style="font-size:60px"><a href="index.php" style="color: #000; text-decoration: none;">Network Schools</a></p>
<div id="main">
<hr/>
<span style="color: #808080;">
<form action="search.php" method="GET">
        <table border="0">
            <tr>
                <td>Search Terms</td>
                <td>Levels</td>
                <td>Subjects</td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="query" />
                </td>
                <td>
                    <select name="level">
                        <option value="all"><i>All</i></option>
                        <?php
                            $conn = mysql_connect('localhost', 'viewer', 'pass');
                            mysql_select_db('content', $conn);
                            $query = "SELECT DISTINCT level FROM file;";
                            $levels = mysql_query($query, $conn);
                            while($level = mysql_fetch_array($levels)) {
                                echo "<option value=\"".$level["level"]."\">".$level["level"]."</option>";
                            }

                        ?>

                    </select>
                </td>
                <td>
                    <select name="subject">
                        <option value="all"><i>All</i></option>
                        <?php
                            $conn = mysql_connect('localhost', 'viewer', 'pass');
                            mysql_select_db('content', $conn);
                            $query = "SELECT DISTINCT subject FROM file;";
                            $subjects = mysql_query($query, $conn);
                            while($subject = mysql_fetch_array($subjects)) {
                                echo "<option value=\"".$subject["subject"]."\">".$subject["subject"]."</option>";
                            }

                        ?>

                    </select>
                </td>
                <td>
                    <input type="submit" value="Search" />
                </td>
            </tr>
        </table>
    </form>
</span>
<hr/>
<div id="main_left">
<!-- Display - main page -->
<?php
    $conn = mysql_connect('localhost', 'root', '');
    mysql_select_db('content', $conn);

    $id = $_GET["query"];

    $query = "SELECT * FROM file WHERE id='$id';";

    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    echo "<object data=\"uploaded/".$row["filename"] . "\" width=\"100%\" height=\"100%\"></object>
    <p><a href=\"uploaded/".$row["filename"] . "\"  style=\"color: #000; text-decoration: none;\"><b>".$row["name"]."</b></a></p>
    <p>".$row["description"]."<p>";


?>

</div>

<div id="main_right">
<div align="right">
<p style="font-size:30px">info</p>
<div style="font-size:15px">

<?php
	if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
        echo '<p><a href="login.php" style="color: #000; text-decoration: none;">login</a></p>';
    } else {
        echo '<p>Logged in as <i><b>'.$_SESSION['sess_username'].'</b></i></p>';
        echo '<p><a href="logout.php" style="color: #000; text-decoration: none;">logout</a></p>';
    }
?>

<p><a href="register.php" style="color: #000; text-decoration: none;">registration</a></p>
<p><a href="upload.php" style="color: #000; text-decoration: none;">upload</a></p>
<p><a href="http://127.0.0.1:8008/" style="color: #000; text-decoration: none;">khan academy</a></p>
<?php
    echo "<p><a href=\"edit.php?content=".$_GET["query"]."\"style=\"color: #000; text-decoration: none;\">Edit</a></p>";
    echo "<p><a href=\"delete.php?content=".$_GET["query"]."\"style=\"color: #000; text-decoration: none;\">Delete</a></p>";
?>
</div>
</div>
</div>
</FONT> 
</body>
</html>