<html>
<head>
<script>
	function reqListener() {
		console.log(this.responseText);
	}
	
	var oReq = new XMLHttpRequest();
	oReq.onload = function() {
		var outputFromPHP = this.responseText;
		records = outputFromPHP.split("<br/>");
		var resultsP = document.getElementById("results");
		var index;
		for(index = 0; index < records.length, index++) {
			resultsP.innerHTML += records[index];
			resultsP.innerHTML += "<br/>";
		}
	};
	
	oReq.open("post", "selectdata.php", true);
	oReq.send();
</script>
</head>

<body>
<p id="results"></p>
</body>
</html>