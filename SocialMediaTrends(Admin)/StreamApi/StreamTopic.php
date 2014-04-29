<?php
require_once('Phirehose.php');
require_once('OauthPhirehose.php');

/**
 * Example of using Phirehose to display a live filtered stream using track words
 */
 function remove_time($time)
{
$array_time=array();
$array_time=explode(' ',$time);
$time_removed=$array_time[0].' '.$array_time[1].' '.$array_time[2].' '.$array_time[5];
echo $time_removed;
return $time_removed;
}
class FilterTrackConsumer extends OauthPhirehose
{
  /**
   * Enqueue each status
   *
   * @param string $status
   */
  public function enqueueStatus($status)
  {
    /*
     * In this simple example, we will just display to STDOUT rather than enqueue.
     * NOTE: You should NOT be processing tweets at this point in a real application, instead they should be being
     *       enqueued and processed asyncronously from the collection process.
     */
	 $topic_name=$_SESSION['topic'];
	$con=mysql_connect("localhost","root","root");
   mysql_select_db("dbtwitter",$con);
   $result1 = mysql_query("SELECT topic_id FROM topicname_code_table where topic_name='$topic_name'");
   while($row = mysql_fetch_array($result1))
   $topic_id=$row['topic_id'];
    $data = json_decode($status, true);
	print_r($data);
    if (is_array($data) && isset($data['user']['screen_name'])) {
$id_str=$data['id_str'];		 
$name=$data['user']['name'];
$screen_name= $data['user']['screen_name'];
$user_location=$data['user']['location'];
$retweet_count=$data['retweet_count'];
$favorite_count=$data['favorite_count'];
$created_at=$data['created_at'];
$Date_noTime=remove_time($created_at);
$text=$data['text'];
$desc=$data['user']['description'];
$friends_count=$data['user']['friends_count'];
echo $topic_id;
$sql="insert into twitterrawdata (id_str,name,screen_name,location,retweet_count,favorite_count,created_at,Date_noTime,textdata,description,friends_count,topic_id) VALUES('$id_str','$name','$screen_name','$user_location',$retweet_count,$favorite_count,'$created_at','$Date_noTime','$text','$desc',$friends_count,$topic_id)";
 mysql_query($sql,$con);
$result1= mysql_query("select * from   twitterrawdata where id_str=(SELECT MIN(id_str) FROM twitterrawdata where topic_id='$topic_id')");
while($row = mysql_fetch_array($result1))
$max_id=$row['id_str'];
mysql_query("update topicname_code_table set max_id='$max_id' where topic_id='$topic_id'");
$result2= mysql_query("select * from   twitterrawdata where id_str=(SELECT MAX(id_str) FROM twitterrawdata where topic_id='$topic_id')");
while($row = mysql_fetch_array($result2))
$since_id=$row['id_str'];
mysql_query("update topicname_code_table set since_id='$since_id' where topic_id='$topic_id'");
//mysql_query("update topicname_code_table set From_date=(select created_at from twitterrawdata where id_str='$max_id'),To_date=(select created_at from twitterrawdata where id_str='$since_id'),Total_Tweets=(select count(*) from twitterrawdata where topic_id='$topic_id') where topic_id='$topic_id'");
}
mysql_query("update topicname_code_table set From_date=(select created_at from twitterrawdata where id_str='$max_id') where topic_id='$topic_id'");		
mysql_query("update topicname_code_table set To_date=(select created_at from twitterrawdata where id_str='$since_id') where topic_id='$topic_id'");
mysql_query("update topicname_code_table set total_tweets=(select count(*) from twitterrawdata where topic_id='$topic_id') where topic_id='$topic_id'");
}
}
// The OAuth credentials you received when registering your app at Twitter
define("TWITTER_CONSUMER_KEY", "5LgLocvl9vYiNpeB24JsOfpGR");
define("TWITTER_CONSUMER_SECRET", "HRIcTtNMI25suKycnbPvGglrOqaWjB9fp55oQbrag3PQBnKQGZ");


// The OAuth data for the twitter account
define("OAUTH_TOKEN", "1848973213-lqBSXJHSCRXKCD7GfaZLOHTJluDGikadbwO8BOY");
define("OAUTH_SECRET", "08C2A98huqGGCyZ8zd6LqjZiMEcjjt95vtUTff47WEoOx");

// Start streaming
 session_start();
$topic_name=$_SESSION['topic'];
$present=false;
$con=mysql_connect("localhost","root","root");
mysql_select_db("dbtwitter",$con);
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
$sc=new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setTrack(array('#'.$topic_name,$topic_name));
$sc->consume();
?>