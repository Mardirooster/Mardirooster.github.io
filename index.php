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
</style>
</head>

<body>
<FONT FACE="arial">
<div id="container">
<p style="font-size:60px">Network Schools</p>
<div id="main">
<hr/>
<span style="color: #808080;">
<!-- right side -->
</span>
<hr/>
<div id="main_left">
<!-- announcements - main page -->
</div>

<div id="main_right">
<div align="right">
<p style="font-size:30px">info</p>
<div style="font-size:15px">

<?php
	if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
?>
        <p><a href="login.html" style="color: #000; text-decoration: none;">login</a></p>
<?php    
    } else {
?>
        <p><a href="logout.php" style="color: #000; text-decoration: none;">logout</a></p>
    	
<?php
    }
?>

<p><a href="registration.html" style="color: #000; text-decoration: none;">registration</a></p>
<p><a href="upload.php" style="color: #000; text-decoration: none;">upload</a></p>
</div>
</div>
</div>
</FONT> 
</body>
</html>
