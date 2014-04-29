<?php
session_start();
$people=$_POST['people'];
$area=$_POST['area'];
$topic=$_POST['topic'];
if($people!='')
{
$_SESSION['people'] = $people;
header('Location: ../RestApi/RestPeople.php');
}
else
{
$_SESSION['topic'] = $topic;
header('Location: ../RestApi/RestTopic.php');
}
?>