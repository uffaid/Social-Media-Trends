<?php?>
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2 col-md-2 sidebar">
		<!--<form name="radioform" method="post" action="radioTrending.php">-->
		<form name="radioform" id="trends_choice_form" method="post">
		<div class="text-danger">
  	  <div class="navbar-header"><b>TRENDING</font></b></div><br><br>  
	  </div>	
           <p><input type="radio" name="view_choice" value="r1" onclick="fetchdata()"> People</p>
		   <p><input type="radio" name="view_choice" value="r2" onclick="fetchdata()"> Keyword</p>
		   </form>
		  <hr>
		</div>
        <div class="text-danger">
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div id="avl_options"></div>
		  </div>
		  </div>		  
        </div>
		<center> <div class="navbar navbar-inverse navbar-fixed-bottom">
     <font color="#FFFFF"> All Rights Reserved <a href="http://fieldsofview.in"></font> &copy; Fields Of View</a>
	 </div>
	 </center>
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
	
	
	  
	  <?php ?>