<?php 

session_start(); 
$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>

<html>	
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="stylesheets/resultsstyle.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
		<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>

	</head>
	<body>
	<?php
		if(isset($_GET["qId"])) {
			$questionID = $_GET["qId"]; //14

			$result = mysqli_query($con,"SELECT * FROM UQuestions WHERE PID = $questionID");
			$question = mysqli_fetch_array($result);

			$responses = array();
			if ($question["Response1"] != null) {
				$responses[] = array('response' => $question["Response1"], 'value' => 0);
			}
			if ($question["Response2"] != null) {
				$responses[] = array('response' => $question["Response2"], 'value' => 0);
			}
			if ($question["Response3"] != null) {
				$responses[] = array('response' => $question["Response3"], 'value' => 0);
			}
			if ($question["Response4"] != null) {
				$responses[] = array('response' => $question["Response4"], 'value' => 0);
			}
			if ($question["Response5"] != null) {
				$responses[] = array('response' => $question["Response5"], 'value' => 0);
			}
			if ($question["Response6"] != null) {
				$responses[] = array('response' => $question["Response6"], 'value' => 0);
			}

			$count = array(0, count($responses), 0);
			$comments = array();

			$result = mysqli_query($con,"SELECT * FROM Responses WHERE QuestionId = $questionID");
			while($row = mysqli_fetch_array($result)) {
				$response = $row["Response"];
				$friendId = $row["FriendId"];
				$friendresult = mysqli_query($con,"SELECT * FROM Friends WHERE UserId = $friendId");
				$friend = mysqli_fetch_array($friendresult);
				$friendName = $friend["FirstName"] + " " + $friend["LastName"];

				$comment = $response;
				if (preg_match('/(^\d+)\s*(.*)/',$response, $matches)) {
					$num = (int)$matches[1]-1;
					if ($num < count($responses)) {
						$responses[$num]['value']++;
					}
					$comment = $matches[2];
				}

				if ($comment) {
					$comments[]= array('comment' => $comment, 'friend' => $friendName);
				}
			}

			function cmp($a, $b) { return $b["value"] - $a["value"]; };
			usort($responses, "cmp");

			echo "<h2> Results for: ".$question["Question"]."</h2>";

			//echo "<h2> Your friends recommend ".$responses[0]['response']." (".$responses[0]['value']." votes) </h2>";

		}
	?>

	<svg class="chart"></svg>
	<div class="pie"></div>

	<script>
	rawdata = <?php echo json_encode($responses); ?>	
	//rawdata = [{'response': 'A', 'value': 5}, {'response': 'B', 'value': 0}, {'response': 'C', 'value': 1}, {'response': 'C', 'value': 6}, {'response': 'C', 'value': 0}];
	colors = ["#11F3E7","#B4E50D","#E6DF2C", "#FF7C44", "#FF4785"];

	data = [];
	options = [];
	for (var i = 0; i < rawdata.length; i++) {
		data.push(rawdata[i].value);
		options.push(rawdata[i].response);
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
		.attr("height", 220)
		.append("svg:g")
		.attr("transform", "translate(3,20)")

	chart.selectAll("rect")
	  .data(data)
	  .enter().append("svg:rect")
	  .attr("width", w)
	  .attr("height", 200/rawdata.length-10)
	  .attr("y",  function(d, i) { return 200/rawdata.length * i; })
	  .attr("fill", function(d, i) { return colors[i]; });

	chart.selectAll("text")
	    .data(data)
	    .enter().append("svg:text")
	    .attr("x", w)
	    .attr("y", function(d, i) { return 200/rawdata.length * i + 200/rawdata.length / 2; })
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
	   	.attr("y", function(d, i) { return 200/rawdata.length * i + 200/rawdata.length / 2; })
	    .attr("dx", 20) // padding-right
	    .attr("dy", ".1em") // vertical-align: middle
	    .text(String);

	chart.selectAll("line")
	    .data(w.ticks(d3.max(data)))
	    .enter().append("svg:line")
	    .attr("x1", w)
	    .attr("x2", w)
	    .attr("y1", 0)
		.attr("y2", 190)
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
	     .attr("y2", 190)
	     .attr("stroke", "#000");


	/* Pie Chart */

    </script>

    <div class = "commentheader"> Comments </div>

	<?php
		foreach ($comments as $value) {
			echo "<div class='comment'>".$value['comment']."<span class='friend'>".$value['friend']."</span></div>";
		}
	?>


	</body>
</html>