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

		$result = mysqli_query($con,"SELECT * FROM Questions WHERE QuestionId = $QuestionId");
		$question = mysqli_fetch_array($result);

		$GroupId = $question["GroupId"];
		$result = mysqli_query($con,"SELECT * FROM Groups WHERE GroupId = $GroupId");
		$group = mysqli_fetch_array($result);

		$result = mysqli_query($con,"SELECT * FROM Options WHERE QuestionId = $QuestionId");
		$responses = array();
		while ($row = mysqli_fetch_array($result)) {
			$optionNum = $row["OptionNum"];
			$optionText = $row["OptionText"];
			$value = array();
			$responses[] = array('optionNum' => $optionNum, 'optionText' => $optionText, 'value' => $value);
		}

		$comments = array();
		$result = mysqli_query($con,"SELECT * FROM Responses NATURAL JOIN Members WHERE QuestionId = $QuestionId");

		while($row = mysqli_fetch_array($result)) {
			$response = $row["Response"];
			$member = $row["Name"];
			$comment = $response;

			if ($question["Type"] == 'YN') {
				if (preg_match('/(^[YyNn])\s*(.*)/',$response, $matches)) {
					$res = strtolower($matches[1]);
					if ($res == 'y') {
						$num == 1;
					} else {
						$num == 2;
					}
					$index = deepsearch($responses,'optionNum', $num);
					$responses[$index]['value'][] = $member;
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
		usort($responses, "cmp");


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

	</head>
	<body>
	<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>

	<?php echo "<div class='firstline'><span class='asked'> You asked </span> <span class='groupname'>".$group["Name"]." </span></div> <div class='question'>".$question["Question"]."</div>" ?>


	<svg class="chart"></svg>
	<div class="pie"></div>

	<script>

	rawdata = <?php echo json_encode($responses); ?>	
	//rawdata = [{'response': 'A', 'value': 5}, {'response': 'B', 'value': 0}, {'response': 'C', 'value': 1}, {'response': 'C', 'value': 6}, {'response': 'C', 'value': 0}];
	colors = ["#11F3E7","#B4E50D","#E6DF2C", "#FF7C44", "#FF4785"];

	data = [];
	options = [];
	for (var i = 0; i < rawdata.length; i++) {
		data.push(rawdata[i].value.length);
		options.push(rawdata[i].optionText);
	}


	/* Bar Chart */

	var w = d3.scale.linear()
		.domain([0, d3.max(data)])
		.range(["0%", "100%"]);

	var y = d3.scale.ordinal()
	  .domain(data)
	  .rangeBands([0, 200]);

	var chart = d3.select(".chart")
		.attr("width", '95%')
		.attr("height", 350)
		.append("svg:g")
		.attr("transform", "translate(4,20)")

	chart.selectAll("rect")
	  .data(data)
	  .enter().append("svg:rect")
	  .attr("width", w)
	  .attr("height", 300/rawdata.length-40)
	  .attr("y",  function(d, i) { return 300/rawdata.length * i + 40; })
	  .attr("fill", function(d, i) { return colors[i%5]; });

	chart.selectAll("text")
	    .data(data)
	    .enter().append("svg:text")
	    .attr("x", w)
	    .attr("y", function(d, i) { return 300/rawdata.length * i + 40 + (300/rawdata.length-40)/ 1.9; })
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
	   	.attr("y", function(d, i) { return 300/rawdata.length * i + 30; })
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
		.attr("y2", 330)
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
	     .attr("y2", 330)
	     .attr("stroke", "#000");


	/* Pie Chart */

    </script>

    <div class = "commentheader"> Comments </div>

	<?php
		foreach ($comments as $value) {
			echo "<div class='comment'><span class='member'>".$value['member']."</span>".$value['comment']."</div>";
		}
	?>
	<div class='buffer'/>
	<a class='group-home' href='grouphome.php?groupid=".$groupid."'>Group Home</a>

	</body>
</html>