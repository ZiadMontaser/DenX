<?php
//index.php
session_start();
if (isset($_SESSION['type'])) {
    if ($_SESSION['type'] != 1) {

        echo "Unauthorized access!!";
        if ($_SESSION['type'] === 2) {
            $url = 'receptionist.php';
        }
        if ($_SESSION['type'] === 3) {
            $url = 'dentist.php';
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
    <link rel="stylesheet" href="public/lib/jquery-ui/jquery-ui.css">
    <script src='public/lib/jquery.min.js'></script>

    <script src="public/lib/jquery-ui/jquery-ui.js"></script>
    <script src="public/lib/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/datatable/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="public/datatable/select.dataTables.min.css" />
    <script type="text/javascript" src="public/datatable/datatables.min.js"></script>
    <script type="text/javascript" src="public/datatable/dataTables.select.min.js"></script>
    <script src="public/lib/print.min.js"></script>
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
        <div class="container">
            <div class="row">
                <h3>Staff...</h3>
                <table id="staff" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Type</th>
                            <th>sex</th>
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Nationality</th>
                            <th>Phone</th>
                            <th>Passport no.</th>
                            <th>Hidden</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Type</th>
                            <th>sex</th>
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Nationality</th>
                            <th>Phone</th>
                            <th>Passport no.</th>
                            <th>Hidden</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <h3>Patients...</h3>

                <table id="patients" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Sex</th>
                            <th>Bitrhdate</th>
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
                            <th>Bitrhdate</th>
                            <th>Address</th>
                            <th>Nationality</th>
                            <th>SSN</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row p-32">
                <h3>Diagnosis Report...</h3>
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="start"><b>start</b></label>
                            <input type="date" placeholder="start" name="start" id="diagnose_start" class="w-25 form-control" style="margin-bottom: 20px" onchange="reloadDiagnoseStates()">
                        </div>
                        <div class="col-md-5">
                            <label for="end"><b>end</b></label>
                            <input type="date" placeholder="end" name="end" id="diagnose_end" class="w-25 form-control" style="margin-bottom: 20px" onchange="reloadDiagnoseStates()">
                        </div>
                        <div class="col-md-2" style="margin-top:24px">
                            <button type="button" class="btn btn-primary save" onclick="printJS('diagnosis','html')">Print</button>
                        </div>
                    </div>
                </div>
                <table id="diagnosis" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Diagnos</th>
                            <th>Number</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Diagnos</th>
                            <th>Number</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row p-32">
                <h3>Treatment Report...</h3>
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="start"><b>start</b></label>
                            <input type="date" placeholder="start" name="start" id="treatment_start" class="w-25 form-control" style="margin-bottom: 20px" onchange="reloadTreatmentStates()">
                        </div>
                        <div class="col-md-5">
                            <label for="end"><b>end</b></label>
                            <input type="date" placeholder="end" name="end" id="treatment_end" class="w-25 form-control" style="margin-bottom: 20px" onchange="reloadTreatmentStates()">
                        </div>
                        <div class="col-md-2" style="margin-top:24px">
                            <button type="button" class="btn btn-primary save" onclick="printJS('treatment','html')">Print</button>
                        </div>
                    </div>
                </div>
                <table id="treatment" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Treatment</th>
                            <th>Number</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Treatment</th>
                            <th>Number</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h3>Profit calculator</h3>
                    <label for="start"><b>start</b></label>
                    <input type="text" placeholder="start" name="start" id="start" value="yyyy-mm-dd" class="date form-control" style="margin-bottom: 20px">
                    <label for="end"><b>end</b></label>
                    <input type="text" placeholder="end" name="end" id="end" value="yyyy-mm-dd" class="date form-control" style="margin-bottom: 20px">
                    <div class="container" style="margin-left:24px">
                        <div class="row">
                            <div class="col-md-10">
                                <label for="profit"><b>Profit</b></label>
                                <input type="number" placeholder="profit" name="profit" id="profit" class="form-control" style="margin-bottom: 20px" disabled>
                            </div>
                            <div class="col-md-2" style="margin-top:24px">
                                <button type="button" class="btn btn-primary save" onclick="calc()">Clac.</button>
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
            "order": [1, 'desc']
        })
        reloadDiagnoseStates();
        t5 = $('#treatment').DataTable({
            "order": [1, 'desc']
        })
        reloadTreatmentStates();
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
                    t4.clear();
                    t4.rows.add(data).draw();
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
                    t5.clear();
                    t5.rows.add(data).draw();
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
        }

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