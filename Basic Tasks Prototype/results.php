<?php 

	session_start(); 
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	function deepsearch($array, $key, $value)
	{
		for ($i = 0; $i < count($array); $i++) {
			$subarray = $array[$i];
    		if (isset($subarray[$key]) && $subarray[$key] == $value) {
    			return $i;
    		}
		}
	    return -1;
	}

	if(isset($_GET["qId"])) {
		$QuestionId = $_GET["qId"];
		$curUrl = "http://ggreiner.com/cs247/bp/results.php?qId=$QuestionId&share";
		$result = mysqli_query($con,"SELECT * FROM Questions WHERE QuestionId = $QuestionId");
		$question = mysqli_fetch_array($result);
		$open = $question["Open"];

		$GroupId = $question["GroupId"];
		$result = mysqli_query($con,"SELECT * FROM Groups WHERE GroupId = $GroupId");
		$group = mysqli_fetch_array($result);

		$CreatorId = $question["UserId"];
		$result = mysqli_fetch_array(mysqli_query($con,"SELECT Name FROM Users WHERE UserId = $CreatorId"));
		$creator = $result["Name"];

		$result = mysqli_query($con,"SELECT * FROM Options WHERE QuestionId = $QuestionId");
		$responses = array();
		while ($row = mysqli_fetch_array($result)) {
			$optionNum = $row["OptionNum"];

			if ($question["Type"] == 'YN') {
				$optionNum = $row["OptionText"];
			}

			$optionText = $row["OptionText"];
			$value = array();
			$responses[] = array('optionNum' => $optionNum, 'optionText' => $optionText, 'value' => $value);
		}

		$comments = array();
		$result = mysqli_query($con,"SELECT * FROM Members NATURAL JOIN (SELECT * FROM Responses WHERE QuestionId = $QuestionId AND Phone IN (SELECT Phone FROM Members WHERE GroupId = $GroupId)) AS Responses2 WHERE GroupId = '$GroupId'");

		while($row = mysqli_fetch_array($result)) {
			$response = $row["Response"];
			$member = $row["Name"];
			$comment = $response;

			if ($question["Type"] == 'YN') {
				if (preg_match('/(^[YyNn])\s*(.*)/',$response, $matches)) {
					$res = strtolower($matches[1]);
					$num = 'no';
					if ($res == "y") {
						$num = 'yes';
					}

					$index = deepsearch($responses,'optionNum', $num);

					$responses[$index]['value'][] = $member;
					$comment = $matches[2];
				}
			}
			if ($question["Type"] == 'TD') {
				if (preg_match('/(^\d[\d\s,]*)\s*(.*)/',$response, $matches)) {
					$digits = $matches[1];
					$digits = str_replace(' ', '', $digits);

					if (strpos($digits,',') !== false) {
						$nums = explode(',', $digits);
					} else {
						$nums = str_split($digits);
					}
					
					foreach ($nums as $num) {
						$index = deepsearch($responses,'optionNum', $num);
						if ($index >= 0) {
							$responses[$index]['value'][] = $member;
						}
					}
					
					$comment = $matches[2];
				}
			} else {
				if (preg_match('/(^\d+)\s*(.*)/',$response, $matches)) {
					$num = (int)$matches[1];
					$index = deepsearch($responses,'optionNum', $num);
					if ($index >= 0) {
						$responses[$index]['value'][] = $member;
					}
					$comment = $matches[2];
				}
			}

			if ($comment) {
				$comments[]= array('comment' => $comment, 'member' => $member);
			}
		}

		function cmp($a, $b) { return count($b["value"]) - count($a["value"]);};
		//function cmpOptions($a,$b) { return $a['optionText'] - $b['optionText'];};
		

		//if ($question["Type"] == 'TD') {
		//	usort($responses, "cmpOptions");
		//} else {
			usort($responses, "cmp");
		//}

		//echo "<h2> Your friends recommend ".$responses[0]['response']." (".$responses[0]['value']." votes) </h2>";

	}

?>

