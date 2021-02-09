<?php
$showTrainingAnswers = false;
$showTrainingScore = false;   

if(isset($_POST['showTrainingAnswers']) ){
    $showTrainingAnswers = $_POST['showTrainingAnswers'];    
}


if(isset($_POST['showTrainingScore'])){
    $showTrainingScore = $_POST['showTrainingScore'];    
} 


$toPrint = [];

if ($handle = opendir('./data')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            $taskContents = file_get_contents("data/". $entry, true);
            $tpc = json_decode($taskContents, true);
            array_push($toPrint,$tpc);

        }
    }

    closedir($handle);
}

$lines = ["studyId,testAnswers_q0ic1,testAnswers_q0ic2,testAnswers_q0,testAnswers_q1ic1,testAnswers_q1ic2,"
        . "testAnswers_q1,testAnswers_q2ic1,testAnswers_q2ic2,testAnswers_q2,testAnswers_q3ic1,testAnswers_q3ic2"
        . ",testAnswers_q3,testScore,ic1,ic2,decision,confidence,reasons". PHP_EOL];
$somar = 0;

for($i = 0 ; $i < count($toPrint); $i++){  

   for($j = 0 ; $j < count($toPrint[$i]); $j++){ 
    $line = $toPrint[$i][$j]["studyId"] . "," 
    . $toPrint[$i][$j]["testAnswers"]["q0ic1"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q0ic2"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q0"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q1ic1"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q1ic2"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q1"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q2ic1"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q2ic2"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q2"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q3ic1"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q3ic2"] . ","
    . $toPrint[$i][$j]["testAnswers"]["q3"] . ","
    . $toPrint[$i][$j]["testScore"] . ","
    . $toPrint[$i][$j]["ic1"] . ","
    . $toPrint[$i][$j]["ic2"] . ","
    . $toPrint[$i][$j]["decision"] . "," 
    . $toPrint[$i][$j]["confidence"] . ","
    . $toPrint[$i][$j]["reasons"] . PHP_EOL;
    $somar += strlen($line);
    array_push($lines, $line);
}
}


if(isset($_POST['download'])){
    if($_POST['download'] == "csv"){
         // Creates a new csv file and store it in tmp directory
      header("Content-type: text/csv");
      header("Content-Disposition: attachment; filename=results.csv");
      foreach ($lines as $line) {
        echo $line;
    }
    die();
}
}


?>


<!DOCTYPE html>


<html>

<?php include '../elements/head.php' ?>

<body class="<?php if(!$showTrainingAnswers){echo 'container';}?>">

    <div >
        <div class="jumbotron" style="background:white	; text-align: center" >
            <h1 class="display-4">CrowdSLR</h1>
            <p class="lead">Results Overview</p>
        </div>

        <div class="" style="background-color: #fafafa; padding: 20px">

            <p>Options</p>
            <form method="post">
                <input type="checkbox"  name="showTrainingAnswers" <?php if($showTrainingAnswers){echo 'checked';}?> onchange="this.form.submit()">
                <label for="showTrainingAnswers"> Show Training Answers</label>
                <br>
                <input type="checkbox" name="showTrainingScore" <?php if($showTrainingScore){echo 'checked';}?> onchange="this.form.submit()">
                <label for="showTrainingScore"> Show training score</label>
            </form>

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

        </div> 
        <div>
            <table class="table table-stripped table table-hover">
                <thead>
                  <tr>
                    <th>Classification</th>
                    <th>Id</th>
                    <?php if($showTrainingAnswers){ ?>
                        <th>q0ic1</th>
                        <th>q0ic2</th>
                        <th>q0</th>
                        <th>q1ic1</th>
                        <th>q1ic2</th>
                        <th>q1</th>
                        <th>q2ic1</th>
                        <th>q2ic2</th>
                        <th>q2</th>
                        <th>q3ic1</th>
                        <th>q3ic2</th>
                        <th>q3</th>
                    <?php } ?>
                    <?php if($showTrainingScore){ ?>
                        <th>testScore</th>

                    <?php } ?>
                    <th>ic1</th>
                    <th>ic2</th>
                    <th>decision</th>
                    <th>confidence</th>
                    <th>reasons</th>
                </tr>
            </thead>
            
            <tbody>
                <?php  for($i = 0 ; $i < count($toPrint); $i++){  ?>

                    <?php  for($j = 0 ; $j < count($toPrint[$i]); $j++){  ?>
                        <tr>
                            <td><?= $i?></td>
                            <td><?= $toPrint[$i][$j]['studyId']?></td>

                            <?php if($showTrainingAnswers){ ?>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q0ic1']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q0ic2']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q1']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q1ic1']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q1ic2']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q1']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q2ic1']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q2ic2']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q2']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q3ic1']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q3ic2']?></td>
                                <td><?= $toPrint[$i][$j]['testAnswers']['q3']?></td>

                            <?php } ?>
                            <?php if($showTrainingScore){ ?>
                                <td><?= $toPrint[$i][$j]['testScore']?></td>

                            <?php } ?>
                            <td><?= $toPrint[$i][$j]['ic1']?></td>
                            <td><?= $toPrint[$i][$j]['ic2']?></td>
                            <td><?= $toPrint[$i][$j]['decision']?></td>
                            <td><?= $toPrint[$i][$j]['confidence']?></td>
                            <td><?= $toPrint[$i][$j]['reasons']?></td>
                        </tr>

                    <?php } ?>

                <?php } ?>

            </tbody>

        </table>

    </div>


</div>
</body>
</html>

