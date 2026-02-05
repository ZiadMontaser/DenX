<?php
//index.php
session_start();
if (isset($_SESSION['type'])) {
    if ($_SESSION['type'] != 4) {

        echo "Unauthorized access!!";
        if ($_SESSION['type'] === 2) {
            $url = 'receptionist.php';
        }
        if ($_SESSION['type'] === 3) {
            $url = 'dentist.php';
        }
        if ($_SESSION['type'] === 1) {
            $url = 'admin.php';
        }
        header('Location: ' . $url);
    }
} else {
    echo "login first!!";
    header('Location: ' . "login.php");
}


?>
<!doctype html>
<html lang=en>

<head>
    <title>Experiments</title>
    <meta charset=utf-8>
    <!--important prerequisite for escaping problem characters-->
    <link rel='stylesheet' href='public/fullcalendar/fullcalendar.css' />
    <link rel="stylesheet" href="public/lib/bootstrap.min.css">
    <style>
        @font-face {
            font-family: 'Glyphicons Halflings';
            src: url('public/lib/fonts/glyphicons-halflings-regular.eot');
            src: url('public/lib/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'),
                 url('public/lib/fonts/glyphicons-halflings-regular.woff2') format('woff2'),
                 url('public/lib/fonts/glyphicons-halflings-regular.woff') format('woff'),
                 url('public/lib/fonts/glyphicons-halflings-regular.ttf') format('truetype'),
                 url('public/lib/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') format('svg');
        }
    </style>
    <link rel="stylesheet" href="public/lib/jquery-ui/jquery-ui.css">
    <script src='public/lib/jquery.min.js'></script>

    <script src="public/lib/jquery-ui/jquery-ui.js"></script>
    <script src="public/lib/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/datatable/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="public/datatable/select.dataTables.min.css" />
    <script type="text/javascript" src="public/datatable/datatables.min.js"></script>
    <script type="text/javascript" src="public/datatable/dataTables.select.min.js"></script>
    <script src="public/lib/print.min.js"></script>
    <script src="public/lib/chart.js"></script>
    <script>
        $(function() {
            $(".date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                yearRange: "1900:+10",
                showOn: 'focus'
            });
        });
    </script>

</head>

