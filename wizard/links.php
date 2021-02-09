<?php 

require_once '../classes/study.php';

session_start();
if(!isset($_SESSION['user']) && !isset($_SESSION['password'])){
	header("Location: config.php" );
}

if(isset($_POST['action']) && $_POST['action'] == "finish"){
	header("Location: links.php");
}

$tmp = file_get_contents("../configs.json");
$host = json_decode($tmp, true);


$tempTraining = file_get_contents("../data/training.json", true);
$trainingData = json_decode($tempTraining, true);


$tempTask = file_get_contents("../data/task.json", true);
$taskData = json_decode($tempTask, true);


$userDownload = [];
for($i = 0 ; $i < count($taskData) ; $i++){
	$line = "";
	$line = $line . $host["host"] . "?t=". $i . ",";
	$line = $line .  $taskData[$i]["taskCode"] . "\n";
	array_push($userDownload, $line);
}

$somar = 0;
for($s = 0; $s < count($userDownload); $s++){
	$somar += strlen($userDownload[$s]) ;
}

var_dump($somar);
if(isset($_POST['download'])){
	if($_POST['download'] == "csv"){
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=CrowdSLR.csv");
		header('Content-Length: ' . $somar);
		foreach ($userDownload as $line) {
			echo $line;
		}

	}
}

if(isset($_POST['action']) && $_POST['action'] = "finish"){
	header("Location: index.php");
}

?>


<html>

<title>Setup Wizard</title>
<?php include '../elements/head.php' ?>


<body class="container">
	<div>
		<h1 class="display-4" style="padding: 2em; text-align: center; background-color: fafafa;" >Wizard - Links</h1>
	</div>

	<div class="card display-4" style="padding:20px">Preview your data</div>

	<div style="margin-top:40px">
		<h3>Informations</h3>

		<div>Now that we've set up everything, you can now submit the links to the crowdsource platform</div>

		<div  style="background-color: #fafafa">
			<div class="row" style="padding:20px">
				<div class="col-md-8"></div>
				<div class="col-md-4">
					<form method="post">
						<select name="download" class="form-control" onchange="this.form.submit()">
							<option value="default">Export options</option>
							<option value="csv">Download in CSV</option>
						</select>
					</form>
				</div>

			</div>
		</div>



		<div class="card" style="padding:20px">
			<?php
			for ($i = 0 ; $i < count($taskData); $i++){
				echo '<div class="card" style="margin:5px">';
				echo "<div class='row' style='padding:10px;margin:5px'>"; 
				echo '<div class="col-md-10">';
				echo '<div style="font-weight:bold">' . $taskData[$i]["Title"].  '</div>';
				echo '<div><a href="' . $host["host"] . "?t=". $i . '">'. $host["host"] . "?t=". $i . ' </a></div>';
				echo '<div> Task code: ' . $taskData[$i]["taskCode"]. '</div>';
				
				echo '</div>';
				echo '</div>';
				echo '</div>'; 
			}
			?>

		</div>

		<div class="card" style="margin-top: 50px; padding:20px">
			<h2 >Finish setup</h2>

			<form method="POST">
				<input type="hidden" name="action" value="finish">
				<input type="submit" value="Submit" name="Submit Data" class="btn btn-primary">
			</form>
		</div>
	</div>
</body>
</html>