<?php 

require_once '../classes/study.php';

session_start();
if(!isset($_SESSION['user']) && !isset($_SESSION['password'])){
	header("Location: config.php" );
}

function parseCSVtoJson($csv){
	$column_name = array();
	$final_data = array();
	$data_array = array_map("str_getcsv", explode(PHP_EOL, $csv));
	$labels = array_shift($data_array);

	foreach($labels as $label){
		$column_name[] = $label;
	}

	$count = count($data_array) - 1;

	for($j = 0; $j <= $count; $j++){
		$data = array_combine($column_name, $data_array[$j]);
		$final_data[$j] = $data;
	}
	
	file_put_contents("../data/training.json",	str_replace("\ufeff","",json_encode($final_data)));
	Header("Location: wizard-step2.php");

}


if ( isset($_POST["action"])  && $_POST['action'] == "submitData") {
	if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) {
			echo "<div class='alert alert-danger'> Return Code: " . $_FILES["file"]["error"] . "</div>";

		}
		else {
                 //Print file details
			/*
			echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
			*/
                 //if file already exists
			if (file_exists("data/" . $_FILES["file"]["name"])) {
				echo $_FILES["file"]["name"] . " already exists. ";
			}
			else {
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
				if( isset ($_POST['typeOfInput']) && $_POST['typeOfInput'] == "CSV"){
					$storagename = "dataToAnnotate.csv";
					if(strpos($_FILES["file"]["name"],"json")){
						echo '<div class="alert alert-danger">Please, upload a CSV file</div>';
					}else{
						move_uploaded_file($_FILES["file"]["tmp_name"], "../data/" . $storagename);
						echo "<div class='alert alert-info'>Sucessfully stored: " . "../data/" . $_FILES["file"]["name"] . "</div>";
					parseCSVtoJson(file_get_contents("../data/". $storagename));

					}
				}else{

					$storagename = "training.json";
					move_uploaded_file($_FILES["file"]["tmp_name"], "../data/" . $storagename);
					Header("Location: wizard-step2.php");

				}
			}
		}
	} else {
		echo "No file selected <br />";
	}



}


?>


<html>

<title>Setup Wizard</title>
<?php include '../elements/head.php' ?>


<body class="container">
	<div>
		<h1 class="display-4" style="padding: 2em; text-align: center; background-color: fafafa;" >Welcome to our wizard setup</h1>
	</div>

	<div class="card display-4" style="padding:20px">Step 01 - Upload your training data</div>

	<div style="margin-top:40px">
		<h3>Informations</h3>

		<div>To upload your data, make sure it is in the correct format.</div>

		<div id="accordion">
			<div class="card">
				<div class="card-header" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Instructions for uploading JSON
						</button>
					</h5>
				</div>
				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						For JSON format enter an array of objects with the following format:
						<pre style="background-color: #efefef; padding: 20px; border-radius: 20px">
[
	{
		"idAbstract": 0,
		"title": "title of abstract 01",
		"fullAbstract":"Here comes the full abstract",
		"ic1":0,
		"ic2":0,
		"decision": "Excluded"
	},
	{
		"idAbstract": 1,
		"title": "Title of abstract 01",		
		"fullAbstract": "Here comes the full abstract",
		"ic1":0,
		"ic2":0,
		"decision": "Excluded"
	}

]

						</pre>

					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" id="headingTwo">
					<h5 class="mb-0">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
							Instructions for uploading CSV files
						</button>
					</h5>
				</div>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
					<div class="card-body">
						For CSV format, upload a file containing exactly the same colums:
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
								<tr>
									<td>0</td>
									<td>title of abstract 01</td>
									<td>Here comes the full abstract</td>
									<td>0</td>
									<td>0</td>
									<td>Excluded</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Title of abstract 01</td>
									<td>Here comes the full abstract</td>
									<td>0</td>
									<td>0</td>
									<td>Excluded</td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>

		<div class="card" style="margin-top: 50px; padding:20px">
			<h2 >Input your data</h2>

			<form enctype="multipart/form-data" method="POST">
				<div class="form-group"> 
					<input  type="radio" id="male" name="typeOfInput" value="JSON">
					<label for="male">JSON</label><br>
					<input  type="radio" id="female" name="typeOfInput" value="CSV">
					<label for="female">CSV</label>
					<input type="hidden" name="action" value="submitData" />
					<input class="form-control-file" type="file" name='file' placeholder="Select your Json or CSV data">
				</div>
				<input type="submit" name="Submit Data" class="btn btn-primary">
			</form>
		</div>
	</div>
</body>
</html>