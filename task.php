<?php
if (isset($_GET['task'])) {
    $taskContents = file_get_contents("data/task.json", true);
    $tpc = json_decode($taskContents, true);

    $tpc = $tpc['abstracts'];
    $score = 0;
    ?>

    <!DOCTYPE html>
    <html>
        <?php include 'elements/head.php' ?>
        <body class="container" >
            <div >




                <div class="jumbotron" style="background:white	; text-align: center" >
                    <h1 class="display-4">Classifying Scientific Abstracts</h1>
                    <p class="lead">It's time to show your skills</p>
                </div>

                <div>
                    <div class="row">
                        <div style="background-color: #aef9a7" class="card col-md-4">
                            <span style="text-align: center; width: 100%" ><img style="padding: 5px" src="images/teacher.png" width="80"></span>
                            <p style="text-align: center; width: 100%" >Training</p>
                        </div>
                        <div style="background-color: #efefef" class="card col-md-4">
                            <span style="text-align: center; width: 100%"><img style="padding: 5px" src="images/document.png" width="80"></span>
                            <p   style="text-align: center; width: 100%">Task</p>
                        </div>
                        <div class="card col-md-4">
                            <span style="text-align: center; width: 100%"><img style="padding: 5px" src="images/checkmark.png" width="80"></span>
                            <p  style="text-align: center; width: 100%">Finish</p>
                        </div>
                    </div>
                </div>
                <?php
                $answeredAll = true;
                if (isset($_POST)) {
                    foreach ($_POST as $key => $value) {
                        if ($value == "select") {
                            $answeredAll = false;
                        }
                    }
                }

                if ($answeredAll == false) {
                    echo("<h1 class='display-4'>Sorry you didn't answer all questions.</h1>");
                    echo("<h4>Go back and try again</h4>");
                    echo("<button onclick='goBack()' class='btn btn-primary'>Go Back</button> 
                        <script>
                            function goBack() {
                            window.history.back();
                            } 
                        </script>");
                } else {
                    $points = 0;
                    $contents = file_get_contents("data/training.json", true);
                    $pc = json_decode($contents, true);

                    for ($i = 0; $i < 4; $i++) {


                        if ($pc[$i]["decision"] == $_POST['q' . $i]) {
                            $points++;
                        }
                    }


                    $maxPoints = count($pc);

                    $score = $points / $maxPoints;
                    echo "<div class='alert-danger' style='margin:20px;padding:10px'>";

                    echo "<div>Here is the result of your test:</div>";
                    echo ("<h1 class='display-4'>Your score is: " . $score * 100 . "% </h1>");
                    echo "</div>";
                }
                ?>
            </div>

            <?php if ($answeredAll) { ?>
                <div class="container">

                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Click here to see (remember) the instructions
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" aria-expanded="false" data-parent="#accordion">
                                <div class="card-body">
                                    <?php include 'elements/instructions.php' ?>   
                                </div>
                            </div>

                        </div>

                        <div class="jumbotron" style="background:white	; text-align: center" >

                            <h1 class="display-4">Let's start the task execution!</h1>
                            <p class="lead">Now that your test score was calculated, you will perform the task.</p> 
                            <p class="lead"><b>Be very careful, your results are very important to us!</b></p>
                        </div>


                        <form action="evaluation.php?task=<?= $_GET['task'] ?>" method="POST">

                            <br><hr><br>
                            <input type="hidden" name="q0ic1" value="<?= $_POST['q0ic1'] ?>"/>
                            <input type="hidden" name="q0ic2" value="<?= $_POST['q0ic2'] ?>"/>
                            <input type="hidden" name="q0" value="<?= $_POST['q0'] ?>"/>

                            <input type="hidden" name="q1ic1" value="<?= $_POST['q1ic1'] ?>"/>
                            <input type="hidden" name="q1ic2" value="<?= $_POST['q1ic2'] ?>"/>
                            <input type="hidden" name="q1" value="<?= $_POST['q1'] ?>"/>

                            <input type="hidden" name="q2ic1" value="<?= $_POST['q2ic1'] ?>"/>
                            <input type="hidden" name="q2ic2" value="<?= $_POST['q2ic2'] ?>"/>
                            <input type="hidden" name="q2" value="<?= $_POST['q2'] ?>"/>

                            <input type="hidden" name="q3ic1" value="<?= $_POST['q3ic1'] ?>"/>
                            <input type="hidden" name="q3ic2" value="<?= $_POST['q3ic2'] ?>"/>
                            <input type="hidden" name="q3" value="<?= $_POST['q3'] ?>"/>

                            <input type="hidden" name="testScore" value="<?= $score ?>">
                            <div class="card " style="margin-top:20px;padding: 20px">
                                <h3><b><?= $tpc[$_GET['task']]['Title'] ?></b></h3>
                                <p>Abstract: <?= $tpc[$_GET['task']]['fullAbstract'] ?></p>

                                <br><br>
                                <p>IC1 - Does the article focus on aligning Software Engineering education with industrial needs?</p>
                                <select class="form-control" name="q<?= $tpc[$_GET['task']]['idAbstract'] ?>ic1">
                                    <option value="select">Select an option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                                <br>

                                <p>IC2 - Is the article based on empirical data and not just the opinion of the authors?</p>
                                <select class="form-control" name="q<?= $tpc[$_GET['task']]['idAbstract'] ?>ic2">
                                    <option value="select">Select an option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                                <br>

                                <p>Final decision</p>
                                <select required="true" class="form-control" name="q<?= $tpc[$_GET['task']]['idAbstract'] ?>">
                                    <option value="select">Select an option</option>
                                    <option value="Included">Included</option>
                                    <option value="Excluded">Excluded</option>
                                </select>

                            </div>
                            <br>

                            <div class="alert" style="border: #dfdfdf solid 1px">
                                <p class="lead"> This is an attention test, if you are reading carefully all the task please check "<?= $tpc[$_GET['task']]['attentionTest'] ?>"</p>
                                <input type="radio" id="atstrongagree" name="attention" value="Strongly Agree">
                                <label for="atstrongagree">Strongly Agree</label><br>
                                <input type="radio" id="atsomewhatagree" name="attention" value="Somewhat Agree">
                                <label for="atsomewhatagree"> Somewhat Agree</label><br>
                                <input type="radio" id="atundecided" name="attention" value="Neither agree nor disagree">
                                <label for="atundecided">Neither agree nor disagree</label><br>
                                <input type="radio" id="atsomawhatdisagree" name="attention" value="Somewhat disagree">
                                <label for="atsomawhatdisagree">Somewhat disagree</label><br>
                                <input type="radio" id="atstrongagree" name="attention" value="Strongly disagree">
                                <label for="atstrongdisagree">Strongly disagree</label><br>

                            </div>


                            <div class="alert" style="border: #dfdfdf solid 1px">
                                <p class="lead"> I am confident that I correctly classified the article. Please check below the level of concordance in this sentence.</p>
                                <input type="radio" id="strongagree" name="confidence" value="Strongly Agree">
                                <label for="strongagree">Strongly Agree</label><br>
                                <input type="radio" id="somewhatagree" name="confidence" value="Somewhat Agree">
                                <label for="somewhatagree"> Somewhat Agree</label><br>
                                <input type="radio" id="undecided" name="confidence" value="Neither agree nor disagree">
                                <label for="undecided">Neither agree nor disagree</label><br>
                                <input type="radio" id="somawhatdisagree" name="confidence" value="Somewhat disagree">
                                <label for="somawhatdisagree">Somewhat disagree</label><br>
                                <input type="radio" id="strongagree" name="confidence" value="Strongly disagree">
                                <label for="strongdisagree">Strongly disagree</label><br>

                            </div>

                            <div class="alert" style="border: #dfdfdf solid 1px">
                                <label for="reasons">Could you provide, please, reasons for your inclusion or exclusion classification?</label>
                                <input type="text" class="form-control" name="reasons" placeholder="e.g., this study was out of the scope of Software Engineering"/>
                            </div>

                            <div style="margin: 40px;text-align: right;">
                                <input type="submit" name="submit" style="width: 200px" class="btn btn-success">
                            </div>
                        </form>

                    </div>
                <?php } ?>
        </body>
    </html>

    <?php
} else {
    echo "<h1>Error: the page you are trying to access does not exist </h1>";
}
?>