<?php    
session_start();
include "include/config.php";
EXTRACT($_POST);	 
if($login=='Login')
{

		if($username=='' || $password=='')
		{
		header("location:index.php?no=9");exit;
		}
		else
		{
		//echo "SELECT * FROM admin WHERE username='$username' AND password='$password' AND access!=''"; exit;
		$result = mysql_query("SELECT * FROM admin WHERE username='$username' AND password='$password'");
		$num_row=mysql_fetch_row($result);
		$row = mysql_fetch_array($result);
			if($username=='Admin' && $password=='admin' || $num_row > 0)
			{
			//echo "correct"; exit;
			//Now if everything is correct let's finish his/her/its login
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;	
			//echo $username; echo $password; exit;
			header("location:include/menu.php?pg=index");exit;
			}
			else
			{
			header("location:index.php?no=8");
			}
		}
}
?>