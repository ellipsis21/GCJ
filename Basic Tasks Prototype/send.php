<html>	
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
		<script language="javascript">
			function AddResOpt() {
				var list = document.getElementById("res");
				var elem = document.createElement("li");
				elem.innerHTML = "<input type='text' class='textbox' placeholder='Response Option' />";
				list.appendChild(elem);
			}
		</script>
	</head>
	<body>
<?php
	if (isset($_POST['entry1'])){
		$entry1 = $_POST['entry1'];
		if ($entry1 != "") echo "<h2>Get Your Friends Opinions</h2>\n<form><input type='button' class='subbut' value = '".$entry1."' onclick=\"location.href='?cat=".$entry1."'\"/></form>\n";
	}
	if (isset($_POST['entry2'])) {
		$entry2 = $_POST['entry2'];
		if ($entry2 != "") echo "<form><input type='button' class='subbut' value = '".$entry2."' onclick=\"location.href='?cat=".$entry2."'\"/></form>\n";
	}
	if (isset($_POST['entry3'])) {
		$entry3 = $_POST['entry3'];
		if ($entry3 != "") echo "<form><input type='button' class='subbut' value = '".$entry3."' onclick=\"location.href='?cat=".$entry3."'\"/></form>\n";
	}
	if (isset($_POST['entry4'])) {
		$entry4 = $_POST['entry4'];
		if ($entry4 != "") echo "<form><input type='button' class='subbut' value = '".$entry4."' onclick=\"location.href='?cat=".$entry4."'\"/></form>\n";
	}
	if (isset($_POST['entry5'])) {
		$entry5 = $_POST['entry5'];
		if ($entry5 != "") echo "<form><input type='button' class='subbut' value = '".$entry5."' onclick=\"location.href='?cat=".$entry5."'\"/></form>\n";
	}
	if (isset($_POST['entry6'])) {
		$entry6 = $_POST['entry6'];
		if ($entry6 != "") echo "<form><input type='button' class='subbut' value = '".$entry6."' onclick=\"location.href='?cat=".$entry6."'\"/></form>\n";
	}
	if (isset($_POST['entry7'])) {
		$entry7 = $_POST['entry7'];
		if ($entry7 != "") echo "<form><input type='button' class='subbut' value = '".$entry7."' onclick=\"location.href='?cat=".$entry7."'\"/></form>\n";
	}
	if (isset($_POST['entry8'])) {
		$entry8 = $_POST['entry8'];
		if ($entry8 != "") echo "<form><input type='button' class='subbut' value = '".$entry8."' onclick=\"location.href='?cat=".$entry8."'\"/></form>\n";
	}
	
	if(isset($_GET["cat"])) {
		$category = $_GET["cat"];
		echo "<h2>Get the $category' Opinions</h2>\n";
		echo "<ul>\n";
		echo "<li><input type='text' class='textbox' placeholder='Question' /></li>\n";
		echo "<ul id = 'res'>\n";
		echo "<li><input type='text' class='textbox' placeholder='Response Option' /></li>\n";
		echo "<li><input type='text' class='textbox' placeholder='Response Option' /></li>\n";
		echo "</ul><ul><li><input type='button' class='subbut' value = 'Add Option' onclick='AddResOpt()'/></li>\n";
		echo "</ul>\n";
		echo "</ul>\n";
		echo '<br><input type="file" accept="image/*" capture="camera" class="button">';
		echo '<br><input type="file" accept="video/*" capture="camera" class="button2">';
		echo "<br><form><input type='button' class='subbut' value = 'Submit' onclick=\"location.href='?cat=$category'\"/></form>\n";
	}
?>
	</body>
</html>