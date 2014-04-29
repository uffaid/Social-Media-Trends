<?php include "TwitterOAuth.php";?>
<?php 
$consumer="5LgLocvl9vYiNpeB24JsOfpGR";
$consumer_secret="HRIcTtNMI25suKycnbPvGglrOqaWjB9fp55oQbrag3PQBnKQGZ";
$access_token="1848973213-lqBSXJHSCRXKCD7GfaZLOHTJluDGikadbwO8BOY";
$access_token_secret="08C2A98huqGGCyZ8zd6LqjZiMEcjjt95vtUTff47WEoOx";
$twitter=new TwitterOAuth($consumer,$consumer_secret,$access_token,$access_token_secret);
?>
<?php
session_start();
$present=false;
$execute=true;
$receive_data=true;
$con=mysql_connect("localhost","root","root");
mysql_select_db("dbtwitter",$con);
$screen_name=$_SESSION['people'];
$result = mysql_query("SELECT * FROM screenname_code_table");
while($row = mysql_fetch_array($result))
{
if($row['screen_name']==$screen_name)
{
$screen_name_id=$row['screen_id'];
$present=true;
break;
}
}
if($present==false)
{
$insert_screen="insert into screenname_code_table (screen_name) values('$screen_name')";
mysql_query($insert_screen);
$screen_name_id=mysql_insert_id();
}
$i=0;
$str='https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$_SESSION['people'].'&count=200';
while($i<5)
{
$tweets=$twitter->get($str);
foreach($tweets as $tweet){
          $id_str=$tweet->id_str;
			 $screen_name= $tweet->user->screen_name;
             $created_at=$tweet->created_at;
			 $text=$tweet->text;
             $friends_count=$tweet->user->friends_count;	 
			 $followers_count=$tweet->user->followers_count;
			 $statuses_count=$tweet->user->statuses_count;		 
			$sql="insert into people_rawdata(id_str,screen_name,created_at,text,followers_count,friends_count,screen_id) VALUES('$id_str','$screen_name','$created_at','$text',$followers_count,$friends_count,$screen_name_id)";			
			mysql_query($sql,$con);			
		}
$result1= mysql_query("select * from   people_rawdata where id_str=(SELECT MIN(id_str) FROM people_rawdata where screen_id='$screen_name_id')");
while($row = mysql_fetch_array($result1))
$max_id=$row['id_str'];
echo $max_id;
mysql_query("update screenname_code_table set max_id='$max_id' where screen_id='$screen_name_id'");
$result2= mysql_query("select * from   people_rawdata where id_str=(SELECT MAX(id_str) FROM people_rawdata where screen_id='$screen_name_id')");
while($row = mysql_fetch_array($result2))
$since_id=$row['id_str'];
mysql_query("update screenname_code_table set since_id='$since_id' where screen_id='$screen_name_id'");
$str='https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$_SESSION['people'].'&count=200&max_id='.$max_id;
$i++;
		}
mysql_query("update screenname_code_table  set From_date=(select created_at from people_rawdata where id_str='$max_id') where screen_id='$screen_name_id'");		
mysql_query("update screenname_code_table  set To_date=(select created_at from people_rawdata where id_str='$since_id') where screen_id='$screen_name_id'");
mysql_query("update screenname_code_table  set total_tweets=(select count(*) from people_rawdata where screen_id='$screen_name_id') where screen_id='$screen_name_id'");		
	echo "Data Added to people_rawdata";
?>
