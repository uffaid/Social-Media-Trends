<?php?>

    <link rel="shortcut icon" href="http://getbootstrap.com/assets/ico/favicon.ico">

    <title>Social Media Trends</title>
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">
    <style type="text/css"></style><style id="holderjs-style" type="text/css"></style>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php"><font color="#FFFFF">SOCIAL MEDIA TRENDS</font></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav left">
             <li><a href="visualise.php">Trends</a></li>
              <li><a href="aboutUs.html">About Us</a></li>
              <li><a href="contactUs.html">Contact Us</a></li>
          </ul>
        </div>
		</div>
    </div>
		
	
    <script src="http://d3js.org/d3.v3.min.js"></script>
	<script src="./script/d3.layout.cloud.js"></script>
	<script src='./script/javascript.js'></script>
	<script src="./script/jquery.min.js"></script>
    <script src="./script/bootstrap.min.js"></script>
	<script src="./script/highcharts.js"></script>
	<script src="./script/js/highcharts.js"></script>
    <script src="./script/js/modules/exporting.js"></script>
		<center><div class="navbar navbar-inverse navbar-fixed-bottom">
      <font color="#FFFFF"> All Rights Reserved <a href="http://fieldsofview.in"></font> &copy; Fields Of View</a></p></div></center>
		</div>
      </div>

 <?php?>
 
 <!--php code for aggregated word cloud for people-->
 
 <div class="container-fluid">		
        <div class="col-md-10 col-md-offset-2 col sm-10 col-sm-offset-2 main">	
	  <?php
	  $con = mysql_connect("localhost","root","");
     mysql_select_db("dbtwitter", $con);
     $resultTopic=mysql_query("select count(*) as totalTopicTweets from twitterrawdata");
	$resultPeople=mysql_query("select count(*) as totalPeopleTweets from people_rawdata");
	while($row=mysql_fetch_array($resultTopic))
	{
	$totalTopic=$row['totalTopicTweets'];
	}
	while($row=mysql_fetch_array($resultPeople))
	{
	$totalPeople=$row['totalPeopleTweets'];
	}
	$total=($totalPeople + $totalTopic);
	?>
	
	  </div>
 <div class='row-fluid'>
	<table class="table table-striped" style="width:30%; font-family:Times New Roman; margin-top:2px; margin-left:470px; border:2px solid;" >
	<tbody>
		<tr>
			<td>
				Total tweets collected <td><?php echo($total)?>
				</td>
			</tr>
		<tr>
			<td>
				By Keyword  <td><?php echo($totalTopic)?>
			</td>
		</tr>
		<tr>
			<td>
				By People  <td> <?php echo($totalPeople)?>
			</td>
		</tr>
	</tbody>
</table>
	  </div>
	  </div>
	  
	   <div id="index_peoplewordcloud" style="position:absolute; top:270px; left:2%; width=45%; border:2px solid;"></div>
	  <div id="index_topicwordcloud" style="position:absolute; top:270px;right:2%; width=45%; border:2px solid;"></div>
	  
 <?php
 include "peoplewordcloud.php";?>
 <?php
 include "topicwordcloud.php"; ?>
<?php?>