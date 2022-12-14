<?php
@session_start();
if (isset($_SESSION['id']) && $_SESSION['type'] == 2) {
?>
<?php
include "../Controller/VaccinationCenterController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vaccination center panel</title>
    <link href="Css/bootstrap.min.css" rel="stylesheet">
    <link href="Css/Style_sheet.css" rel="stylesheet">
</head>
<body>
<nav class="navbar sticky-top navbar-light justify-content-between" style="background-color: #20c997">
    <a href="../index.php" class="link">Home</a>
    <form action="../Controller/LoginController.php" method="post" class="form-inline">
        <input type="submit" value="Log out" name="logout" class="btn btn-primary my-2 my-sm-0">
    </form>
</nav>

<div class="row">
    <div class="col-12">
        <div class="cardhead"><h>Welcome, <?php echo $modelInstance->getName(); ?></h></div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="cardbody">
            <form action="../Controller/VaccinationCenterController.php" method="post">
                <p>Reservation No. : </p>
                <p><input  type="text" name="res_no" placeholder="reservation number"></p>
                <span style="color:red"><?php echoError('err'); ?></span><br>
                <input type="submit" value="Search" name="res_find" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="cardbody">
            <p>
            <form action="../Controller/VaccinationCenterController.php" method="post" enctype="multipart/form-data">
                <p class="card-text">User's name : <?php echoDetails('NameUser'); ?></p>
                <p class="card-text">National ID : <?php echoDetails('NatID'); ?></p>
                <p class="card-text">Vaccine name : <?php echoDetails('NameVac'); ?></p>
                <?php
                    if (isset($_SESSION['Doses'])) {
                        if ($_SESSION['Doses'] == 1) {
                ?>
                <p style="color: #20c997">This user is eligible for the second dose</p>
                <input type="file" name="file"><br>
                <?php
                        }
                    }
                ?>
                <span style="color:red"><?php echoError('uerr'); ?></span><br>
                <input type="submit" name="res_confirm" value="Confirm" class="btn btn-primary">
            </form>
            </>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="backcard">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Reservation number</th>

                    <th>Name</th>

                    <th>National ID</th>

                    <th>Vaccine name</th>
                </tr>

                <?php
                $modelInstance->listReservations();
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<?php
} else {
    header("location: ..");
}
?>