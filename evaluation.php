<?php
require_once 'classes/study.php';
if (isset($_GET['task'])) {
    $contents = file_get_contents("data/task.json", true);
    $pc = json_decode($contents, true);
    ?>

    <!DOCTYPE html>
    <html>
        <?php include 'elements/head.php' ?>

        <body  class="container">
            <div>
                <div class="jumbotron" style="background:white	; text-align: center" >
                    <h1 class="display-4">Classifying Scientific Abstracts</h1>
                    <p class="lead">Thanks for your participation!</p>
                </div>

                <div>
                    <div class="row">
                        <div style="background-color: #aef9a7" class="card col-md-4">
                            <span style="text-align: center; width: 100%" ><img style="padding: 5px" src="images/teacher.png" width="80"></span>
                            <p style="text-align: center; width: 100%" >Training</p>
                        </div>
                        <div style="background-color: #aef9a7" class="card col-md-4">
                            <span style="text-align: center; width: 100%"><img style="padding: 5px" src="images/document.png" width="80"></span>
                            <p   style="text-align: center; width: 100%">Task</p>
                        </div>
                        <div style="background-color: #aef9a7" class="card col-md-4">
                            <span style="text-align: center; width: 100%"><img style="padding: 5px" src="images/checkmark.png" width="80"></span>
                            <p  style="text-align: center; width: 100%">Finish</p>
                        </div>
                    </div>
                </div>

                <?php
                $answeredAll = true;
                $attention = false;
                $answers = array();
                if (isset($_POST)) {
                    foreach ($_POST as $key => $value) {
                        if ($value == "select") {
                            $answeredAll = false;
                        }
                    }
                }
                if ($pc[$_GET['task']]["attentionTest"] == $_POST["attention"]) {
                    $attention = true;
                }

                if ($answeredAll == false) {

                    echo("<h1>Sorry you didn't answer all questions</h1>");
                } else if (!$attention) {
                    echo("<h1 class='display-4'>Sorry you failed</h1>");

                    echo("<p class='lead'>You can close this page now.</h1>");
                } else {

                    foreach ($_POST as $key => $value) {

                        if ($value == "Enviar") {
                            break;
                        }

                        $answers[$key] = $value;
                    }

                    $s = new Study();
                    $s->studyId = $_GET['task'];
                    $testAnswers = array(
                                            "q0ic1" => $_POST['q0ic1'],
                                            "q0ic2" => $_POST['q0ic1'],
                                            "q0" => $_POST['q0'],
                                            "q1ic1" => $_POST['q1ic1'],
                                            "q1ic2" => $_POST['q1ic2'],
                                            "q1" => $_POST['q1'],
                                            "q2ic1" => $_POST['q2ic1'],
                                            "q2ic2" => $_POST['q2ic2'],
                                            "q2" => $_POST['q2'],
                                            "q3ic1" => $_POST['q3ic1'],
                                            "q3ic2" => $_POST['q3ic2'],
                                            "q3" => $_POST['q3'],
                                        );
                    $s->testAnswers = $testAnswers;
                    $s->testScore = $_POST['testScore'];
                    $s->ic1 = $_POST['q' . $_GET['task'] . 'ic1'];
                    $s->ic2 = $_POST['q' . $_GET['task'] . 'ic2'];
                    $s->decision = $_POST['q' . $_GET['task']];
                    $s->confidence = $_POST['confidence'];
                    $s->reasons = $_POST['reasons'];

                    if (file_exists("results/data/" . $_GET['task'] . ".json")) {

                        $contents = file_get_contents("results/data/" . $_GET['task'] . ".json", true);
                        $myfile = fopen("results/data/" . $_GET['task'] . ".json", "w");
                        $previousResults = json_decode($contents, true);

                        array_push($previousResults, $s);

                        fwrite($myfile, json_encode($previousResults));
                        fclose($myfile);
                    } else {
                        $myfile = fopen("results/data/" . $_GET['task'] . ".json", "w");
                        $a = array();
                        array_push($a, (array) $s);
                        fwrite($myfile, json_encode($a));
                        fclose($myfile);
                    }

                    echo "<div class='card alert-success' style='margin-top:20px; padding: 20px'>";
                    echo("<h5>Please copy the following code and paste it into the field provided within your clickworker task form.</h5>
					<p style='color:red'>Your clickworker fee can not be credited without the input of this code!</p> ");
                    echo("<h3>Your code: " . $pc[$_GET['task']]["taskCode"] . "</h3>");
                    echo "</div>";
                }
                ?>
            </div>


        </body>
    </html>

    <?php
} else {
    echo "<h1>Error: the page you are trying to access does not exist </h1>";
}
?>