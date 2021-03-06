<?php
    // Start session
    session_start();

    //Check whether the session variable SESS_MEMBER_ID is present or not
    if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
        header("location: login.php");
        exit();
    } else {
        $conn = mysql_connect('localhost', 'root', '');
        mysql_select_db('content', $conn);

        $id = mysql_real_escape_string($_GET["content"]);
        $query = "SELECT * FROM file WHERE id='$id'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        if($_SESSION["sess_user_type"] != 'admin' && $row["uploaded_by"] != $_SESSION['sess_user_id']){
            header("location: content.php?query=".$id);
            exit();
        }
    }
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
    float:left;
    width:260px;
    background-color:#FFFFFF;
    min-height:400px;
}

#footer
{
    height:40px;
    border:solid 2px #FFFFFF;
}

.select-editable { position:relative; background-color:white; border:solid grey 1px;  width:120px; height:18px; }
.select-editable select { position:absolute; top:0px; left:0px; font-size:14px; border:none; width:120px; margin:0; }
.select-editable input { position:absolute; top:0px; left:0px; width:100px; padding:1px; font-size:12px; border:none; }
.select-editable select:focus, .select-editable input:focus { outline:none; }
</style>
</head>

<body>
<FONT FACE="arial">
<div id="container">
<p style="font-size:60px">Network Schools</p>
<div id="main">
<hr/>
<span style="color: #808080;">
    <form action="search.php" method="GET">
        <input type="text" name="query" />
        <input type="submit" value="Search" />
    </form>
</span>
<hr/>
<div id="main_left">
<?php
    echo "<form id=\"edit\" action=\"delete_content.php?content=".$_GET["content"]."\" method=\"post\" enctype=\"multipart/form-data\">";
?>
    <p>Are you sure you want to delete this file?<p>
    <p><input type="submit" name="submit" value="Submit"></p>

</form>
</div>
<div id="main_right">
<div align="right">
<p style="font-size:30px">info</p>
<div style="font-size:15px">

<?php
    if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
        echo '<p><a href="login.php" style="color: #000; text-decoration: none;">login</a></p>';
    } else {
        echo '<p>Logged in as <i><b><a href="login.php" style="color: #000; text-decoration: none;">'.$_SESSION['sess_username'].'</a></b></i></p>';
        echo '<p><a href="logout.php" style="color: #000; text-decoration: none;">logout</a></p>';
        if($_SESSION['sess_user_type'] == 'admin') {
            echo '<p><a href="management.php" style="color: #000; text-decoration: none;">management</a></p>';
        }
    }

?>

<p><a href="register.php" style="color: #000; text-decoration: none;">registration</a></p>
<p><a href="upload.php" style="color: #000; text-decoration: none;">upload</a></p>
</div>
</div>
</div>
</FONT> 
</body>
</html>
