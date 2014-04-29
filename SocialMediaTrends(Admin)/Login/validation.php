<?php
$con = mysql_connect("localhost","root","root");
mysql_select_db("login_db", $con);
$result = mysql_query("SELECT * FROM login_table");
while($row = mysql_fetch_array($result))
   {
      if(($_POST['login']==$row['User_name'])&&($_POST['password']==$row['Password']))
	  {
	    header('Location: search.html');
	  }
   }
   echo "you have entered invalid username or password";
?>