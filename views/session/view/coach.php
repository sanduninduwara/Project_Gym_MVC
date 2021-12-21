<?php

$sessionId = $_SESSION['data']['select_session'];
$arr = $_SESSION['data'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <?php
    require 'public/html/boostraplinks.html';
    ?>
    <link rel="stylesheet" href=<?= BASE_DIR . "public/css/login.css" ?>>


    <title>Session View</title>
</head>

<body>

    <?php
    // require_once("../../../build/HTML/navbar.php");
    ?>
    <a href=<?= BASE_DIR . "Session/search" ?>>Back to search</a><br>

    <div class="simple-login-container">
        <h2>Session Details</h2>
        <div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Session Id</label>
                    <input type="text" class="form-control" name='session_id' value=<?php echo $arr["Session_id"] ?> readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Session Name</label>
                    <input type="text" class="form-control" name='session_name' value=<?php echo $arr["Session_Name"] ?> readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Coach</label>
                    <input type="text" class="form-control" name='coach_email' value=<?php echo $arr["Coach_Email"] ?> readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Date</label>
                    <input type="text" class="form-control" name='date' value=<?php echo $arr["Date"] ?> readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Start Time</label>
                    <input type="text" class="form-control" name='startTime' value=<?php echo $arr["Start_Time"] ?> readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>End Time</label>
                    <input type="text" class="form-control" name='endTime' value=<?php echo $arr["End_Time"] ?> readonly>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Number of participants</label>
                    <input type="text" class="form-control" name='num_participants' value=<?php echo $arr["Num_Participants"] ?> readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Price</label>
                    <input type="text" class="form-control" name='price' value=<?php echo $arr["Price"] ?> readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Details</label>
                    <input type="text" class="form-control" name='details' value=<?php echo $arr["Details"] ?> readonly>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-center" style="color:crimson">

    </div>
</body>

</html>