<?php 
function filter_peoplewords($array1)
{
$stopwords="the,of,and,a,to,in,is,you,that,it,he,was,for,on,are,as,with,his,they,I,one,,@,at,be,this,have,from,or,one,had,by,word,but,not,what,all,were,we,when,your,can,said,there,use,an,each,which,she,do,how,their,!!,d,a,q,w,e,r,t,y,u,i,o,p,l,k,j,h,g,f,d,s,a,z,x,c,v,b,n,m,if,will,up,other,about,out,many,then,them,these,so,some,her,would,make,like,him,into,time,has,look,two,more,write,go,see,number,no,way,could,people,my,than,first,water,been,call,who,oil,its,now,find,long,down,day,did,get,come,made,may,part,in,should,at,for,rt,on,at,the,@secularlyYours:,all,were,show,are,or,which,more,today,think,people,my,nahi,by,gas,me,too,weak,bad,ye,ec,us,due,no,yes,that,13,11,12,14,15,16,17,18,19,20,want,25,3d,hv,ec,la,de60,win,rise,27,14,plz,m,sure,ka,art,today,an,had,no,now,,mrs,mr.,mrs.,up,ho,shud,talk,like,through,only,n,why?,n,...,ji,if,he,she,may,be,do,did,both,u,one.,pm.,me.,tak,frm,ha,son,...,pe,iac_,60,goa,sp,no,,ones,it?,mlas,here.,fdi,dr.,out.,10,end,nov,me.,ne,hum,man,dr,many,g+,take,live,1,2,3,4,5,6,7,8,9,0,why,pohi,will,-,was,have,after,it,our,day,that,you,as,good,day,happy,his,not,the,so,me,urghhhhhhh.#afridi,sit,this,am,over,and,lol,mla,ho,fm,ab,vs,rs.,ak,far,nor,no,due,yes.,boys,of,&amp;,with,is,a,to,i,:-),ls,#2014,has,be,sit,and,are,of,we,what,from,form,but,our that,rs.,rs?,un,rt.,yr,50,ya,red,na,yellow,sab,no.,us.,100,ki,,,run,tv,sc,fir,yr,u.,oh,it.,hit,wud,aaj,";
$stopwords=explode(',',$stopwords);
foreach($array1 as $pos=>$word){
if(!in_array(strtolower($word),$stopwords,TRUE)){
$filtered_array[$pos]=$word;
}}
return $filtered_array;
}


function frequency_peoplewords($array_clean){
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


function threshhold_peoplewords($array,$filter){
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
$query=("SELECT * FROM people_rawdata ");
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
   {
      $text[]=$row['text']; 
	  }  
       $string_words=implode(' ',$text);//Converts Text array into the String
	  $array_words=explode(' ',$string_words);//Converts String back into the array with each each element separated by space using delimiter space 
	 $array_clean=filter_peoplewords($array_words);//Calling function cleanKeywordsTopic to get clean data free of stop words
	 $raw_array=frequency_peoplewords($array_clean);//Calling function word_topicfrequency to get word frequency
	$pure_array=threshhold_peoplewords($raw_array,10);//Calling function freq_topicfilter to filter words less than 10
?>

<?php
$i=0;
$word_count_array=array();
foreach($pure_array as $key=>$value)
{
$word_count_array[$i]['text']=$key;
$word_count_array[$i]['size']=$value;
$i++;
}
//echo json_encode($array2);
?>
<script>	
	var frequency_list= <?php echo json_encode($word_count_array);?>;
	var color = d3.scale.linear()
            .domain([0,1,2,3,4,5,6,10,15,20,100])
            .range(["#ddd", "#ccc", "#bbb", "#aaa", "#999", "#888", "#777", "#666", "#555", "#444", "#333"]);
    d3.layout.cloud().size([700, 500])
      .words(frequency_list)
	  .rotate(0)
	  //.rotate(function() { return ~~(Math.random() * 2) * 25; })
      .fontSize(function(d) { return d.size; })
      .on("end", draw)
      .start();

  function draw(words) {
    d3.select("#index_peoplewordcloud").append("svg")
        .attr("width", 600)
        .attr("height", 300)
		.attr("class", "wordcloud")
      .append("g")
        .attr("transform", "translate(320,200)")
      .selectAll("text")
        .data(words)
      .enter().append("text")
        .style("font-size", function(d) { return d.size* (0.8)+ "px";})
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return color(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {
          return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });
  }
	
</script>