<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['addrecep'])) {
                require('connect-mysql.php');
                // Validate the email address
                if (!empty($_POST['recepname'])) {
                    $e = mysqli_real_escape_string($dbcon, $_POST['recepname']);
                } else {
                    $e = FALSE;
                    echo '<p class="error">You forgot to enter your email address.</p>';
                }
                // Validate the password
                if (!empty($_POST['receppsw'])) {
                    $p = mysqli_real_escape_string($dbcon, $_POST['receppsw']);
                } else {
                    $p = FALSE;
                    echo '<p class="error">You forgot to enter your password.</p>';
                }
                if (!empty($_POST['rsex'])) {
                    $dsex = mysqli_real_escape_string($dbcon, $_POST['rsex']);
                } else {
                    $dsex = FALSE;
                    echo '<p class="error">You forgot to enter your sex.</p>';
                }
                if (!empty($_POST['rbdate'])) {
                    $dbdate = mysqli_real_escape_string($dbcon, $_POST['rbdate']);
                } else {
                    $dbdate = FALSE;
                    echo '<p class="error">You forgot to enter your bdate.</p>';
                }
                if (!empty($_POST['raddress'])) {
                    $daddress = mysqli_real_escape_string($dbcon, $_POST['raddress']);
                } else {
                    $daddress = FALSE;
                    echo '<p class="error">You forgot to enter your address.</p>';
                }
                if (!empty($_POST['rnash'])) {
                    $dnash = mysqli_real_escape_string($dbcon, $_POST['rnash']);
                } else {
                    $dnash = FALSE;
                    echo '<p class="error">You forgot to enter your nationality.</p>';
                }
                if (!empty($_POST['rphone'])) {
                    $dphone = mysqli_real_escape_string($dbcon, $_POST['rphone']);
                } else {
                    $dphone = FALSE;
                    echo '<p class="error">You forgot to enter your phone.</p>';
                }
                if (!empty($_POST['rssn'])) {
                    $dssn = mysqli_real_escape_string($dbcon, $_POST['rssn']);
                } else {
                    $dssn = FALSE;
                    echo '<p class="error">You forgot to enter your passport no.</p>';
                }
                if ($e && $p) {           //if no problems 
                    // Retrieve the user_id, first_name and user_level for that email/password combination
                    $q = "SELECT id, type FROM staff WHERE (name='$e')";
                    // Run the query and assign it to the variable $result
                    $result = @mysqli_query($dbcon, $q);
                    // Count the number of rows that match the email/password combination



                    if (@mysqli_num_rows($result) == 0) {       //if one database row (record) matches the input:-
                        // Start the session, fetch the record and insert the three values in an array


                        $q = "INSERT INTO staff(`type`, `name`, `password`, `sex`, `birthdate`, `address`, `nationality`, `phone`, `ssn`) VALUES (2, '$e', '$p', '$dsex', '$dbdate', '$daddress', '$dnash', '$dphone', '$dssn')";
                        // Run the query and assign it to the variable $result
                        $result = @mysqli_query($dbcon, $q);
                        $q = "SELECT `id` FROM `staff` WHERE ( `name`='$e' AND `password`='$p')";
                        // Run the query and assign it to the variable $result
                        $result = @mysqli_query($dbcon, $q);
                        $id = (int) mysqli_fetch_array($result, MYSQLI_ASSOC)['id'];
                        $q = "INSERT INTO receptionists(id) VALUES ($id)";
                        // Run the query and assign it to the variable $result
                        $result = @mysqli_query($dbcon, $q);

                        mysqli_close($dbcon);
                    } else {
                        echo '<p class="error">username already exists</p>';
                        mysqli_close($dbcon);
                    }
                } else { // If there was a problem.
                    echo '<p class="error">Please try again.</p>';
                    mysqli_close($dbcon);
                }
            } else if (isset($_POST['addden'])) {
                require('connect-mysql.php');
                // Validate the email address
                if (!empty($_POST['denname'])) {
                    $e = mysqli_real_escape_string($dbcon, $_POST['denname']);
                } else {
                    $e = FALSE;
                    echo '<p class="error">You forgot to enter your email address.</p>';
                }
                // Validate the password
                if (!empty($_POST['denpsw'])) {
                    $p = mysqli_real_escape_string($dbcon, $_POST['denpsw']);
                } else {
                    $p = FALSE;
                    echo '<p class="error">You forgot to enter your password.</p>';
                }






                if (!empty($_POST['dsex'])) {
                    $dsex = mysqli_real_escape_string($dbcon, $_POST['dsex']);
                } else {
                    $dsex = FALSE;
                    echo '<p class="error">You forgot to enter your sex.</p>';
                }
                if (!empty($_POST['dbdate'])) {
                    $dbdate = mysqli_real_escape_string($dbcon, $_POST['dbdate']);
                } else {
                    $dbdate = FALSE;
                    echo '<p class="error">You forgot to enter your bdate.</p>';
                }
                if (!empty($_POST['daddress'])) {
                    $daddress = mysqli_real_escape_string($dbcon, $_POST['daddress']);
                } else {
                    $daddress = FALSE;
                    echo '<p class="error">You forgot to enter your address.</p>';
                }
                if (!empty($_POST['dnash'])) {
                    $dnash = mysqli_real_escape_string($dbcon, $_POST['dnash']);
                } else {
                    $dnash = FALSE;
                    echo '<p class="error">You forgot to enter your nationality.</p>';
                }
                if (!empty($_POST['dphone'])) {
                    $dphone = mysqli_real_escape_string($dbcon, $_POST['dphone']);
                } else {
                    $dphone = FALSE;
                    echo '<p class="error">You forgot to enter your phone.</p>';
                }
                if (!empty($_POST['dssn'])) {
                    $dssn = mysqli_real_escape_string($dbcon, $_POST['dssn']);
                } else {
                    $dssn = FALSE;
                    echo '<p class="error">You forgot to enter your passport no.</p>';
                }
                if ($e && $p) {           //if no problems 
                    // Retrieve the user_id, first_name and user_level for that email/password combination
                    $q = "SELECT id, type FROM staff WHERE (name='$e')";
                    // Run the query and assign it to the variable $result
                    $result = @mysqli_query($dbcon, $q);
                    // Count the number of rows that match the email/password combination



                    if (@mysqli_num_rows($result) == 0) {       //if one database row (record) matches the input:-
                        // Start the session, fetch the record and insert the three values in an array


                        $q = "INSERT INTO staff(`type`, `name`, `password`, `sex`, `birthdate`, `address`, `nationality`, `phone`, `ssn`) VALUES (3, '$e', '$p', '$dsex', '$dbdate', '$daddress', '$dnash', '$dphone', '$dssn')";
                        // Run the query and assign it to the variable $result
                        $result = @mysqli_query($dbcon, $q);
                        $q = "SELECT `id` FROM `staff` WHERE ( `name`='$e' AND `password`='$p')";
                        // Run the query and assign it to the variable $result
                        $result = @mysqli_query($dbcon, $q);
                        $id = (int) mysqli_fetch_array($result, MYSQLI_ASSOC)['id'];
                        $q = "INSERT INTO dentists(id) VALUES ($id)";
                        // Run the query and assign it to the variable $result
                        $result = @mysqli_query($dbcon, $q);

                        mysqli_close($dbcon);
                    } else {
                        echo '<p class="error">username already exists</p>';
                        mysqli_close($dbcon);
                    }
                } else { // If there was a problem.
                    echo '<p class="error">Please try again.</p>';
                    mysqli_close($dbcon);
                }
            }
        }

        ?>
    </div>


    <div class="text-center">
        <button type="button" class="btn btn-primary" id="bd" onclick="dd()">Add Dentist</button>
        <button type="button" class="btn btn-primary" id="br" onclick="rr()">Add Recentionist</button>
        <button type="button" class="btn btn-primary" id="bs" onclick="ss()">Statistics</button>
        <button type="button" class="btn btn-primary" id="bf" onclick="ff()">Clinic information</button>
        <button type="button" class="btn btn-primary" id="ad" onclick="ad()">App Data</button>
        <button type="button" class="btn btn-default pull-right" onclick="window.location.replace('logout.php');">logout</button>

    </div>
    <div id="recep" style="display: none">
        <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="container col-md-4 text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="recepname"><b>Receptionist's Name</b></label>
                            <input type="text" placeholder="Enter Username" name="recepname" class="form-control" style="margin-bottom: 20px" required>
                        </div>
                        <div class="col-md-6">
                            <label for="receppsw"><b>Temporary Password</b></label>
                            <input type="password" placeholder="Enter Password" name="receppsw" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>





                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="rsex"><b>Sex</b></label>
                            <select type="text" placeholder="sex" name="rsex" id="rsex" class="form-control" style="margin-bottom: 20px">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="rbdate"><b>Birthdate</b></label>
                            <input type="text" placeholder="bdate" value="yyyy-mm-dd" name="rbdate" id="rbdate" class="date form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="raddress"><b>Address</b></label>
                            <input type="text" placeholder="Address" name="raddress" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                        <div class="col-md-6">
                            <label for="rnash"><b>Nationality</b></label>
                            <input type="text" placeholder="Nationality" name="rnash" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="rphone"><b>Phone</b></label>
                            <input type="number" placeholder="Phone" name="rphone" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                        <div class="col-md-6">
                            <label for="rssn"><b>Passport no.</b></label>
                            <input type="text" placeholder="Passport no." name="rssn" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>



                <div class="container">
                    <div class="row">
                        <div class="">
                            <button type="submit" class="btn btn-primary" name="addrecep">Add</button>

                        </div>
                    </div>
                </div>


            </div>
    </div>

    </form>
    </div>

    <div id="den" style="display: none">
        <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="container col-md-4 text-center">

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="denname"><b>Dentist's name</b></label>
                            <input type="text" placeholder="Enter Username" name="denname" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                        <div class="col-md-6">
                            <label for="denpsw"><b>Temporary Password</b></label>
                            <input type="password" placeholder="Enter Password" name="denpsw" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dsex"><b>Sex</b></label>
                            <select type="text" placeholder="sex" name="dsex" id="dsex" class="form-control" style="margin-bottom: 20px">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="dbdate"><b>Birthdate</b></label>
                            <input type="text" placeholder="bdate" value="yyyy-mm-dd" name="dbdate" id="dbdate" class="date form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="daddress"><b>Address</b></label>
                            <input type="text" placeholder="Address" name="daddress" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                        <div class="col-md-6">
                            <label for="dnash"><b>Nationality</b></label>
                            <input type="text" placeholder="Nationality" name="dnash" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dphone"><b>Phone</b></label>
                            <input type="number" placeholder="Phone" name="dphone" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                        <div class="col-md-6">
                            <label for="dssn"><b>Passport no.</b></label>
                            <input type="text" placeholder="Passport no." name="dssn" class="form-control" style="margin-bottom: 20px" required>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="">
                            <button type="submit" class="btn btn-primary" name="addden">Add</button>

                        </div>
                    </div>
                </div>


            </div>
    </div>

    </form>
    </div>













    <div id="stats" style="display: none">
        <div class="container-fluid" style="padding: 20px;">
            
            <!-- Page Header -->
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-md-12">
                    <h2 style="border-bottom: 3px solid #337ab7; padding-bottom: 10px; color: #333;">
                        <span class="glyphicon glyphicon-stats"></span> Statistics Dashboard
                    </h2>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px;">
                <li role="presentation" class="active">
                    <a href="#tab-overview" aria-controls="tab-overview" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-dashboard"></span> Overview
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tab-diagnosis" aria-controls="tab-diagnosis" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-search"></span> Diagnosis
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tab-treatment" aria-controls="tab-treatment" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-heart"></span> Treatment
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tab-visits" aria-controls="tab-visits" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-user"></span> Visits Demographics
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tab-finance" aria-controls="tab-finance" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-usd"></span> Finance
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                
                <!-- Overview Tab -->
                <div role="tabpanel" class="tab-pane active" id="tab-overview">
                    <div class="row">
                        <!-- Staff Section -->
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="glyphicon glyphicon-briefcase"></span> Staff Members</h3>
                                </div>
                                <div class="panel-body">
                                    <table id="staff" class="display table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Password</th>
                                                <th>Type</th>
                                                <th>Sex</th>
                                                <th>Birthdate</th>
                                                <th>Address</th>
                                                <th>Nationality</th>
                                                <th>Phone</th>
                                                <th>Passport No.</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Password</th>
                                                <th>Type</th>
                                                <th>Sex</th>
                                                <th>Birthdate</th>
                                                <th>Address</th>
                                                <th>Nationality</th>
                                                <th>Phone</th>
                                                <th>Passport No.</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Patients Section -->
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Registered Patients</h3>
                                </div>
                                <div class="panel-body">
                                    <table id="patients" class="display table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Sex</th>
                                                <th>Birthdate</th>
                                                <th>Address</th>
                                                <th>Nationality</th>
                                                <th>SSN</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Sex</th>
                                                <th>Birthdate</th>
                                                <th>Address</th>
                                                <th>Nationality</th>
                                                <th>SSN</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis Tab -->
                <div role="tabpanel" class="tab-pane" id="tab-diagnosis">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-search"></span> Diagnosis Report</h3>
                        </div>
                        <div class="panel-body">
                            <!-- Date Filter -->
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> Start Date</label>
                                            <input type="date" id="diagnose_start" class="form-control" onchange="reloadDiagnoseStates()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> End Date</label>
                                            <input type="date" id="diagnose_end" class="form-control" onchange="reloadDiagnoseStates()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-primary btn-block" onclick="printJS('diagnosis','html')">
                                                <span class="glyphicon glyphicon-print"></span> Print Report
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <h4><span class="glyphicon glyphicon-list-alt"></span> Data Table</h4>
                                    <div class="table-responsive">
                                        <table id="diagnosis" class="display table table-striped table-bordered table-hover table-condensed" style="width:100%">
                                            <thead class="bg-success">
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">Diagnosis</th>
                                                    <th colspan="4" class="text-center">Omani</th>
                                                    <th colspan="4" class="text-center">Non-Omani</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Total</th>
                                                </tr>
                                                <tr>
                                                    <th>0-4</th>
                                                    <th>5-14</th>
                                                    <th>15-59</th>
                                                    <th>60+</th>
                                                    <th>0-4</th>
                                                    <th>5-14</th>
                                                    <th>15-59</th>
                                                    <th>60+</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Diagnosis</th>
                                                    <th>0-4</th>
                                                    <th>5-14</th>
                                                    <th>15-59</th>
                                                    <th>60+</th>
                                                    <th>0-4</th>
                                                    <th>5-14</th>
                                                    <th>15-59</th>
                                                    <th>60+</th>
                                                    <th>Total</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <h4><span class="glyphicon glyphicon-signal"></span> Top Diagnoses</h4>
                                    <div style="position: relative; height: 400px; width: 100%; background: #f9f9f9; border-radius: 5px; padding: 10px;">
                                        <canvas id="diagnosisChart"></canvas>
                                    </div>
                                    <div class="text-center" style="margin-top: 15px;">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-default active" onclick="switchDiagnosisChart('doughnut')">Doughnut</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="switchDiagnosisChart('bar')">Bar</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="switchDiagnosisChart('polarArea')">Polar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4><span class="glyphicon glyphicon-stats"></span> Omani vs Non-Omani Breakdown</h4>
                                    <div style="position: relative; height: 400px; width: 100%; background: #f9f9f9; border-radius: 5px; padding: 10px;">
                                        <canvas id="diagnosisDemographicChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Treatment Tab -->
                <div role="tabpanel" class="tab-pane" id="tab-treatment">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-heart"></span> Treatment Report</h3>
                        </div>
                        <div class="panel-body">
                            <!-- Date Filter -->
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> Start Date</label>
                                            <input type="date" id="treatment_start" class="form-control" onchange="reloadTreatmentStates()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> End Date</label>
                                            <input type="date" id="treatment_end" class="form-control" onchange="reloadTreatmentStates()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-warning btn-block" onclick="printJS('treatment','html')">
                                                <span class="glyphicon glyphicon-print"></span> Print Report
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <h4><span class="glyphicon glyphicon-list-alt"></span> Data Table</h4>
                                    <table id="treatment" class="display table table-striped table-bordered table-hover" style="width:100%">
                                        <thead class="bg-warning">
                                            <tr>
                                                <th>Treatment</th>
                                                <th>Count</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Treatment</th>
                                                <th>Count</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h4><span class="glyphicon glyphicon-signal"></span> Chart View</h4>
                                    <div style="position: relative; height: 400px; width: 100%; background: #f9f9f9; border-radius: 5px; padding: 10px;">
                                        <canvas id="treatmentChart"></canvas>
                                    </div>
                                    <div class="text-center" style="margin-top: 15px;">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-default active" onclick="switchTreatmentChart('doughnut')">Doughnut</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="switchTreatmentChart('bar')">Bar</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="switchTreatmentChart('polarArea')">Polar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visits Demographics Tab -->
                <div role="tabpanel" class="tab-pane" id="tab-visits">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Visits by Gender & Nationality</h3>
                        </div>
                        <div class="panel-body">
                            <!-- Date Filter -->
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> Start Date</label>
                                            <input type="date" id="visits_start" class="form-control" onchange="loadVisitStats()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> End Date</label>
                                            <input type="date" id="visits_end" class="form-control" onchange="loadVisitStats()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-info btn-block" onclick="printJS('visits','html')">
                                                <span class="glyphicon glyphicon-print"></span> Print Report
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-4">
                                    <h4><span class="glyphicon glyphicon-list-alt"></span> Demographics Data</h4>
                                    <table id="visits" class="display table table-striped table-bordered table-hover table-condensed" style="width:100%">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>Category</th>
                                                <th>Count</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Category</th>
                                                <th>Count</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <h4><span class="glyphicon glyphicon-signal"></span> Charts Overview</h4>
                                    
                                    <div class="row">
                                        <!-- Population Pyramid -->
                                        <div class="col-md-8">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading text-center"><strong><span class="glyphicon glyphicon-align-left"></span> Population Pyramid by Age & Gender</strong></div>
                                                <div class="panel-body" style="height: 350px;">
                                                    <canvas id="populationPyramidChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Summary Pie -->
                                        <div class="col-md-4">
                                            <div class="panel panel-info">
                                                <div class="panel-heading text-center"><strong><span class="glyphicon glyphicon-pie-chart"></span> Overall Composition</strong></div>
                                                <div class="panel-body" style="height: 350px;">
                                                    <canvas id="summaryPieChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Grouped Bar Chart -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-success">
                                                <div class="panel-heading text-center"><strong><span class="glyphicon glyphicon-stats"></span> Omani vs Non-Omani Comparison by Demographics</strong></div>
                                                <div class="panel-body" style="height: 280px;">
                                                    <canvas id="groupedBarChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance Tab -->
                <div role="tabpanel" class="tab-pane" id="tab-finance">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-usd"></span> Profit Calculator</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="well">
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> Start Date</label>
                                            <input type="text" placeholder="yyyy-mm-dd" id="start" class="date form-control">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-calendar"></span> End Date</label>
                                            <input type="text" placeholder="yyyy-mm-dd" id="end" class="date form-control">
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label><span class="glyphicon glyphicon-usd"></span> Total Profit</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">OMR</span>
                                                <input type="number" placeholder="0.00" id="profit" class="form-control input-lg" disabled style="font-weight: bold; font-size: 24px; color: #5cb85c;">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-lg btn-block" onclick="calc()">
                                            <span class="glyphicon glyphicon-calculator"></span> Calculate Profit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>








    <div id="data" style="display: none;margin-top: 18px">
        <div class="container">
            <div class="row">
                <div class="col-xs-6" style="margin-top:56px">

                    <label for="cr"><b>CR</b></label>
                    <input type="text" placeholder="CR" name="cr" id="cr" class="form-control" style="margin-bottom: 20px">

                    <label for="code"><b>PoCode</b></label>
                    <input type="text" placeholder="PoCode" name="code" id="code" class="form-control" style="margin-bottom: 20px">

                    <label for="box"><b>PoBox</b></label>
                    <input type="text" placeholder="PoBox" name="box" id="box" class="form-control" style="margin-bottom: 20px">

                    <label for="fd-name"><b>Name</b></label>
                    <input type="text" placeholder="name" name="fd-name" id="fd-name" class="form-control" style="margin-bottom: 20px">

                    <button type="button" class="btn btn-primary save" onclick="e()">Edit</button>

                </div>
                <div class="col-xs-6">
                    <table id="phones" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>phone</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>phone</th>
                                <th>Description</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="container" style="margin-left:-38px">
                        <div class="row">
                            <div class="col-xs-3">
                                <label for="phone"><b>phone</b></label>
                                <input type="text" placeholder="phone" name="phone" id="phone" class="form-control" style="margin-bottom: 20px">

                            </div>
                            <div class="col-xs-3">
                                <label for="desc"><b>description</b></label>
                                <input type="text" placeholder="desc" name="desc" id="desc" class="form-control" style="margin-bottom: 20px">
                            </div>
                            <div class="col-xs-6" style="margin-top:24px;">
                                <button type="button" class="btn btn-primary save" onclick="phone()">Add</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="app_data" style="display: none;margin-top: 18px">
        <div class="container  m-5" >
            <div class="row">
                <div class="col-xs-6" >

                <button type="button" class="btn btn-primary save" onclick="restore()">Restore</button>

                </div>
                <div class="col-xs-6 center-block">
                <button type="button" class="btn btn-primary save" onclick="backup()">Back Up</button>


                </div>
            </div>
            <div class="row center-block ">
            <input type="file" class="form-control-file" id="sql_backup" name="content">

            </div>
        </div>
    </div>






    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">




                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="ename"><b>Name</b></label>
                                <input type="text" placeholder="Enter Username" name="ename" id="ename" class="form-control" style="margin-bottom: 20px" required>

                            </div>
                            <div class="col-md-3">
                                <label for="epassword"><b>Password</b></label>
                                <input type="password" placeholder="Enter Password" name="epassword" id="epassword" class="form-control" style="margin-bottom: 20px" required>

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="esex"><b>Sex</b></label>
                                <select type="text" placeholder="sex" name="esex" id="esex" class="form-control" style="margin-bottom: 20px">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>

                            </div>
                            <div class="col-md-3">
                                <label for="ebdate"><b>Birthdate</b></label>
                                <input type="text" placeholder="bdate" value="yyyy-mm-dd" name="ebdate" id="ebdate" class="date form-control" style="margin-bottom: 20px" required>

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="eaddress"><b>Address</b></label>
                                <input type="text" placeholder="Address" name="eaddress" id="eaddress" class="form-control" style="margin-bottom: 20px" required>

                            </div>
                            <div class="col-md-3">
                                <label for="enash"><b>Nationality</b></label>
                                <input type="text" placeholder="Nationality" name="enash" id="enash" class="form-control" style="margin-bottom: 20px" required>

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="ephone"><b>Phone</b></label>
                                <input type="number" placeholder="Phone" name="ephone" id="ephone" class="form-control" style="margin-bottom: 20px" required>

                            </div>
                            <div class="col-md-3">
                                <label for="essn"><b>Passport no.</b></label>
                                <input type="text" placeholder="Passport no." name="essn" id="essn" class="form-control" style="margin-bottom: 20px" required>

                            </div>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save" onclick="estaff()">Save</button>

                </div>
            </div>

        </div>
    </div>





    <script>
        var rx;
        $.ajax({
            url: "fd.php",
            type: "POST",
            success: function(events) {
                data = JSON.parse(events);
                $('#cr').val(data[0][0]);
                $('#code').val(data[0][1]);
                $('#box').val(data[0][2]);
                $('#fd-name').val(data[0][3]);
            }
        });
        t1 = $('#staff').DataTable({
            "bInfo": false,

            "lengthChange": false,
            "iDisplayLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": "staff.php"
        });
        $('#staff tbody').on('dblclick', 'tr', function(ev) {

            var cell = t1.row(this);
            rx = cell.data();
            $("#ename").val(rx[1]);
            $("#epassword").val(rx[2]);
            $("#esex").val(rx[4]);
            $("#ebdate").val(rx[5]);
            $("#eaddress").val(rx[6]);
            $("#enash").val(rx[7]);
            $("#ephone").val(rx[8]);
            $("#essn").val(rx[9]);

            $("#myModal").modal("show");

        });

        function estaff() {
            var data = {
                "id": rx[0],
                "x1": $("#ename").val(),
                "x2": $("#epassword").val(),
                "x4": $("#esex").val(),
                "x5": $("#ebdate").val(),
                "x6": $("#eaddress").val(),
                "x7": $("#enash").val(),
                "x8": $("#ephone").val(),
                "x9": $("#essn").val()
            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'edit-staff.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(res) {
                    t1.ajax.reload();
                    $("#myModal").modal("hide");
                },
                error: function(response) {
                    alert("some problem happened, please try again");
                }
            });
        }
        $('#staff tbody').on('mousedown', 'tr', function(ev) {
            var cell = t1.row(this);
            var r = cell.data();

            if (ev.which == 3 && r[0] != '1') {
                if (r[10] === 'no') {
                    if (confirm("are you sure you want to hide this member?!")) {
                        var data = {
                            "x": r[0]
                        };
                        var dataString = JSON.stringify(data);
                        $.ajax({
                            url: 'hide.php',
                            data: {
                                myData: dataString
                            },
                            type: 'POST',
                            success: function(res) {
                                t1.ajax.reload();
                            },
                            error: function(response) {
                                alert("some problem happened, please try again");
                            }
                        });
                    }
                } else {
                    if (confirm("are you sure you want to unhide this member?!")) {
                        var data = {
                            "x": r[0]
                        };
                        var dataString = JSON.stringify(data);
                        $.ajax({
                            url: 'unhide.php',
                            data: {
                                myData: dataString
                            },
                            type: 'POST',
                            success: function(res) {
                                t1.ajax.reload();
                            },
                            error: function(response) {
                                alert("some problem happened, please try again");
                            }
                        });
                    }
                }
            }
        });

        t2 = $('#patients').DataTable({
            "bInfo": false,

            "lengthChange": false,
            "iDisplayLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": "patients.php"
        });
        t3 = $('#phones').DataTable({
            "bInfo": false,

            "lengthChange": false,
            "processing": true,
            "serverSide": true,
            "ajax": "phones.php"
        });
        t4 = $('#diagnosis').DataTable({
            "order": [[9, 'desc']],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                { "className": "text-center", "targets": [1,2,3,4,5,6,7,8,9] }
            ]
        })
        reloadDiagnoseStates();
        t5 = $('#treatment').DataTable({
            "order": [1, 'desc']
        })
        reloadTreatmentStates();
        t6 = $('#visits').DataTable({
            "ordering": false,
            "paging": false,
            "searching": false,
            "info": false
        })
        loadVisitStats();
        var column = t1.column($(this).attr('ID'));
        column.visible(!column.visible());
        column = t2.column($(this).attr('ID'));
        column.visible(!column.visible());


        function e() {
            $.ajax({
                url: "edit-fd.php",
                type: "POST",
                data: {
                    cr: $('#cr').val(),
                    code: $('#code').val(),
                    box: $('#box').val(),
                    name: $('#fd-name').val()
                },
                success: function(events) {
                    data = JSON.parse(events);
                    $('#cr').val(data[0][0]);
                    $('#code').val(data[0][1]);
                    $('#box').val(data[0][2]);
                    $('#fd-name').val(data[0][3]);
                }
            });
        }

        function calc() {
            $.ajax({
                url: "calc.php",
                type: "POST",
                data: {
                    start: $('#start').val(),
                    end: $('#end').val()
                },
                success: function(events) {
                    data = JSON.parse(events);
                    $('#profit').val(data);
                }
            });
        }

        var diagnosisChartInstance = null;
        var treatmentChartInstance = null;
        var visitsComparisonChartInstance = null;
        
        var diagnosisData = [];
        var treatmentData = [];
        var currentDiagnosisChartType = 'doughnut';
        var currentTreatmentChartType = 'doughnut';
        
        // Color palette for charts
        var chartColors = [
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 99, 132, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(199, 199, 199, 0.8)',
            'rgba(83, 102, 255, 0.8)',
            'rgba(255, 99, 255, 0.8)',
            'rgba(99, 255, 132, 0.8)',
            'rgba(255, 182, 193, 0.8)',
            'rgba(144, 238, 144, 0.8)',
            'rgba(173, 216, 230, 0.8)',
            'rgba(238, 130, 238, 0.8)',
            'rgba(240, 230, 140, 0.8)'
        ];

        function switchDiagnosisChart(type) {
            currentDiagnosisChartType = type;
            renderDiagnosisChart(diagnosisData);
        }

        function switchTreatmentChart(type) {
            currentTreatmentChartType = type;
            renderTreatmentChart(treatmentData);
        }

        var diagnosisDemographicChartInstance = null;

        function renderDiagnosisChart(data) {
            diagnosisData = data;
            var labels = [];
            var counts = [];
            var omaniCounts = [];
            var nonOmaniCounts = [];
            
            for (var i = 0; i < data.length && i < 15; i++) {
                labels.push(data[i][0]);
                // Sum all demographic counts for total
                var omaniTotal = data[i][1] + data[i][2] + data[i][3] + data[i][4];
                var nonOmaniTotal = data[i][5] + data[i][6] + data[i][7] + data[i][8];
                var total = omaniTotal + nonOmaniTotal;
                counts.push(total);
                omaniCounts.push(omaniTotal);
                nonOmaniCounts.push(nonOmaniTotal);
            }

            if (diagnosisChartInstance) {
                diagnosisChartInstance.destroy();
            }

            var ctx = document.getElementById('diagnosisChart').getContext('2d');
            var config = {
                type: currentDiagnosisChartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Diagnosis Count',
                        data: counts,
                        backgroundColor: chartColors.slice(0, counts.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: currentDiagnosisChartType === 'bar' ? 'top' : 'right',
                            labels: { font: { size: 10 } }
                        },
                        title: {
                            display: true,
                            text: 'Top Diagnoses',
                            font: { size: 14 }
                        }
                    }
                }
            };
            
            if (currentDiagnosisChartType === 'bar') {
                config.options.scales = { y: { beginAtZero: true } };
                config.options.indexAxis = 'y';
            }
            
            diagnosisChartInstance = new Chart(ctx, config);

            // Render demographic breakdown chart
            if (diagnosisDemographicChartInstance) {
                diagnosisDemographicChartInstance.destroy();
            }

            var ctx2 = document.getElementById('diagnosisDemographicChart').getContext('2d');
            diagnosisDemographicChartInstance = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Omani',
                            data: omaniCounts,
                            backgroundColor: 'rgba(92, 184, 92, 0.8)',
                            borderColor: 'rgba(92, 184, 92, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Non-Omani',
                            data: nonOmaniCounts,
                            backgroundColor: 'rgba(217, 83, 79, 0.8)',
                            borderColor: 'rgba(217, 83, 79, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Omani vs Non-Omani by Diagnosis',
                            font: { size: 14 }
                        }
                    },
                    scales: {
                        x: { 
                            beginAtZero: true,
                            stacked: true
                        },
                        y: { stacked: true }
                    }
                }
            });
        }

        function renderTreatmentChart(data) {
            treatmentData = data;
            var labels = [];
            var counts = [];
            for (var i = 0; i < data.length && i < 15; i++) {
                labels.push(data[i][0]);
                counts.push(parseInt(data[i][1]));
            }

            if (treatmentChartInstance) {
                treatmentChartInstance.destroy();
            }

            var ctx = document.getElementById('treatmentChart').getContext('2d');
            var config = {
                type: currentTreatmentChartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Treatment Count',
                        data: counts,
                        backgroundColor: chartColors.slice(0, counts.length),
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: currentTreatmentChartType === 'bar' ? 'top' : 'right',
                            labels: { font: { size: 10 } }
                        },
                        title: {
                            display: true,
                            text: 'Top Treatments',
                            font: { size: 14 }
                        }
                    }
                }
            };
            
            if (currentTreatmentChartType === 'bar') {
                config.options.scales = { y: { beginAtZero: true } };
                config.options.indexAxis = 'y';
            }
            
            treatmentChartInstance = new Chart(ctx, config);
        }

        var populationPyramidChartInstance = null;
        var summaryPieChartInstance = null;
        var groupedBarChartInstance = null;

        function renderVisitsCharts(data) {
            // Parse data
            var omaniMale = [];
            var omaniFemale = [];
            var nonOmaniMale = [];
            var nonOmaniFemale = [];
            var ageGroups = ['0-4', '5-14', '15-59', '60+'];
            
            var omaniTotal = 0;
            var nonOmaniTotal = 0;
            var maleTotal = 0;
            var femaleTotal = 0;
            
            for (var i = 0; i < data.length; i++) {
                var label = data[i][0];
                var count = parseInt(data[i][1]) || 0;
                
                if (label.indexOf('Omani Male') === 0 && label.indexOf('Non-Omani') === -1) {
                    omaniMale.push(count);
                    omaniTotal += count;
                    maleTotal += count;
                } else if (label.indexOf('Omani Female') === 0 && label.indexOf('Non-Omani') === -1) {
                    omaniFemale.push(count);
                    omaniTotal += count;
                    femaleTotal += count;
                } else if (label.indexOf('Non-Omani Male') === 0) {
                    nonOmaniMale.push(count);
                    nonOmaniTotal += count;
                    maleTotal += count;
                } else if (label.indexOf('Non-Omani Female') === 0) {
                    nonOmaniFemale.push(count);
                    nonOmaniTotal += count;
                    femaleTotal += count;
                }
            }
            
            // Calculate totals for each age group (male negative for pyramid)
            var maleTotals = [];
            var femaleTotals = [];
            for (var j = 0; j < 4; j++) {
                maleTotals.push(-((omaniMale[j] || 0) + (nonOmaniMale[j] || 0)));
                femaleTotals.push((omaniFemale[j] || 0) + (nonOmaniFemale[j] || 0));
            }
            
            var grandTotal = omaniTotal + nonOmaniTotal;

            // 1. Population Pyramid Chart
            if (populationPyramidChartInstance) populationPyramidChartInstance.destroy();
            var ctx1 = document.getElementById('populationPyramidChart').getContext('2d');
            populationPyramidChartInstance = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ageGroups,
                    datasets: [
                        {
                            label: 'Male (Omani)',
                            data: omaniMale.map(function(v) { return -v; }),
                            backgroundColor: 'rgba(54, 162, 235, 0.9)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            stack: 'male'
                        },
                        {
                            label: 'Male (Non-Omani)',
                            data: nonOmaniMale.map(function(v) { return -v; }),
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            stack: 'male'
                        },
                        {
                            label: 'Female (Omani)',
                            data: omaniFemale,
                            backgroundColor: 'rgba(255, 99, 132, 0.9)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            stack: 'female'
                        },
                        {
                            label: 'Female (Non-Omani)',
                            data: nonOmaniFemale,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            stack: 'female'
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { font: { size: 10 } } },
                        title: { 
                            display: true, 
                            text: 'Age Distribution (Male ← | → Female)',
                            font: { size: 14 }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + Math.abs(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            ticks: {
                                callback: function(value) { return Math.abs(value); }
                            },
                            title: { display: true, text: 'Number of Patients' }
                        },
                        y: {
                            stacked: true,
                            title: { display: true, text: 'Age Group' }
                        }
                    }
                }
            });

            // 2. Summary Pie Chart
            if (summaryPieChartInstance) summaryPieChartInstance.destroy();
            var ctx2 = document.getElementById('summaryPieChart').getContext('2d');
            summaryPieChartInstance = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Omani Male', 'Omani Female', 'Non-Omani Male', 'Non-Omani Female'],
                    datasets: [{
                        data: [
                            omaniMale.reduce(function(a, b) { return a + b; }, 0),
                            omaniFemale.reduce(function(a, b) { return a + b; }, 0),
                            nonOmaniMale.reduce(function(a, b) { return a + b; }, 0),
                            nonOmaniFemale.reduce(function(a, b) { return a + b; }, 0)
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.9)',
                            'rgba(255, 99, 132, 0.9)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { font: { size: 10 }, padding: 8 }
                        },
                        title: { 
                            display: true, 
                            text: 'Total: ' + grandTotal + ' visits',
                            font: { size: 12 }
                        }
                    }
                }
            });

            // 3. Grouped Bar Chart
            if (groupedBarChartInstance) groupedBarChartInstance.destroy();
            var ctx3 = document.getElementById('groupedBarChart').getContext('2d');
            groupedBarChartInstance = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['Male 0-4', 'Male 5-14', 'Male 15-59', 'Male 60+', 'Female 0-4', 'Female 5-14', 'Female 15-59', 'Female 60+'],
                    datasets: [
                        {
                            label: 'Omani',
                            data: omaniMale.concat(omaniFemale),
                            backgroundColor: 'rgba(92, 184, 92, 0.8)',
                            borderColor: 'rgba(92, 184, 92, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Non-Omani',
                            data: nonOmaniMale.concat(nonOmaniFemale),
                            backgroundColor: 'rgba(217, 83, 79, 0.8)',
                            borderColor: 'rgba(217, 83, 79, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        title: { 
                            display: true, 
                            text: 'Omani (' + omaniTotal + ') vs Non-Omani (' + nonOmaniTotal + ')',
                            font: { size: 13 }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            title: { display: true, text: 'Count' }
                        },
                        x: {
                            title: { display: true, text: 'Demographics' }
                        }
                    }
                }
            });
        }


        function reloadDiagnoseStates() {
            start_date = "1990-05-20"
            end_date = "2030-05-20"
            if ($('#diagnose_start').val() != "") start_date = $('#diagnose_start').val();
            if ($('#diagnose_end').val() != "") end_date = $('#diagnose_end').val();
            $.ajax({
                url: "diagnosis-stats.php",
                type: "GET",
                data: {
                    start: start_date,
                    end: end_date
                },
                success: function(events) {
                    data = JSON.parse(events);
                    // Add total column to each row
                    var tableData = data.map(function(row) {
                        var total = row[1] + row[2] + row[3] + row[4] + row[5] + row[6] + row[7] + row[8];
                        return [row[0], row[1], row[2], row[3], row[4], row[5], row[6], row[7], row[8], total];
                    });
                    t4.clear();
                    t4.rows.add(tableData).draw();
                    renderDiagnosisChart(data);
                }
            });
        }

        function reloadTreatmentStates() {
            start_date = "1990-05-20"
            end_date = "2030-05-20"
            if ($('#treatment_start').val() != "") start_date = $('#treatment_start').val();
            if ($('#treatment_end').val() != "") end_date = $('#treatment_end').val();
            $.ajax({
                url: "treatment-stats.php",
                type: "GET",
                data: {
                    start: start_date,
                    end: end_date
                },
                success: function(events) {
               
                    data = JSON.parse(events);
                    console.log(data)
                    t5.clear();
                    t5.rows.add(data).draw();
                    renderTreatmentChart(data);
                }
            });
        }

        function loadVisitStats(){
            start_date = "1990-05-20"
            end_date = "2030-05-20"
            if ($('#visits_start').val() != "") start_date = $('#visits_start').val();
            if ($('#visits_end').val() != "") end_date = $('#visits_end').val();
            
            $.ajax({
                url: "visits-states.php",
                type: "GET",
                data: {
                    start: start_date,
                    end: end_date
                },
                success: function(events) {
                    console.log(events)

                    data = JSON.parse(events);
                    console.log(data)
                    t6.clear();
                    t6.rows.add(data).draw();
                    renderVisitsCharts(data);
                }
            });
        }

        function phone() {
            $.ajax({
                url: "add-phone.php",
                type: "POST",
                data: {
                    phone: $('#phone').val(),
                    desc: $('#desc').val()
                },
                success: function(events) {
                    t3.ajax.reload();
                }
            });
            $('#phone').val("");
            $('#desc').val("");
        }
        $('#phones tbody').on('mousedown', 'tr', function(ev) {

            if (ev.which == 3) {
                if (confirm("delete?")) {
                    var cell = t3.row(this);
                    r = cell.data();
                    $.ajax({
                        url: "del-phone.php",
                        type: "POST",
                        data: {
                            phone: r[0],
                            desc: r[1]
                        },
                        success: function(events) {
                            t3.ajax.reload();
                        }
                    });
                }
            }
        });

        function dd() {

            document.getElementById("den").style.display = "block";
            document.getElementById("recep").style.display = "none";
            document.getElementById("stats").style.display = "none";
            document.getElementById("data").style.display = "none";
            document.getElementById("app_data").style.display = "none";
        }

        function rr() {

            document.getElementById("stats").style.display = "none";
            document.getElementById("data").style.display = "none";
            document.getElementById("den").style.display = "none";
            document.getElementById("recep").style.display = "block";
            document.getElementById("app_data").style.display = "none";
        }

        function ff() {

            document.getElementById("stats").style.display = "none";
            document.getElementById("data").style.display = "block";
            document.getElementById("den").style.display = "none";
            document.getElementById("recep").style.display = "none";
            document.getElementById("app_data").style.display = "none";
        }

        function ss() {

            t1.ajax.reload();
            t2.ajax.reload();
            
            document.getElementById("stats").style.display = "block";
            document.getElementById("data").style.display = "none";
            document.getElementById("den").style.display = "none";
            document.getElementById("recep").style.display = "none";
            document.getElementById("app_data").style.display = "none";
            
            // Reload stats and charts after making visible
            setTimeout(function() {
                reloadDiagnoseStates();
                reloadTreatmentStates();
                loadVisitStats();
            }, 100);
        }

        // Re-render charts when switching tabs
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if (target === "#tab-diagnosis") {
                reloadDiagnoseStates();
            } else if (target === "#tab-treatment") {
                reloadTreatmentStates();
            } else if (target === "#tab-visits") {
                loadVisitStats();
            }
        });

        function ad() {
            document.getElementById("stats").style.display = "none";
            document.getElementById("data").style.display = "none";
            document.getElementById("den").style.display = "none";
            document.getElementById("recep").style.display = "none";
            document.getElementById("app_data").style.display = "block";
        }

        function backup() {
            window.location = "export-db.php";
        }

        function restore() {
            var fileContent = $('#sql_backup').prop('files');
            var reader = new FileReader();
            reader.readAsText(fileContent[0], "UTF-8")
            reader.onload = function(e) {
                $.ajax({
                    url: 'import-db.php',
                    type: 'POST',
                    data: {
                        content: reader.result
                    },
                    success: function(res) {
                        alert("Updated successfully")
                    },
                    error: function(response) {
                        alert("some problem happened, please try again");
                    }
                });
            };


        }
    </script>
</body>

</html>