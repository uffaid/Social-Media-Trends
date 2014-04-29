
/**
Method to fetch data for selected type of trends
**/
function fetchdata()
{
	var data=$("#trends_choice_form").serialize();
	$.ajax({
		type:"GET",
		url:"radioTrending.php?"+data,
		success:function(result){
			//alert(result);
			$("#avl_options").html(result);
		}
	});
}// end of function

function getPersonGraph()
{
	var data=$("#peopleForm").serialize();
	//alert(data);
	$.ajax({
		type:"GET",
		url:"tweets_by_person.php?"+data,
		success:function(result){
			//alert(result);
			$("#peopleGraphArea").html(result);
		}
	});
}// end of function


function getTopicGraph()
{
	var data=$("#trends_choice_form").serialize();
	$.ajax({
		type:"GET",
		url:"radioTrending.php?"+data,
		success:function(result){
			//alert(result);
			$("#avl_options").html(result);
		}
	});
}// end of function


function getTopicWordCloud()
{
	var data=$("#topicForm").serialize();
	$.ajax({
		type:"GET",
		url:"tweets_by_keyword.php?"+data,
		success:function(result){
			//alert(result);
			$("#topicGraphArea").html(result);
		}
	});
}

function indexWordCloud()
{
alert("hi");
}
