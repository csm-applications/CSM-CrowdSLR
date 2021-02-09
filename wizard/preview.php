<?php 

require_once '../classes/study.php';

session_start();
if(!isset($_SESSION['user']) && !isset($_SESSION['password'])){
	header("Location: config.php" );
}

if(isset($_POST['action']) && $_POST['action'] == "finish"){
	header("Location: links.php");
}

$tempTraining = file_get_contents("../data/training.json", true);
$trainingData = json_decode($tempTraining, true);


$tempTask = file_get_contents("../data/task.json", true);
$taskData = json_decode($tempTask, true);

?>


<html>

<title>Setup Wizard</title>
<?php include '../elements/head.php' ?>


<body class="container">
	<div>
		<h1 class="display-4" style="padding: 2em; text-align: center; background-color: fafafa;" >Wizard - Preview data</h1>
	</div>

	<div class="card display-4" style="padding:20px">Preview your data</div>

	<div style="margin-top:40px">
		<h3>Informations</h3>

		<div>To upload your data, make sure it is in the correct format.</div>

		<div id="accordion">
			<div class="card">
				<div class="card-header" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Click to see uploaded training data
						</button>
					</h5>
				</div>
				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">

						<table class="table table-stripped">
							<thead>
								<tr>
									<th>idAbstract</th>
									<th>title</th>
									<th>fullAbstract</th>
									<th>ic1</th>
									<th>ic2</th>
									<th>decision</th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0 ; $i < count($trainingData); $i++){ ?>
									<tr>
										<td><?= $trainingData[$i]["idAbstract"] ?></td>
										<td><?= $trainingData[$i]["title"] ?></td>
										<td><?= $trainingData[$i]["fullAbstract"] ?></td>
										<td><?= $trainingData[$i]["ic1"] ?></td>
										<td><?= $trainingData[$i]["ic2"] ?></td>
										<td><?= $trainingData[$i]["decision"] ?></td>
									</tr>

								<?php }?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="headingTwo">
					<h5 class="mb-0">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
							Click to see uploaded task data
						</button>
					</h5>
				</div>
				<div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
					<div class="card-body">
						<table class="table table-stripped">
							<thead>
								<tr>
									<th>idAbstract</th>
									<th>title</th>
									<th>fullAbstract</th>
									<th>Attention Test</th>
									<th>TaskCode</th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i = 0 ; $i < count($taskData); $i++){ ?>
									<tr>
										<td><?= $taskData[$i]["idAbstract"] ?></td>
										<td><?= $taskData[$i]["Title"] ?></td>
										<td><?= $taskData[$i]["fullAbstract"] ?></td>
										<td><?= $taskData[$i]["attentionTest"] ?></td>
										<td><?= $taskData[$i]["taskCode"] ?></td>
									</tr>
								<?php }?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>

		<div class="card" style="margin-top: 50px; padding:20px">
			<h2 >Finish setup</h2>

			<form method="POST">
				<input type="hidden" name="action" value="finish">
				<input type="submit" name="Submit Data" class="btn btn-primary">
			</form>
		</div>
	</div>
</body>
</html>