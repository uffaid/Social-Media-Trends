<?php include "TwitterOAuth.php";?>
<?php 
$consumer="S5bxJrvQ3R1bdFAwHFWLFw";
$consumer_secret="Xt8aipnscX06dufTin0d1YK9tLk7bBRnrZhnC59oY";
$access_token="1848973213-YmbyrF69BAJ3zEzlwIXYxe42UU8IfFXmH8MCtsQ";
$access_token_secret="ZNUZBvZauGDn4jMkYJjcMJeKx7nz7JL37t3Rf658WHwxn";
$twitter=new TwitterOAuth($consumer,$consumer_secret,$access_token,$access_token_secret);
?>
<?php
 
session_start();
$present=false;
$execute=true;function remove_time($time)
{
$array_time=array();
$array_time='';
$array_removed='';
$array_time=explode(' ',$time);
$time_removed=$array_time[0].' '.$array_time[1].' '.$array_time[2].' '.$array_time[5];
//echo $time_removed;
return $time_removed;
} 
$receive_data=true;
$con=mysql_connect("localhost","root","root");
mysql_select_db("dbtwitter",$con);
$topic_name=$_SESSION['topic'];
$result = mysql_query("SELECT * FROM topicname_code_table");
while($row = mysql_fetch_array($result))
{
if($row['topic_name']==$topic_name)
{
$topic_id=$row['topic_id'];
$present=true;
break;
}
}
if($present==false)
{
$insert_topic="insert into topicname_code_table (topic_name) values('$topic_name')";
mysql_query($insert_topic);
$topic_id=mysql_insert_id();
}
$i=0;
$str='https://api.twitter.com/1.1/search/tweets.json?q=%23'.$_SESSION['topic'].'&count=100';
while($i<5)
{
echo $str;
$tweets=$twitter->get($str);
//print_r($tweets);
foreach($tweets as $tweet){
		foreach($tweet as $t){
	         $id_str=$t->id_str;		 
			$name=$t->user->name;
			 $screen_name= $t->user->screen_name;
	         $user_location=$t->user->location;
			 $retweet_count=$t->retweet_count;
			 $favorite_count=$t->favorite_count;
             $created_at=$t->created_at;
			 $Date_noTime=remove_time($created_at);
			 echo $Date_noTime;
			 $text=$t->text;
			 $desc=$t->user->description;
             $friends_count=$t->user->friends_count;
			$sql="insert into twitterrawdata (id_str,name,screen_name,location,retweet_count,favorite_count,created_at,Date_noTime,textdata,description,friends_count,topic_id) VALUES('$id_str','$name','$screen_name','$user_location',$retweet_count,$favorite_count,'$created_at','$Date_noTime','$text','$desc',$friends_count,$topic_id)";
			 mysql_query($sql,$con);
			 }
			 }
		$result1= mysql_query("select * from   twitterrawdata where id_str=(SELECT MIN(id_str) FROM twitterrawdata where topic_id='$topic_id')");
while($row = mysql_fetch_array($result1))
$max_id=$row['id_str'];
mysql_query("update topicname_code_table set max_id='$max_id' where topic_id='$topic_id'");
$result2= mysql_query("select * from   twitterrawdata where id_str=(SELECT MAX(id_str) FROM twitterrawdata where topic_id='$topic_id')");
while($row = mysql_fetch_array($result2))
$since_id=$row['id_str'];
mysql_query("update topicname_code_table set since_id='$since_id' where topic_id='$topic_id'");
$str='https://api.twitter.com/1.1/search/tweets.json?q=%23'.$_SESSION['topic'].'&count=100&max_id='.$max_id;
$i++;
}
echo $max_id;
mysql_query("update topicname_code_table set From_date=(select created_at from twitterrawdata where id_str='$max_id') where topic_id='$topic_id'");		
mysql_query("update topicname_code_table set To_date=(select created_at from twitterrawdata where id_str='$since_id') where topic_id='$topic_id'");
mysql_query("update topicname_code_table set total_tweets=(select count(*) from twitterrawdata where topic_id='$topic_id') where topic_id='$topic_id'");
echo "Data Added to people_rawdata";
?>
