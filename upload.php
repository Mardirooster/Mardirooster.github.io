<?php
    // Start session
    session_start();

    //Check whether the session variable SESS_MEMBER_ID is present or not
    if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
        header("location: login.html");
        exit();
    }
?>
<html>
	<body>

	<form action="upload.php" method="post" enctype="multipart/form-data">
		<table width="510" border="0" align="center">
            <tr>
                <td colspan="2">Upload Form</td>
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
                <td>Tags:</td>
                <td><input type="text" name="tag"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>

	</form>

	</body>
</html> 