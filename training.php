<?php
if (isset($_GET['task'])) {
    $contents = file_get_contents("data/training.json", true);
    $parsedContent = json_decode($contents, true);

    ?>
    <!DOCTYPE html>


    <html>

    <?php include 'elements/head.php' ?>

    <body class="container">

        <div >
            <div class="jumbotron" style="background:white	; text-align: center" >
                <h1 class="display-4">Classifying Scientific Abstracts</h1>
                <p class="lead">Welcome crowdworker!</p>
            </div>

            <div>
                <div class="row">
                    <div style="background-color: #efefef" class="card col-md-4">
                        <span style="text-align: center; width: 100%" ><img style="padding: 5px" src="images/teacher.png" width="80"></span>
                        <p style="text-align: center; width: 100%" >Training</p>
                    </div>
                    <div class="card col-md-4">
                        <span style="text-align: center; width: 100%"><img style="padding: 5px" src="images/document.png" width="80"></span>
                        <p   style="text-align: center; width: 100%">Task</p>
                    </div>
                    <div class="card col-md-4">
                        <span style="text-align: center; width: 100%"><img style="padding: 5px" src="images/checkmark.png" width="80"></span>
                        <p  style="text-align: center; width: 100%">Finish</p>
                    </div>
                </div>
            </div>


            <?php include 'elements/instructions.php' ?>

            <div class="jumbotron" style="background:white	; text-align: center" >
                <h1 class="display-4">Let's start the training phase!</h1>
            </div>
            <form action="task.php?task=<?= $_GET['task'] ?>" method="POST">
                <?php foreach ($parsedContent as $abs) { ?>

                    <br><hr><br>

                    <p class="lead">Study <?= $abs['idAbstract'] + 1 ?></p>
                    <div class="card alert-secondary" style="margin-top:20px;padding: 20px">
                        <h3 class="display-5"><b><?= $abs['title'] ?></b></h3>
                        <p class="lead">Abstract: <?= $abs['fullAbstract'] ?></p>
                    </div>
                    <div id="question" style="margin-top:20px; padding: 20px; " class="card alert-info">
                        <p>IC1 - Does the article focus on aligning Software Engineering education with industrial needs?</p>
                        <select required="true" id="q<?= $abs['idAbstract'] ?>ic1" class="form-control" name="q<?= $abs['idAbstract'] ?>ic1">
                            <option value="select">Select an option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <br>

                        <p>IC2 - Is the article based on empirical data and not just the opinion of the authors?</p>
                        <select required="true" id="q<?= $abs['idAbstract'] ?>ic2" class="form-control" name="q<?= $abs['idAbstract'] ?>ic2">
                            <option value="select">Select an option</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <br>
                        <p>Final decision</p>
                        <select required="true" id="q<?= $abs['idAbstract'] ?>" class="form-control" name="q<?= $abs['idAbstract'] ?>">
                            <option value="select">Select an option</option>
                            <option value="Included">Included</option>
                            <option value="Excluded">Excluded</option>
                        </select>
                    </div>

                <?php } ?>

                <div style="margin: 40px;text-align: right;">
                    <input type="submit" name="submit" style="width: 200px" value ="Next" class="btn btn-success">
                </div>
            </form>

        </div>
    </body>
    </html>

    <?php
} else {
    echo "<h1>Error: the page you are trying to access does not exist </h1>";
}
?>