<html>	
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="resultsstyle.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
		<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>


	</head>
	<body>
	<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>

	<?php 
		$type = $question["Type"];

		if ($type != 'TC') {
			echo "<div class='firstline'><span class='asked'> $creator asked </span> <span class='groupname'>".$group["Name"]." </span></div> <div class='question'>".$question["Question"]."</div>";		
		} else {
			echo "<div class='firstline'><span class='asked'> $creator assigned </span> <span class='groupname'>".$group["Name"]." ".count($responses)." tasks: </span> </div>";
		}
	?>

	<svg class="chart"></svg>

	<div id='summary'></div>
	<div id='members'>How did each member vote?</div>
	<div id='membersresponse'></div>

	<script>

	rawdata = <?php echo json_encode($responses); ?>;
	//rawdata = [{'response': 'A', 'value': 5}, {'response': 'B', 'value': 0}, {'response': 'C', 'value': 1}, {'response': 'C', 'value': 6}, {'response': 'C', 'value': 0}];
	colors = ["#11F3E7","#B4E50D","#E6DF2C", "#FF7C44", "#FF4785"];

	var type =  <?php echo json_encode($type) ?>;

	if (type == 'TD') {
		$(".chart").after( "<table id='timetable'></table>" );
		$(".chart").remove();
	}


	data = [];
	options = [];

	dates = [];
	times = [];

	for (var i = 0; i < rawdata.length; i++) {
		data.push(rawdata[i].value.length);
		options.push(rawdata[i].optionText);

		if (type == 'TD') {
			var Regexp = /([^s]+) at ([^s]+)/g;
			var match = Regexp.exec(options[i]);
			
			var date = match[1];
			var time = match[2];

			var ind = dates.indexOf(date);
			if (ind == -1) {
				dates.push(date);
				times.push([time]);
			} else {
				times[ind].push(time);
			}
		}

		if (data[i] != 0 || type == 'TC') {
			$("#membersresponse").html($("#membersresponse").html() + "<div class='options' id='options"+ i +"'><span class='option'>"+options[i]+"</span><span class='mem'></span></div>");
			
			list = "";
			rawdata[i].value.forEach(function(entry) {
				list += entry + ", " ;
			});
			list = list.substring(0,list.length-2);
			$("#options" + i + " .mem").html(list);
			$("#options" + i + " .option").css('color', colors[i%5]);
			if (type == 'TD') {
				$("#options" + i + " .option").css('color', 'hsla(180, 100%, 45%, 1');
				$("#options" + i + " .option").css('font-size', '13pt');
				$("#options" + i + " .mem").css('font-size', '12pt');
				$("#options" + i + " .mem").css('display', 'block');

			}
		}
	}


	if (d3.max(data) == 0) {
		$("#members").css("display", "none");
	}


	if (type == 'TC') {
		$(".chart").remove();
		$("#members").css('display', 'none');
		$("#membersresponse").css('display', 'block');
	}




	
	if (type == 'MC') {

		var barupper = 30;
		var barlower = 15;
		var barheight = 50;
		var height = data.length * (barupper+barlower+barheight);

		var w = d3.scale.linear()
			.domain([0, d3.max(data)])
			.range(["0%", "100%"]);

		var chart = d3.select(".chart")
			.attr("width", '95%')
			.attr("height", height+20)
			.append("svg:g")
			.attr("transform", "translate(4,20)")

		chart.selectAll("rect")
		  .data(data)
		  .enter().append("svg:rect")
		  .attr("width", w)
		  .attr("height", barheight)
		  .attr("y",  function(d, i) { return height/data.length * i + barupper; })
		  .attr("fill", function(d, i) { return colors[i%5]; });

		chart.selectAll("text")
		    .data(data)
		    .enter().append("svg:text")
		    .attr("x", w)
		    .attr("y", function(d, i) { return height/data.length * i + barupper + (height/data.length-(barupper+barlower))/ 1.9; })
		    .attr("dx", -20) // padding-right
		    .attr("dy", ".1em") // vertical-align: middle
		    .attr("text-anchor", "end") // text-align: right
		    .text(String);

		var y2 = d3.scale.ordinal()
		  .domain(options)
		  .rangeBands([0, 200]);

		chart.selectAll("text.label")
		    .data(options)
		    .enter().append("svg:text")
		   	.attr("y", function(d, i) { return height/data.length * i + 21; })
		    .attr("dx", 20) // padding-right
		    .attr("dy", ".1em") // vertical-align: middle
		    .attr("class", "labels")
		    .text(String);

		chart.selectAll("line")
		    .data(w.ticks(d3.max(data)))
		    .enter().append("svg:line")
		    .attr("x1", w)
		    .attr("x2", w)
		    .attr("y1", 0)
			.attr("y2", height)
			.attr("stroke", "#ccc");

		chart.selectAll("text.rule")
		    .data(w.ticks(d3.max(data)))
		   	.enter().append("svg:text")
		    .attr("class", "rule")
		    .attr("x", w)
		    .attr("y", 0)
		    .attr("dy", -3)
		    .attr("text-anchor", "middle")
		    .text(String);

		chart.append("svg:line")
		     .attr("y1", 0)
		     .attr("y2", height)
		     .attr("stroke", "#000");

	    var percentage = 100.00 * data[0]/d3.sum(data);		
		$("#summary").html("<b>" + options[0] + "</b> was most voted with <b>" + data[0] + "</b> votes");
	}

	else if (type == 'YN') {
		if (d3.max(data) == 0) {
			$(".chart").css("display", "none");
	    	$("#summary").html("<b> No one has voted yet. </b>");
		} else {
			r = window.innerWidth/2.5;

			move = (0.89 * window.innerWidth)/2;


			var chart = d3.select(".chart")
				.data([data])
				.attr("width", '95%')
				.attr("height", 2*r)
				.append("svg:g")
					.attr("class", "piechart")
					.attr("transform", "translate(" + move + "," + r + ")");


			var arc = d3.svg.arc()        
	        	.outerRadius(r);
	 
	    	var pie = d3.layout.pie()          
	        	.value(function(d) { return d; });   
	 
		    var arcs = chart.selectAll("g.slice")
		        .data(pie)
		        .enter()                          
		            .append("svg:g")               
		                .attr("class", "slice");   
		 
		        arcs.append("svg:path")
		                .attr("fill", function(d, i) { return colors[i]; } )
		                .attr("d", arc);                                  
		 
		        arcs.append("svg:text")
		                .attr("transform", function(d) {
		                d.innerRadius = 0;
		                d.outerRadius = r;
		                return "translate(" + arc.centroid(d) + ")"; 
		            })
		            .attr("text-anchor", "middle")  
		            .text(function(d, i) {
		            	if (data[i] == 0) return '';
		            	return options[i] + "(" + data[i] + ")"; })
		            	.attr("class", "pielabel"); 

		    var percentage = 100.00 * data[0]/d3.sum(data);
		    $("#summary").html("<b>" + percentage.toFixed(0) + "%</b> of members voted <b>" + options[0] + "</b>");
		}
	}

	else if (type == 'TD') {
		var numrows = dates.length;
		var maxtimes = 0;
		for (var i=0; i < times.length; i++) {
			var entry = times[i];
			if (entry.length > maxtimes) {
				maxtimes = entry.length;
			}
		}
		var numcols = maxtimes + 1;

		for (var i=0; i < numrows; i++) {
			$("#timetable").append( "<tr id='row"+i+"'></tr>" );

			for (var j=0; j < numcols; j++) {
				text = "";
				color = "";
				if (j == 0) {
					text = dates[i];
				} else if (j > 0) {
					text = times[i][j-1];
					if (text === undefined) {
						text = "";
					} else {
						var optionText = $("#row" + i).find("#col0").text() + " at " + text;
						var ind = options.indexOf(optionText);

						var max = d3.max(data);
						if (max == 0) max = 1;
						
						var val = data[ind];
						var lum = 98 - 50*(val/max);
						
						var color = 'hsla(180, 100%, '+ lum + '%, 1)';

						text = text + " (" + val + ")";
					}
				}

				$('#row' + i).append( "<td id='col"+j+"'>"+text+"</td>" );
				if (color) {
					$("#row" + i).find("#col" + j).css('background-color', color);
					$("#row" + i).find("#col" + j).css('box-shadow', '2px 2px 2px #E0E0E0');

				}
			}
		}
		
		var max = d3.max(data);
		var ind = data.indexOf(max);

		$("#summary").html("<b>" + options[ind] + "</b><br/> was most preferred with <b>" + data[ind] + "</b> votes");

	}
	

    </script>
	<?php if ($open == 0 && !isset($_GET['share'])) { ?>
		<h3>Share Results</h3>
		<input id="share" class="textbox" type="text" value="<?php echo $curUrl ?>" onFocus="this.selectionStart=0; this.selectionEnd=this.value.length;" onTouchEnd="this.selectionStart=0; this.selectionEnd=this.value.length;" onMouseUp="return false"/>
	<?php } ?>

    <div class = "commentheader"> Comments </div>

	<?php
		if (count($comments) == 0) {
			echo "<div class='comment'>There are no comments yet. </div>";
		} else {
			foreach ($comments as $value) {
				echo "<div class='comment'><span class='member'>".$value['member']."</span>".$value['comment']."</div>";
			}
		}
	?>
	<?php if (!isset($_GET['share'])) { ?>
	<div class='buffer'/>
	<div class='group-home'><div class='home' onclick="location.href='grouphome.php?groupid=<?php echo $GroupId;?>';"><img class='navicon' src='images/home.png'/> GROUP HOME</div><div class='all' onclick="location.href='home.php';"><img class='navicon' src='images/group.png'/> ALL GROUPS </div> </div>
	<?php } ?>



	<script>
		$("#members").click(function() {
			$(this).fadeOut(function() {
				$("#membersresponse").fadeIn();
			});
		});
	</script>
	</body>
</html>
<?php mysqli_close($con); ?>