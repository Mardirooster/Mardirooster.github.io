<?php
    // Start session
    session_start();

    //Check whether the session variable SESS_MEMBER_ID is present or not
    if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
        header("location: login.php");
        exit();
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

<button onclick="displayLocal()">Upload From File</button>

<form id="local_upload" action="upload_script.php" method="post" enctype="multipart/form-data">
        <table width="510" border="0" align="center">
            <tr>
                <td colspan="2"><p><strong>Local File Upload</strong></p></td>
            </tr>
            <tr>
                <td><label for="file">Filename:</label></td>
                <td><input type="file" name="file" id="file"></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name"/></td>
            </tr>
            <tr>
                <td>Subject:</td>
                <td>
                    <div class="select-editable">
                      <select onchange="this.nextElementSibling.value=this.value">
                        <option value=""></option>

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
                      <input type="text" name="subject" value=""/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Level:</td>
                <td>
                    <div class="select-editable">
                      <select onchange="this.nextElementSibling.value=this.value">
                        <option value=""></option>

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
                      <input type="text" name="level" value=""/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Tags:</td>
                <td><input type="text" name="tags"></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea name="description"  cols="40" rows="4"></textarea></td>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>

<button onclick="displayURL()">Download From URL</button>

<form id="url_download" action="upload_script_url.php" method="post" enctype="multipart/form-data">
        <table width="510" border="0" align="center">
            <tr>
                <td colspan="2"><p><strong>Download From URL</strong></p></td>
            </tr>
            <tr>
                <td>URL:</td>
                <td><input type="text" name="url"/></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name"/></td>
            </tr>
            <tr>
                <td>Subject:</td>
                <td>
                    <div class="select-editable">
                      <select onchange="this.nextElementSibling.value=this.value">
                        <option value=""></option>

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
                      <input type="text" name="subject" value=""/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Level:</td>
                <td>
                    <div class="select-editable">
                      <select onchange="this.nextElementSibling.value=this.value">
                        <option value=""></option>

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
                      <input type="text" name="level" value=""/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Tags:</td>
                <td><input type="text" name="tags"></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea name="description"  cols="40" rows="4"></textarea></td>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</div>

<script>
var link = document.getElementById('local_upload');
link.style.display = 'none';
var link = document.getElementById('url_download');
link.style.display = 'none';

function displayLocal() {
    var link = document.getElementById('local_upload');
    link.style.display = 'block';
}
function displayURL() {
    var link = document.getElementById('url_download');
    link.style.display = 'block';
}
</script>

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
</div>
</div>
</div>
</FONT> 
</body>
</html>
