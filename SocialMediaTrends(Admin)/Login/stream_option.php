<?php
session_start();
$people=$_POST['people'];
$area=$_POST['area'];
$topic=$_POST['topic'];
if($people!='')
{
header('Location:Construction/NotFound.html');
}
else
{
$_SESSION['topic'] = $topic;
header('Location: ../StreamApi/StreamTopic.php');
}
?>