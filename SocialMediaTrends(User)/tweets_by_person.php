<?php
$selected_person='';

function filterwords($array1){
$stopwords="the,of,and,a,to,in,is,you,that,it,he,was,for,on,are,as,with,his,they,I,one,,@,at,be,this,have,from,or,one,had,by,word,but,not,what,all,were,we,when,your,can,said,there,use,an,each,which,she,do,how,their,if,will,up,other,about,out,many,then,them,these,so,some,her,would,make,like,him,into,time,has,look,two,more,write,go,see,number,no,way,could,people,my,than,first,water,been,call,who,oil,its,now,find,long,down,day,did,get,come,made,may,part,in,should,at,for,rt,on,at,the,@secularlyYours:,all,were,show,are,or,which,more,today,think,people,my,nahi,by,gas,today,an,had,no,shud,talk,like,through,only,n,why?,n,...,ji,if,he,she,may,be,do,did,both,u,dr,many,g+,take,live,1,2,3,4,5,6,7,8,9,0,why,pohi,will,-,was,have,after,it,our,day,that,you,as,good,day,happy,his,not,the,so,me,urghhhhhhh.#afridi,sit,this,am,over,and,boys,of,&amp;,with,is,a,to,i,:-),ls,#2014,has,be,sit,and,are,of,we,what,from,form,but,our that,";

$stopwords=explode(',',$stopwords);
foreach($array1 as $pos=>$word){
if(!in_array(strtolower($word),$stopwords,TRUE)){
$filtered_array[$pos]=$word;
}
}
return $filtered_array;
}


function word_frequency($array_clean){
$freq_list=array();
foreach($array_clean as $pos=>$word){
$word=strtolower($word);
if(array_key_exists($word,$freq_list)){
++$freq_list[$word];
}
else{
$freq_list[$word]=1;
}
}
return $freq_list;
}


function freq_filter($array,$filter){
$filtered_array=array();
foreach($array as $key=>$value){
if($value>$filter){
$filtered_array[$key]=$value;
}
}
return $filtered_array;
}

$text_data=array();
$con = mysql_connect("localhost","root","");
mysql_select_db("dbtwitter", $con);
if(isset($_REQUEST['selected_person_id'])){
	$selected_person=$_REQUEST['selected_person_id'];
}
$query="SELECT * FROM people_rawdata where screen_id=".$selected_person;
//echo $query;
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
   {
      $text[]=$row['text']; 
	  }  
      $string1=implode(' ',$text);
	  $array1=explode(' ',$string1);
	 $array_clean=filterwords($array1);
	 $raw_array=word_frequency($array_clean);
	$pure_array=freq_filter($raw_array,40);
	// print_r ($raw_array);
	//print_r($pure_array);
?>

<?php
$i=0;
$array2=array();
foreach($pure_array as $key=>$value)
{
$array2[$i]['text']=$key;
$array2[$i]['size']=$value;
$i++;
}
//echo json_encode($array2);
?>
<div id="wordcloud_graph" style="position:absolute; top:40px; left:33%; width=49%; border:2px solid; border-radius:10px;"></div>
<script>	
	var frequency_list= <?php echo json_encode($array2);?>;
	var color = d3.scale.linear()
            .domain([0,1,2,3,4,5,6,10,15,20,100])
            .range(["#ddd", "#ccc", "#bbb", "#aaa", "#999", "#888", "#777", "#666", "#555", "#444", "#333"]);
    d3.layout.cloud().size([700, 300])
      .words(frequency_list)
	  .rotate(0)
	  //.rotate(function() { return ~~(Math.random() * 2) * 25; })
      .fontSize(function(d) { return d.size; })
      .on("end", draw)
      .start();

  function draw(words) {
    d3.select("#wordcloud_graph").append("svg")
        .attr("width", 700)
        .attr("height", 300)
		.attr("class", "wordcloud")
      .append("g")
        .attr("transform", "translate(320,200)")
      .selectAll("text")
        .data(words)
      .enter().append("text")
        .style("font-size", function(d) { return d.size*1 + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return color(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {
          return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });
  }
	
</script>