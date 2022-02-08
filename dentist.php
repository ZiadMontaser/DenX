<?php
//index.php
session_start();
if (isset($_SESSION['type'])  && $_SESSION['hidden'] === '0') {
    if ($_SESSION['type'] != 3) {

        echo "Unauthorized access!!";
        if ($_SESSION['type'] === 2) {
            $url = 'receptionist.php';
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
    <title>Calendar</title>
    <meta charset=utf-8>
    <!--important prerequisite for escaping problem characters-->
    <link rel='stylesheet' href='public/fullcalendar/fullcalendar.css' />
    <link rel="stylesheet" href="public/lib/bootstrap.min.css">
    <link rel="stylesheet" href="public/lib/jquery-ui/jquery-ui.css">
    <script src='public/lib/jquery.min.js'></script>

    <script src="public/lib/jquery-ui/jquery-ui.js"></script>

    <script src='public/lib/moment.min.js'></script>
    <script src='public/fullcalendar/fullcalendar.js'></script>
    <script src="public/lib/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/datatable/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="public/datatable/select.dataTables.min.css" />
    <script type="text/javascript" src="public/datatable/datatables.min.js"></script>
    <script type="text/javascript" src="public/datatable/dataTables.select.min.js"></script>
    <script src="public/lib/print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/lib/print.min.css">
    <link rel="stylesheet" type="text/css" href="css/print_page.css">
    <script>
        $(function() {
            $(".date").datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    <style>

    </style>

</head>

<body>
    <div id='calendar'></div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <div id='modal-calendar'></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#pi" aria-controls="pi" role="tab" data-toggle="tab">Patient info.</a>


                            </li>
                            <li role="presentation"><a href="#vi" aria-controls="vi" role="tab" data-toggle="tab">Visit date</a>

                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="pi">

                                <div id="add-new-patient" style="display:none">
                                    <div class="container" style="margin-left: -15px">
                                        <div class="row">
                                            <div class="col-xs-3">

                                                <label for="new-patient-name"><b>Name</b></label>
                                                <input type="text" placeholder="Name" name="new-patient-name" id="new-patient-name" class="form-control" style="margin-bottom: 20px">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="new-patient-ssn"><b>Phone</b></label>
                                                <input type="text" placeholder="Phone" name="new-patient-ssn" id="new-patient-ssn" class="form-control" style="margin-bottom: 20px">

                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: none">
                                        <label for="new-phone"><b>Phone</b></label>
                                        <input type="number" placeholder="Phone" name="new-phone" id="new-phone" class="form-control" style="margin-bottom: 20px">
                                    </div>

                                    <div class="container" style="margin-left: -15px">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label for="sex"><b>Sex</b></label>
                                                <select type="text" placeholder="sex" name="sex" id="sex" class="form-control" style="margin-bottom: 20px">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>

                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="bd"><b>Birthdate</b></label>
                                                <input type="text" placeholder="bd" name="bd" id="bd" class="date form-control" style="margin-bottom: 20px">
                                            </div>
                                        </div>
                                    </div>

                                    <label for="address"><b>Address</b></label>
                                    <input type="text" placeholder="address" name="address" id="address" class="form-control" style="margin-bottom: 20px">

                                    <div class="container" style="margin-left: -15px">
                                        <div class="row">
                                            <div class="col-xs-3">

                                                <label for="nation"><b>Nationality</b></label>
                                                <input type="text" placeholder="nationality" name="nation" id="nation" class="form-control" style="margin-bottom: 20px">



                                            </div>
                                            <div class="col-xs-3">





                                                <label for="new-comment"><b>Comment</b></label>
                                                <input type="text" placeholder="Comment" name="new-comment" id="new-comment" class="form-control" style="margin-bottom: 20px">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="save-patient" class="btn btn-primary save" onclick="savePatient()">Save patient</button>
                                </div>
                                <div id="patientss">
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
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="vi">
                                <label for="date"><b>date</b></label>
                                <input type="text" placeholder="date" name="date" id="date" class="date form-control" style="margin-bottom: 20px">
                                <label for="start"><b>start</b></label>
                                <input type="time" placeholder="start" name="start" id="start" class="form-control" style="margin-bottom: 20px">
                                <div style="display:none">
                                    <label for="end"><b>end</b></label>
                                    <input type="time" placeholder="end" name="end" id="end" class="form-control" style="margin-bottom: 20px">
                                </div>
                                <label for="payment"><b>payment</b></label>
                                <input type="number" placeholder="payment" name="payment" id="payment" class="form-control" style="margin-bottom: 20px" disabled>
                                <label for="Comment"><b>Comment</b></label>
                                <input type="text" placeholder="Comment" name="Comment" id="Comment" class="form-control" style="margin-bottom: 20px">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save" onclick="save()">Save Visit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="pModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div id='disp-patient-calendar' style="display: none"></div>
                    <div id="pt">
                        <table id="disp-patients" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Sex</th>
                                    <th>Bitrhdate</th>
                                    <th>Address</th>
                                    <th>Nationality</th>
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
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" onclick="patientList()" id="vv" style="display: none">Back</button>

                </div>

            </div>
        </div>
    </div>




    <div class="modal fade" id="dModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div id='disp-dentist-calendar' style="display: none"></div>
                    <div id="dt">
                        <table id="disp-dentists" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" id="cc" style="display: none">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" onclick="dentistList()" id="cc" style="display: none">Back</button>

                </div>

            </div>
        </div>
    </div>




    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a onclick="document.getElementById('se').style.display='block';document.getElementById('pres').style.display='none';document.getElementById('surg').style.display='none';document.getElementById('diag').style.display='none';document.getElementById('pres3').style.display='none';document.getElementById('pres4').style.display='none';" href="#piz" aria-controls="piz" role="tab" data-toggle="tab">Visit data</a>
                            </li>
                            <li role="presentation"><a onclick="document.getElementById('se').style.display='none';document.getElementById('surg').style.display='none';document.getElementById('pres').style.display='none';document.getElementById('diag').style.display='block';document.getElementById('pres3').style.display='none';document.getElementById('attendance').style.display='none';document.getElementById('pres4').style.display='none';" href="#viz" aria-controls="viz" role="tab" data-toggle="tab">Diagnosis</a>
                            </li>
                            <li role="presentation"><a onclick="document.getElementById('se').style.display='none';document.getElementById('diag').style.display='none';document.getElementById('pres').style.display='none';document.getElementById('surg').style.display='block';document.getElementById('pres3').style.display='none';document.getElementById('attendance').style.display='none';document.getElementById('pres4').style.display='none';" href="#piz2" aria-controls="piz2" role="tab" data-toggle="tab">Managements</a>
                            </li>
                            <li role="presentation"><a onclick="document.getElementById('se').style.display='none';document.getElementById('surg').style.display='none';document.getElementById('diag').style.display='none';document.getElementById('pres').style.display='block';document.getElementById('pres3').style.display='none';document.getElementById('attendance').style.display='none';document.getElementById('pres4').style.display='none';loadPres();" href="#viz2" aria-controls="viz2" role="tab" data-toggle="tab">prescriptions</a>
                            </li>
                            <li role="presentation"><a onclick="document.getElementById('se').style.display='none';document.getElementById('surg').style.display='none';document.getElementById('diag').style.display='none';document.getElementById('pres').style.display='none';document.getElementById('pres3').style.display='block';document.getElementById('attendance').style.display='none';document.getElementById('pres4').style.display='none';loadSickLeave()" href="#viz3" aria-controls="viz3" role="tab" data-toggle="tab">Sick leave</a>
                            </li>
                            <li role="presentation"><a onclick="document.getElementById('se').style.display='none';document.getElementById('surg').style.display='none';document.getElementById('diag').style.display='none';document.getElementById('pres').style.display='none';document.getElementById('pres3').style.display='none';document.getElementById('attendance').style.display='block';document.getElementById('pres4').style.display='none';loadAttendance()" href="#viz5" aria-controls="viz5" role="tab" data-toggle="tab">Attendance</a>
                            </li>
                            <li role="presentation"><a onclick="document.getElementById('se').style.display='none';document.getElementById('surg').style.display='none';document.getElementById('diag').style.display='none';document.getElementById('pres').style.display='none';document.getElementById('pres3').style.display='none';document.getElementById('attendance').style.display='none';document.getElementById('pres4').style.display='block';loadReport();" href="#viz4" aria-controls="viz4" role="tab" data-toggle="tab">Visit report</a>
                            </li>

                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="piz">



                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-4">


                                            <div>
                                                <div class="container" style="margin-left: -15px">
                                                    <div class="row">
                                                        <div class="col-xs-2">

                                                            <label for="pp1x"><b>Name</b></label>
                                                            <input type="text" placeholder="Name" name="pp1x" id="pp1x" class="form-control" style="margin-bottom: 20px" disabled>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <label for="pp2x"><b>Phone</b></label>
                                                            <input type="text" placeholder="Phone" name="pp2x" id="pp2x" class="form-control" style="margin-bottom: 20px" disabled>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display: none">
                                                    <label for="pp3x"><b>Phone</b></label>
                                                    <input type="text" placeholder="Phone" name="pp3x" id="pp3x" class="form-control" style="margin-bottom: 20px" disabled>
                                                </div>

                                                <div class="container" style="margin-left: -15px">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <label for="pp4x"><b>Sex</b></label>
                                                            <select type="text" placeholder="sex" name="pp4x" id="pp4x" class="form-control" style="margin-bottom: 20px" disabled>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Other">Other</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <label for="pp5x"><b>Birthdate</b></label>
                                                            <input type="text" placeholder="bd" name="pp5x" id="pp5x" class="date form-control" style="margin-bottom: 20px" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label for="pp6x"><b>Address</b></label>
                                                <input type="text" placeholder="address" name="pp6x" id="pp6x" class="form-control" style="margin-bottom: 20px" disabled>

                                                <div class="container" style="margin-left: -15px">
                                                    <div class="row">
                                                        <div class="col-xs-2">

                                                            <label for="pp7x"><b>Nationality</b></label>
                                                            <input type="text" placeholder="nationality" name="pp7x" id="pp7x" class="form-control" style="margin-bottom: 20px" disabled>



                                                        </div>
                                                        <div class="col-xs-2">





                                                            <label for="pp8x"><b>Comment</b></label>
                                                            <input type="text" placeholder="Comment" name="pp8x" id="pp8x" class="form-control" style="margin-bottom: 20px" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>










                                        </div>






                                        <div class="col-xs-4">
                                            <div style="display:none">
                                                <label for="vid"><b>Visit ID</b></label>
                                                <input type="number" placeholder="vid" name="vid" id="vid" class="form-control" style="margin-bottom: 20px" disabled>
                                            </div>
                                            <label for="date"><b>date</b></label>
                                            <input type="text" placeholder="date" name="Edate" id="Edate" class=" date form-control" style="margin-bottom: 20px">
                                            <label for="start"><b>start</b></label>
                                            <input type="time" placeholder="start" name="Estart" id="Estart" class="form-control" style="margin-bottom: 20px">
                                            <div style="display: none">
                                                <label for="end"><b>end</b></label>
                                                <input type="time" placeholder="end" name="Eend" id="Eend" class="form-control" style="margin-bottom: 20px">
                                            </div>
                                            <div class="container" style="margin-left:-16px">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label for="payment"><b>payment</b></label>
                                                        <input type="number" placeholder="payment" name="Epayment" id="Epayment" class="form-control" style="margin-bottom: 20px" disabled>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="ent"><b>entry</b></label>
                                                        <input type="number" placeholder="ent" name="ent" id="ent" class="form-control" style="margin-bottom: 20px" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="Comment"><b>Comment</b></label>
                                            <input type="text" placeholder="Comment" name="EComment" id="EComment" class="form-control" style="margin-bottom: 20px">


                                        </div>
                                    </div>
                                </div>






                            </div>

                            <div role="tabpanel" class="tab-pane" id="viz">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="tooth"><b>Tooth</b></label>
                                            <input type="text" list="toto1" placeholder="tooth" name="tooth" id="tooth" class="form-control" style="margin-bottom: 20px">
                                            <datalist id="toto1">

                                            </datalist>
                                            <label for="dia"><b>Diagnosis</b></label>
                                            <input type="text" list="diadia" placeholder="diagnosis" name="dia" id="dia" class="form-control" style="margin-bottom: 20px">
                                            <datalist id="diadia">

                                            </datalist>
                                            <label for="dComment"><b>Comment</b></label>
                                            <input type="text" placeholder="dComment" name="dComment" id="dComment" class="form-control" style="margin-bottom: 20px">
                                        </div>
                                        <div class="col-xs-5">
                                            <table id="dtDiag" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Tooth</th>
                                                        <th>Diagnosis</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Tooth</th>
                                                        <th>Diagnosis</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="piz2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="stooth"><b>Tooth</b></label>
                                            <input type="text" list="toto2" placeholder="tooth" name="stooth" id="stooth" class="form-control" style="margin-bottom: 20px">
                                            <datalist id="toto2">

                                            </datalist>
                                            <label for="sur"><b>Management</b></label>
                                            <input type="text" list="sursur" placeholder="Management" name="sur" id="sur" class="form-control" style="margin-bottom: 20px">
                                            <datalist id="sursur">

                                            </datalist>
                                            <label for="sprice"><b>Price</b></label>
                                            <input type="number" placeholder="Price" name="sprice" id="sprice" class="form-control" style="margin-bottom: 20px">
                                            <label for="sComment"><b>Comment</b></label>
                                            <input type="text" placeholder="Comment" name="sComment" id="sComment" class="form-control" style="margin-bottom: 20px">
                                        </div>
                                        <div class="col-xs-5">
                                            <table id="dtSur" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Tooth</th>
                                                        <th>Management</th>
                                                        <th>Price</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Tooth</th>
                                                        <th>Management</th>
                                                        <th>Price</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="viz2">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="med"><b>Medicine</b></label>
                                            <input type="text" list="medmed" placeholder="medicine" name="med" id="med" class="form-control" style="margin-bottom: 20px">
                                            <datalist id="medmed">

                                            </datalist>

                                            <label for="mg"><b>mg</b></label>
                                            <input type="number" placeholder="mg" name="mg" id="mg" class="form-control" style="margin-bottom: 20px">
                                            <label for="dose"><b>Dose</b></label>
                                            <input type="text" placeholder="dose" name="dose" id="dose" class="form-control" style="margin-bottom: 20px">
                                            <label for="pComment"><b>Comment</b></label>
                                            <input type="text" placeholder="Comment" name="pComment" id="pComment" class="form-control" style="margin-bottom:20px">
                                        </div>
                                        <div class="col-xs-5">
                                            <div>
                                                <table id="dtpres" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Medicine</th>
                                                            <th>mg</th>
                                                            <th>Dose</th>
                                                            <th>Comment</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Medicine</th>
                                                            <th>mg</th>
                                                            <th>Dose</th>
                                                            <th>Comment</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="viz3">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-4">



                                            <div class="container" style="margin-left:-15px">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label for="slname"><b>Name</b></label>
                                                        <input type="text" placeholder="name" name="slname" id="slname" class="form-control" style="margin-bottom: 20px" onchange="$('#sl1').html($('#slname').val());">
                                                    </div>
                                                    <div class="col-xs-2">

                                                        <label for="slsex"><b>Sex</b></label>
                                                        <select type="text" placeholder="sex" name="slsex" id="slsex" class="form-control" style="margin-bottom: 20px" onchange="$('#slsex1').html($('#slsex').val() === 'Male'?'he':'she');">
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>



                                                    </div>
                                                </div>
                                            </div>



                                            <label for="slwork"><b>Place of work</b></label>
                                            <input type="text" placeholder="work place" name="slwork" id="slwork" class="form-control" style="margin-bottom: 20px" onchange="$('#sl2').html($('#slwork').val());">
                                            <label for="sldiag"><b>Diagnosis</b></label>
                                            <input type="text" placeholder="diagnosis" name="sldiag" id="sldiag" class="form-control" style="margin-bottom: 20px" onchange="$('#sl3').html($('#sldiag').val());">
                                            <label for="sldn"><b>Management</b></label>
                                            <input type="text" placeholder="dentist name" name="sldn" id="sldn" class="form-control" style="margin-bottom:20px" onchange="$('#sl7').html($('#sldn').val());">
                                            <label for="sld"><b>Duration</b></label>
                                            <input type="number" placeholder="Comment" name="sld" id="sld" class="form-control" style="margin-bottom:20px" onchange="updateSickleaveDuration();">
                                            <div class="container" style="margin-left:-15px">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label for="slstart"><b>Start</b></label>
                                                        <input type="text" placeholder="start" name="slstart" id="slstart" class="date form-control" style="margin-bottom:20px" onchange="$('#sl5').html($('#slstart').val());updateSickleaveDuration()">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="slend"><b>End</b></label>
                                                        <input disabled type="text" placeholder="end" name="slend" id="slend" class=" date form-control" style="margin-bottom:20px" onchange="$('#sl6').html($('#slend').val());">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-xs-5">

                                            <div id="slfile" style="zoom: 0.6; ">
                                                <div class="file">
                                                    <div class="line_page_border">
                                                        <img class="logo" src="img/ClinicLog.png"> </img>
                                                        <img class="watermark" src="img/ClinicLog.png"> </img>
                                                        <!-- <h4 style="margin-top: 10px">Alkamil dental clinic </h4></br> -->
                                                        <h4 style="margin-top: 15px">C.R no. :1268338</h4></br>
                                                        <h2 class="page_head">Sick leave</h2></br>
                                                        </br><br><br>
                                                        <div>Patient name: <span id="sl1"></span></br>
                                                            Place of work: <span id="sl2"></span></br><br>

                                                            Alkamil dental clinic certifies that; the above mentioned patient is diagnosed in our clinic
                                                            and <span id="slsex1">he</span> found suffering from <span id="sl3"></span>,
                                                            <span id="sl7"></span> was done for him and he is eligible to take sick leave for <span id="sl4"></span> days
                                                            form date <span id="sl5"></span> to date <span id="sl6"></span></br>

                                                            </br><br><br></br><br><br>
                                                            Dentist name:
                                                            <?php echo ucwords(strtolower($_SESSION['name'])) ?></br>
                                                            <br>
                                                            Sign and stamp
                                                            &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;clinic
                                                            stamp
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="viz5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-4">



                                            <div class="container" style="margin-left:-15px">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label for="aname"><b>Name</b></label>
                                                        <input type="text" placeholder="name" name="aname" id="aname" class="form-control" style="margin-bottom: 20px" onchange="$('#a1').html($('#aname').val());">
                                                    </div>
                                                    <div class="col-xs-2">

                                                        <label for="asex"><b>Sex</b></label>
                                                        <select type="text" placeholder="sex" name="asex" id="asex" class="form-control" style="margin-bottom: 20px" onchange="$('#asex1').html($('#asex').val() === 'Male'?'he':'she');">
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>



                                                    </div>
                                                </div>
                                            </div>



                                            <label for="awork"><b>Place of work</b></label>
                                            <input type="text" placeholder="work place" name="awork" id="awork" class="form-control" style="margin-bottom: 20px" onchange="$('#a2').html($('#awork').val());">
                                            <div class="container" style="margin-left:-15px">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label for="astart"><b>Start</b></label>
                                                        <input type="time" placeholder="start" name="astart" id="astart" class="form-control" style="margin-bottom:20px" onchange="$('#a4').html($('#astart').val());">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="aend"><b>End</b></label>
                                                        <input type="time" placeholder="end" name="aend" id="aend" class="form-control" style="margin-bottom:20px" onchange="$('#a5').html($('#aend').val());">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-xs-5">

                                            <div id="afile" style="zoom: 0.6; ">
                                                <div class="file">
                                                    <div class="line_page_border">
                                                        <img class="logo" src="img/ClinicLog.png"> </img>
                                                        <img class="watermark" src="img/ClinicLog.png"> </img>
                                                        <!-- <h4 style="margin-top: 10px">Alkamil dental clinic </h4></br> -->
                                                        <h4 style="margin-top: 15px">C.R no. :1268338</h4></br>
                                                        <h2 class="page_head">Attendance</h2></br>
                                                        </br><br><br>
                                                        <div>Patient name: <span id="a1"></span></br>
                                                            Place of work: <span id="a2"></span></br><br>
                                                            Alkamil dental clinic certifies that the above mentioned patient was examined in
                                                            our clinic from <span id="a4">12:34 PM</span> to <span id="a5">1:10 PM</span>

                                                            </br><br><br></br><br><br>
                                                            Dentist name:
                                                            <?php echo ucwords(strtolower($_SESSION['name'])) ?></br>
                                                            <br>
                                                            Sign and stamp
                                                            &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;clinic
                                                            stamp
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="viz4">
                                <div id="vrfile" style="zoom: 0.8;" class="file">
                                    <div class="line_page_border">
                                        <img class="logo" src="img/ClinicLog.png"> </img>
                                        <img class="watermark" src="img/ClinicLog.png"> </img>
                                        <!-- <h4 style="margin-top: 10px">Alkamil dental clinic </h4></br> -->
                                        <h4 style="margin-top: 15px">C.R no. :1268338</h4></br>
                                        <h2 class="page_head">Visit report</h2>
                                        </br><br>
                                        <div>
                                            <div id="visr"></div>
                                            <div id="diar"></div>
                                            <div id="manr"></div>
                                            <div id="prer"></div>
                                            </br><br>
                                            Dentist name:
                                            <?php echo ucwords(strtolower($_SESSION['name'])) ?></br>
                                            <br>
                                            Sign and stamp
                                            &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;clinic
                                            stamp
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer" id="se">
                    <button type="button" class="btn btn-primary save" onclick="saveEdit()">Save Visit</button>
                </div>
                <div class="modal-footer" id="diag" style="display:none">
                    <button type="button" class="btn btn-primary save" onclick="addDiag()">Save Diagnosis</button>
                    <button type="button" class="btn btn-primary save" onclick="clearDiag()">Clear Diagnosis</button>
                </div>
                <div class="modal-footer" id="surg" style="display:none">
                    <button type="button" class="btn btn-primary save" onclick="addSur()">Save Management</button>
                    <button type="button" class="btn btn-primary save" onclick="clearSur()">Clear Managements</button>
                </div>
                <div class="modal-footer" id="pres" style="display:none">
                    <button type="button" class="btn btn-primary save" onclick="addPres()">Save Medicine</button>
                    <button type="button" class="btn btn-primary save" onclick="clearPres()">clear prescription</button>
                    <button type="button" class="btn btn-primary save" onclick="loadPres();
                                                                                document.querySelector('#pres_file').parentElement.style.display = 'block';
                                                                                printJS({printable:'pres_file', type:'html', css:'css/print_page.css', style:'img{display:block;}'});
                                                                                document.querySelector('#pres_file').parentElement.style.display = 'none';
                                                                                ">Print precription</button>
                </div>
                <div class="modal-footer" id="pres3" style="display:none">
                    <button type="button" class="btn btn-default save" onclick="clearsl()">Clear</button>
                    <button type="button" class="btn btn-primary save" onclick="printJS({printable:'slfile', type:'html', css:'css/print_page.css'})">Print</button>
                </div>
                <div class="modal-footer" id="attendance" style="display:none">
                    <!-- <button type="button" class="btn btn-default save" onclick="clearsl()">Clear input</button> -->
                    <button type="button" class="btn btn-primary save" onclick="printJS({printable:'afile', type:'html', css:'css/print_page.css'})">Print</button>
                </div>
                <div class="modal-footer" id="pres4" style="display:none">
                    <button type="button" class="btn btn-primary save" onclick="printJS({printable:'vrfile', type:'html', css:'css/print_page.css'})">Print</button>
                    <button type="button" class="btn btn-primary save" onclick="payrep()">payment report</button>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none">
        <div id="pres_file" class="file">
            <div class="line_page_border">
                <img class="logo" src="img/ClinicLog.png"> </img>
                <img class="watermark" src="img/ClinicLog.png"> </img>
                <!-- <h4 style="margin-top: 10px">Alkamil dental clinic </h4></br> -->
                <h4 style="margin-top: 15px">C.R no. :1268338</h4></br>
                <h2 class="page_head">Prescription</h2></br>
                </br><br><br>
                <div>
                    <div id="prpes">

                    </div>
                    </br><br><br></br><br><br>
                    Dentist name:
                    <?php echo ucwords(strtolower($_SESSION['name'])) ?></br>
                    <br>
                    Sign and stamp
                    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;clinic
                    stamp
                </div>

            </div>
        </div>

    </div>
    <div style="display: none" id="payrephead">
        <h4>payment report: </h4>" + "</br>
        <table id="payrep" border="1" style="border: 1px solid black;">

            <tr style="border: 1px solid black;">
                <th style="border: 1px solid black;">item</th>
                <th style="border: 1px solid black;">price</th>
            </tr>
        </table>
    </div>

    <script>
        window.onbeforeunload = confirmExit;

        function confirmExit() {
            return "You have attempted to leave this page. Are you sure?";
        }
        var p = -1;
        var pid = -1;
        var did = <?php echo $_SESSION['id'] ?>;
        var d = <?php echo $_SESSION['id'] ?>;


        function clearsl() {
            $('#slname').val("");
            $('#slwork').val("");
            $('#sldiag').val("");
            $('#sld').val("");
            $('#slstart').val("");
            $('#slend').val("");
            $('#sldn').val("");
            $('#sl1').html("");
            $('#sl2').html("");
            $('#sl3').html("");
            $('#sl4').html("");
            $('#sl5').html("");
            $('#sl6').html("");
            $('#sl7').html("");

        }

        function altt() {
            if (document.getElementById("add-new-patient").style.display === "none") {
                document.getElementById("add-new-patient").style.display = "block";
                document.getElementById("patientss").style.display = "none";
                document.getElementById("new-ext").innerHTML = "Existing patient";
            } else {
                document.getElementById("add-new-patient").style.display = "none";
                document.getElementById("patientss").style.display = "block";
                document.getElementById("new-ext").innerHTML = "New patient";
            }
        }

        function savePatient() {
            var name = document.getElementById("new-patient-name").value;
            var ssn = document.getElementById("new-patient-ssn").value;
            var phone = document.getElementById("new-phone").value;
            var comment = document.getElementById("new-comment").value;
            var sex = $('#sex').val();
            var bdate = $('#bd').val();
            var address = $('#address').val();
            var nationality = $('#nation').val();

            if (name === "") {
                alert("name field is empty");
                return;

            }
            if (ssn === "") {
                alert("phone field is empty");
                return;
            }
            var data = {
                "name": name,
                "ssn": ssn,
                "phone": phone,
                "comment": comment,
                "sex": sex,
                "bdate": bdate,
                "address": address,
                "nationality": nationality

            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-patient.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(response) {
                    var tle = $('#patients').DataTable({
                        "lengthChange": false,
                        "iDisplayLength": 5
                    });
                    tle.ajax.reload();
                    tle.page('last').draw('page');
                    altt();
                    document.getElementById("new-patient-name").value = "";
                    document.getElementById("new-patient-ssn").value = "";
                    document.getElementById("new-phone").value = "";
                    document.getElementById("new-comment").value = "";
                    $('#sex').val("");
                    $('#bd').val("");
                    $('#address').val("");
                    $('#nation').val("");

                },
                error: function(response) {
                    alert("some problem happened, please try again");
                }
            });
        }

        function coloring(event) {
            var dt = moment(new Date());
            if (event.done === 0 && moment(event.start._i).isBefore(dt) && moment(event.end._i).isAfter(dt)) {
                return "orange";
            }
            if (event.done === 0 && moment(event.start._i).isBefore(dt) && moment(event.end._i).isBefore(dt)) {

                return "red";
            }
            if (event.done === 0 && moment(event.start._i).isAfter(dt) && moment(event.end._i).isAfter(dt)) {
                console.log(moment(event.end._i));
                return "blue";
            }
            return "black"
        }

        function patientList() {
            document.getElementById("disp-patient-calendar").style.display = "none";
            document.getElementById("pt").style.display = "block";
            document.getElementById("vv").style.display = "none";
            $('#disp-patient-calendar').fullCalendar('removeEventSources');
        }

        function dentistList() {
            document.getElementById("disp-dentist-calendar").style.display = "none";
            document.getElementById("dt").style.display = "block";
            document.getElementById("cc").style.display = "none";
            $('#disp-dentist-calendar').fullCalendar('removeEventSources');
        }

        function save() {
            var date1 = document.getElementById("date").value;
            var start1 = document.getElementById("start").value;
            var end1 = document.getElementById("end").value;
            var payment1 = document.getElementById("payment").value;
            var comment1 = document.getElementById("Comment").value;
            if (date1 == "") {
                date1 = moment().format("YYYY-MM-DD");

            } else console.log(date1);
            if (start1 == "") {
                start1 = moment().format('HH:mm');
                console.log(moment().format('HH:mm'))
                end1 = "23:59";
            }

            if (payment1 == "") {
                payment1 = 0;
            }
            if (p == -1) {
                alert("select patient first!!");
                return;
            }
            if (d == -1) {
                alert("select dentist first!!");
                return;
            }
            var data = {
                "patientId": p,
                "dentistId": d,
                "start": date1 + " " + start1,
                "end": date1 + " " + end1,
                "payment": payment1,
                "Comment": comment1
            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-visit.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(response) {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#modal-calendar').fullCalendar('refetchEvents');
                }
            });
            $('[href="#pi"]').tab('show');
            document.getElementById("date").value = "";
            document.getElementById("start").value = "";
            document.getElementById("end").value = "";
            document.getElementById("payment").value = "";
            document.getElementById("Comment").value = "";
            t1.rows('.selected').nodes().to$().removeClass('selected');
            t2.rows('.selected').nodes().to$().removeClass('selected');
            $("#addModal").modal("hide");

        }

        function saveEdit() {
            var vid = document.getElementById("vid").value;
            var date1 = document.getElementById("Edate").value;
            var start1 = document.getElementById("Estart").value;
            var end1 = document.getElementById("Eend").value;
            var payment1 = document.getElementById("Epayment").value;
            var comment1 = document.getElementById("EComment").value;
            document.getElementById("Edate").disabled = false;
            document.getElementById("Estart").disabled = false;
            document.getElementById("Eend").disabled = false;
            document.getElementById("Epayment").disabled = true;
            document.getElementById("EComment").disabled = false;
            if (date1 == "") {
                alert("select date first!!");
                return;
            }
            if (start1 == "") {
                alert("select starting time first!!");
                return;
            }
            if (end1 == "") {
                alert("select ending time first!!");
                return;
            }
            if (payment1 == "") {
                payment1 = 0;
            }

            var data = {
                "vid": vid,
                "start": date1 + " " + start1,
                "end": date1 + " " + end1,
                "payment": payment1,
                "Comment": comment1
            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'edit-visit.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(response) {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#modal-calendar').fullCalendar('refetchEvents');
                    if (pid != -1) {
                        $('#disp-patient-calendar').fullCalendar('removeEventSources');
                        $.ajax({
                            url: "load-patient-dentist.php",
                            type: "POST",
                            data: {
                                pid: pid,
                                did: did
                            },
                            success: function(events) {
                                data = JSON.parse(events);
                                console.log(events)
                                $('#disp-patient-calendar').fullCalendar('addEventSource', data);
                                //$('#disp-patient-calendar').fullCalendar('renderEvents');
                            }
                        });
                    }
                    if (did != -1) {
                        $('#disp-dentist-calendar').fullCalendar('removeEventSources');
                        $.ajax({
                            url: "load-dentist.php",
                            type: "POST",
                            data: {
                                did: did
                            },
                            success: function(events) {
                                data = JSON.parse(events);
                                console.log(events)
                                $('#disp-dentist-calendar').fullCalendar('addEventSource', data);
                                //$('#disp-patient-calendar').fullCalendar('renderEvents');
                            }
                        });
                    }
                }
            });

            $("#editModal").modal("hide");

        }
        var aa = [];
        var bb = [];
        var cc = [];
        var dd = [];
        $(document).ready(function() {

            $.ajax({
                url: "medicine.php",
                type: "POST",
                success: function(response) {
                    data = JSON.parse(response);
                    for (var i = 0; i < data.length; i++) {
                        $('#medmed').append('<option value="' + data[i][0] + '">');
                        aa.push(data[i][0]);
                    }

                }
            });
            $.ajax({
                url: "diagnosis.php",
                type: "POST",
                success: function(response) {
                    data = JSON.parse(response);
                    for (var i = 0; i < data.length; i++) {
                        $('#diadia').append('<option value="' + data[i] + '">');
                        bb.push(data[i]);
                    }

                }
            });
            $.ajax({
                url: "surgery.php",
                type: "POST",
                success: function(response) {
                    data = JSON.parse(response);
                    for (var i = 0; i < data.length; i++) {
                        $('#sursur').append('<option value="' + data[i] + '">');
                        cc.push(data[i]);
                    }

                }
            });
            $.ajax({
                url: "tooth.php",
                type: "POST",
                success: function(response) {
                    data = JSON.parse(response);
                    for (var i = 0; i < data.length; i++) {
                        $('#toto1').append('<option value="' + data[i][0] + '">');
                        $('#toto2').append('<option value="' + data[i][0] + '">');
                        dd.push(data[i][0]);
                    }

                }
            });
            t1 = $('#patients').DataTable({
                "bInfo": false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": true,
                select: {
                    style: 'single'
                },
                "ajax": "patients-dentist.php"
            });

            t2 = $('#dentists').DataTable({
                "bInfo": false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": false,
                select: {
                    style: 'single'
                },
                "ajax": "dentists.php"
            });
            t3 = $('#disp-patients').DataTable({
                "bInfo": false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": false,
                "ajax": "patients-dentist.php"
            });
            t4 = $('#disp-dentists').DataTable({
                "bInfo": false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": false,
                "ajax": "dentists.php"
            });
            var column = t1.column($(this).attr('ID'));
            column.visible(!column.visible());
            column = t2.column($(this).attr('ID'));
            column.visible(!column.visible());
            column = t3.column($(this).attr('ID'));
            column.visible(!column.visible());
            column = t4.column($(this).attr('ID'));
            column.visible(!column.visible());

            t5 = $('#dtDiag').DataTable({
                "lengthChange": false,
                "bInfo": false,

                "iDisplayLength": 5
            });
            $('#dtDiag tbody').on('mousedown', 'tr', function(ev) {
                var cell = t5.row(this);
                console.log(cell)
                var r = cell.data();
                if (ev.which == 3) {

                    if (confirm("are you sure you want to delete this medicine?!")) {
                        var data = {
                            "x1": r[0],
                            "x2": r[1],
                            "x3": r[2]
                        };
                        var dataString = JSON.stringify(data);
                        $.ajax({
                            url: 'del-diag.php',
                            data: {
                                myData: dataString
                            },
                            type: 'POST',
                            success: function(res) {
                                $.ajax({
                                    url: "diag.php",
                                    type: "POST",
                                    data: {
                                        vid: $('#vid').val()
                                    },
                                    success: function(events) {
                                        data = JSON.parse(events);
                                        t5.clear().draw();
                                        t5.rows.add(data); // Add new data
                                        t5.columns.adjust().draw(); // Redraw the DataTable
                                        //$('#disp-patient-calendar').fullCalendar('renderEvents');
                                    }
                                });
                            },
                            error: function(response) {
                                alert("some problem happened, please try again");
                            }
                        });
                    }
                }
            });
            t6 = $('#dtSur').DataTable({
                "lengthChange": false,
                "bInfo": false,

                "iDisplayLength": 5
            });
            $('#dtSur tbody').on('mousedown', 'tr', function(ev) {
                var cell = t6.row(this);
                console.log(cell)
                var r = cell.data();
                if (ev.which == 3) {

                    if (confirm("are you sure you want to delete this medicine?!")) {
                        var data = {
                            "x1": r[0],
                            "x2": r[1],
                            "x3": r[2],
                            "x4": r[3]
                        };
                        var dataString = JSON.stringify(data);
                        $.ajax({
                            url: 'del-sur.php',
                            data: {
                                myData: dataString
                            },
                            type: 'POST',
                            success: function(res) {
                                $.ajax({
                                    url: "sur.php",
                                    type: "POST",
                                    data: {
                                        vid: $('#vid').val()
                                    },
                                    success: function(events) {
                                        data = JSON.parse(events);
                                        t6.clear().draw();
                                        t6.rows.add(data); // Add new data
                                        t6.columns.adjust().draw(); // Redraw the DataTable
                                        //$('#disp-patient-calendar').fullCalendar('renderEvents');
                                    }
                                });
                            },
                            error: function(response) {
                                alert("some problem happened, please try again");
                            }
                        });
                    }
                }
            });

            t7 = $('#dtpres').DataTable({
                "lengthChange": false,
                "bInfo": false,

                "iDisplayLength": 5
            });
            $('#dtpres tbody').on('mousedown', 'tr', function(ev) {
                var cell = t7.row(this);
                console.log(cell)
                var r = cell.data();
                if (ev.which == 3) {

                    if (confirm("are you sure you want to delete this medicine?!")) {
                        var data = {
                            "x1": r[0],
                            "x2": r[1],
                            "x3": r[2],
                            "x4": r[3]
                        };
                        var dataString = JSON.stringify(data);
                        $.ajax({
                            url: 'del-pres.php',
                            data: {
                                myData: dataString
                            },
                            type: 'POST',
                            success: function(res) {
                                $.ajax({
                                    url: "pres.php",
                                    type: "POST",
                                    data: {
                                        vid: $('#vid').val()
                                    },
                                    success: function(events) {
                                        data = JSON.parse(events);
                                        t7.clear().draw();
                                        t7.rows.add(data); // Add new data
                                        t7.columns.adjust().draw(); // Redraw the DataTable
                                        //$('#disp-patient-calendar').fullCalendar('renderEvents');
                                    }
                                });
                            },
                            error: function(response) {
                                alert("some problem happened, please try again");
                            }
                        });
                    }
                }
            });

            $('.dataTable').on('click', 'tbody tr', function() {
                if (t1.row(this).data()) {
                    p = t1.row(this).data()[0];
                }
                if (t2.row(this).data()) {
                    d = t2.row(this).data()[0];
                }
                if (t3.row(this).data()) {
                    pid = t3.row(this).data()[0];
                    document.getElementById("disp-patient-calendar").style.display = "block";
                    document.getElementById("pt").style.display = "none";
                    document.getElementById("vv").style.display = "block";
                    $.ajax({
                        url: "load-patient-dentist.php",
                        type: "POST",
                        data: {
                            pid: t3.row(this).data()[0],
                            did: did
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            console.log(events)
                            $('#disp-patient-calendar').fullCalendar('addEventSource', data);
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });



                }
                if (did) {

                    document.getElementById("disp-dentist-calendar").style.display = "block";
                    document.getElementById("dt").style.display = "none";
                    document.getElementById("cc").style.display = "block";
                    $.ajax({
                        url: "load-dentist.php",
                        type: "POST",
                        data: {
                            did: did
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            console.log(events)
                            $('#disp-dentist-calendar').fullCalendar('addEventSource', data);
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });



                }
            });
            $('#addModal').on('hidden.bs.modal', function() {
                $('[href="#pi"]').tab('show');
                document.getElementById("date").value = "";
                document.getElementById("start").value = "";
                document.getElementById("end").value = "";
                document.getElementById("payment").value = "";
                document.getElementById("Comment").value = "";
                p = -1;
                t1.rows('.selected').nodes().to$().removeClass('selected');
                t2.rows('.selected').nodes().to$().removeClass('selected');

            })
            $('#pModal').on('hidden.bs.modal', function() {
                document.getElementById("disp-patient-calendar").style.display = "none";
                document.getElementById("pt").style.display = "block";
                $('#disp-patient-calendar').fullCalendar('removeEventSources');
                pid = -1;
            });
            $('#dModal').on('hidden.bs.modal', function() {
                document.getElementById("disp-dentist-calendar").style.display = "none";
                document.getElementById("dt").style.display = "block";
                $('#disp-dentist-calendar').fullCalendar('removeEventSources');
            });
            $('#editModal').on('hidden.bs.modal', function() {
                $('[href="#piz"]').tab('show');
                document.getElementById("Edate").disabled = false;
                document.getElementById("Estart").disabled = false;
                document.getElementById("Eend").disabled = false;
                document.getElementById("EComment").disabled = false;
                document.getElementById('se').style.display = 'block';
                document.getElementById('pres').style.display = 'none';
                document.getElementById('surg').style.display = 'none';
                document.getElementById('diag').style.display = 'none';
                document.getElementById('pres3').style.display = 'none';
                document.getElementById('attendance').style.display = 'none';
            });

        });

        function clearDiag() {
            $.ajax({
                url: "cleard.php",
                type: "POST",
                data: {
                    vid: $('#vid').val()
                },
                success: function() {
                    $.ajax({
                        url: "diag.php",
                        type: "POST",
                        data: {
                            vid: $('#vid').val()
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t5.clear().draw();
                            t5.rows.add(data); // Add new data
                            t5.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                }
            });
        }

        function clearSur() {
            $.ajax({
                url: "clears.php",
                type: "POST",
                data: {
                    vid: $('#vid').val()
                },
                success: function() {
                    $.ajax({
                        url: "sur.php",
                        type: "POST",
                        data: {
                            vid: $('#vid').val()
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t6.clear().draw();
                            t6.rows.add(data); // Add new data
                            t6.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                }
            });
        }

        function clearPres() {
            $.ajax({
                url: "clearp.php",
                type: "POST",
                data: {
                    vid: $('#vid').val()
                },
                success: function() {
                    $.ajax({
                        url: "pres.php",
                        type: "POST",
                        data: {
                            vid: $('#vid').val()
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t7.clear().draw();
                            t7.rows.add(data); // Add new data
                            t7.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                }
            });
        }

        function payrep() {
            $("#payrep").html(`<tr>
        <th>item</th>
        <th>price</th> 
    </tr>`);

            $("#payrep").append("<tr>");
            $("#payrep").append("<td>Entry fees</td>");
            $("#payrep").append("<td>" + $('#ent').val() + "</td>");

            $("#payrep").append("</tr>");
            t6.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                $("#payrep").append("<tr><td>" + data[1] + " @ tooth: " + data[0] + "</td> <td>" + data[2] + "</td></tr>");
            });
            printJS('payrep', 'html');
        }

        function loadPres() {
            $("#prpes").html("");
            console.log('xxx');
            $("#prpes").append("<h4>prescription: </h4>" + "</br>");

            t7.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                $("#prpes").append("prescriped: " + data[0] + " concentration: " + data[1] + " dosage: " + data[2] + "</br>");
            });

        }

        function loadReport() {
            $("#visr").html("");
            $("#diar").html("");
            $("#manr").html("");
            $("#prer").html("");

            $("#visr").append("<h4>Patient data: </h4>");
            $("#visr").append("Name: " + " " + $('#pp1x').val() + "</br>");
            $("#visr").append("Phone: " + " " + $('#pp2x').val() + "</br>");
            $("#visr").append("Sex: " + " " + $('#pp4x').val() + "</br>");
            $("#visr").append("Birthdate: " + " " + $('#pp5x').val() + "</br>");
            $("#visr").append("Address: " + " " + $('#pp6x').val() + "</br>");
            $("#visr").append("Nationality: " + " " + $('#pp7x').val() + "</br>");

            $("#visr").append("</br>" + "<h4>Visit date: </h4>");
            $("#visr").append($('#Edate').val() + " " + $('#Estart').val() + "</br>");

            $("#diar").append("</br>" + "<h4>Diagnosis: </h4>");
            t5.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                $("#diar").append(data[1] + " at tooth: " + data[0] + "</br>");
            });
            $("#manr").append("</br>" + "<h4>Management: </h4>");
            t6.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                $("#manr").append(data[1] + " at tooth: " + data[0] + "</br>");
            });
            $("#prer").append("</br>" + "<h4>Prescription: </h4>");
            t7.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                $("#prer").append(data[0] + " " + data[1] + "mg " + data[2] + "</br>");
            });
        }

        function loadAttendance() {
            $("#aname").val($('#pp1x').val());
            $('#aname').change();

            $("#astart").val($('#Estart').val());
            $('#astart').change();

            $("#aend").val(moment().format("HH:mm"));
            $('#aend').change();

            $("#asex").val($('#pp4x').val())
            $('#asex').change();

        }

        function loadSickLeave() {
            $("#slname").val($('#pp1x').val());
            $('#slname').change();

            // $("#slstart").val($('#Estart').val());
            // $('#slstart').change();

            $("#slsex").val($('#pp4x').val())
            $('#slsex').change();

            $('#slstart').val(moment().format("DD-MM-YYYY"))
            $('#slstart').change();
        }

        function updateSickleaveDuration() {
            const duration = $('#sld').val();
            if (duration.length > 0) {
                $('#sl4').html(duration);

                const date = moment($('#slstart').val(), "DD-MM-YYYY");
                date.add(duration - 1, 'day');

                $('#slend').val(date.format("DD-MM-YYYY"));
                $('#slend').change();
            }
        }

        function addDiag() {
            var t = $('#tooth').val();
            var d = $('#dia').val();
            var c = $('#dComment').val();
            if (t == "" && d == "" && c == "") return;
            if (dd.includes(t)) {
                $('#toto1').append('<option value="' + t + '">');
                $('#toto2').append('<option value="' + t + '">');
            }
            if (bb.includes(d))
                $('#diadia').append('<option value="' + d + '">');
            var data = {

                "t": t,
                "d": d,
                "c": c,
                "v": document.getElementById("vid").value
            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-diag.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(response) {
                    document.getElementById("tooth").value = "";
                    document.getElementById("dia").value = "";
                    document.getElementById("dComment").value = "";
                    t5.row.add([
                        t,
                        d,
                        c
                    ]).draw(false);
                    $.ajax({
                        url: "pay.php",
                        type: "POST",
                        data: {
                            vid: document.getElementById("vid").value
                        },
                        success: function(res) {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    $.ajax({
                        url: "done.php",
                        type: "POST",
                        data: {
                            vid: document.getElementById("vid").value
                        }

                    });
                    $.ajax({
                        url: "done.php",
                        type: "POST",
                        data: {
                            vid: document.getElementById("vid").value
                        },
                        success: function(response) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modal-calendar').fullCalendar('refetchEvents');
                        }
                    });
                },
                error: function(response) {
                    alert("some problem happened, please try again");
                }
            });

        }

        function addSur() {
            var t = $('#stooth').val();
            var d = $('#sur').val();
            var p = $('#sprice').val();
            var c = $('#sComment').val();
            if (t == "" && d == "" && c == "" && p == "") return;
            if (dd.includes(t)) {
                $('#toto1').append('<option value="' + t + '">');
                $('#toto2').append('<option value="' + t + '">');
            }
            if (cc.includes(d))
                $('#sursur').append('<option value="' + d + '">');

            var data = {

                "t": t,
                "d": d,
                "p": p,
                "c": c,
                "v": document.getElementById("vid").value
            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-sur.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(response) {
                    document.getElementById("stooth").value = "";
                    document.getElementById("sur").value = "";
                    document.getElementById("sprice").value = "";
                    document.getElementById("sComment").value = "";
                    t6.row.add([
                        t,
                        d,
                        p,
                        c
                    ]).draw(false);
                    $.ajax({
                        url: "pay.php",
                        type: "POST",
                        data: {
                            vid: document.getElementById("vid").value
                        },
                        success: function(res) {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    $.ajax({
                        url: "done.php",
                        type: "POST",
                        data: {
                            vid: document.getElementById("vid").value
                        },
                        success: function(response) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modal-calendar').fullCalendar('refetchEvents');
                        }
                    });
                },
                error: function(response) {
                    alert("some problem happened, please try again");
                }
            });

        }

        function addPres() {
            var t = $('#med').val();
            var d = $('#mg').val();
            var p = $('#dose').val();
            var c = $('#pComment').val();
            if (t == "" && d == "" && c == "" && p == "") return;
            if (aa.includes(t))
                $('#medmed').append('<option value="' + t + '">');

            var data = {

                "t": t,
                "d": d,
                "p": p,
                "c": c,
                "v": document.getElementById("vid").value
            };
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-pres.php',
                data: {
                    myData: dataString
                },
                type: 'POST',
                success: function(response) {
                    document.getElementById("med").value = "";
                    document.getElementById("mg").value = "";
                    document.getElementById("dose").value = "";
                    document.getElementById("pComment").value = "";
                    t7.row.add([
                        t,
                        d,
                        p,
                        c
                    ]).draw(false);
                    $.ajax({
                        url: "done.php",
                        type: "POST",
                        data: {
                            vid: document.getElementById("vid").value
                        },
                        success: function(response) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modal-calendar').fullCalendar('refetchEvents');
                        }
                    });

                },
                error: function(response) {
                    alert("some problem happened, please try again");
                }
            });
            loadPres();

        }
        $(function() {

            $('#disp-dentist-calendar').fullCalendar({
                themeSystem: 'standard',
                eventLimit: true,
                //defaultView: 'agendaDay',


                //aspectRatio: 5,
                header: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'month,list'
                },
                businessHours: [ // specify an array instead
                    {
                        dow: [0, 1, 2, 3, 6], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [4, 5], // Thursday, Friday
                        start: '10:00', // 10am
                        end: '16:00' // 4pm
                    }
                ],
                dayClick: function(date) {
                    //alert('clicked ' + date.format());
                    //$("#myModal").modal("show");
                    //$('#calendar').fullCalendar('changeView', 'agendaDay');
                    //$('#calendar').fullCalendar('gotoDate',date);
                },
                eventClick: function(event) {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("visd").value = event.id;
                    document.getElementById("ent").value = event.payment;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month() + 1) < 10 ? '0' + (event.start.month() + 1) : (event.start.month() + 1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour()) < 10 ? '0' + (event.start.hour()) : (event.start.hour())) + ":" + ((event.start.minute()) < 10 ? '0' + (event.start.minute()) : (event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour()) < 10 ? '0' + (event.end.hour()) : (event.end.hour())) + ":" + ((event.end.minute()) < 10 ? '0' + (event.end.minute()) : (event.end.minute()));

                    document.getElementById("EComment").value = event.comment;
                    $.ajax({
                        url: "one-patient.php",
                        type: "POST",
                        data: {
                            pid: event.pid
                        },
                        success: function(resp) {
                            res = JSON.parse(resp);
                            document.getElementById("pp1x").value = res[0];
                            document.getElementById("pp2x").value = res[1];
                            document.getElementById("pp3x").value = res[2];
                            document.getElementById("pp4x").value = res[3];
                            document.getElementById("pp5x").value = res[4];
                            document.getElementById("pp6x").value = res[5];
                            document.getElementById("pp7x").value = res[6];
                            document.getElementById("pp8x").value = res[7];
                        }
                    });
                    $.ajax({
                        url: "pay.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(res) {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if (event.done != 0) {
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;

                    }
                    //to-do
                    $.ajax({
                        url: "diag.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t5.clear().draw();
                            t5.rows.add(data); // Add new data
                            t5.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "sur.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t6.clear().draw();
                            t6.rows.add(data); // Add new data
                            t6.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "pres.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t7.clear().draw();
                            t7.rows.add(data); // Add new data
                            t7.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });

                },
                select: function(startDate, endDate) {
                    //alert('selected ' + startDate.format() + ' to ' + endDate.format());
                },
                eventRender: function(event, element) {
                    element.css('background-color', coloring(event));
                },
                customButtons: {

                }
            });



            $('#disp-patient-calendar').fullCalendar({
                themeSystem: 'standard',
                eventLimit: true,
                //defaultView: 'agendaDay',


                //aspectRatio: 5,
                header: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'month,list'
                },
                businessHours: [ // specify an array instead
                    {
                        dow: [0, 1, 2, 3, 6], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [4, 5], // Thursday, Friday
                        start: '10:00', // 10am
                        end: '16:00' // 4pm
                    }
                ],
                dayClick: function(date) {
                    //alert('clicked ' + date.format());
                    //$("#myModal").modal("show");
                    //$('#calendar').fullCalendar('changeView', 'agendaDay');
                    //$('#calendar').fullCalendar('gotoDate',date);
                },
                eventClick: function(event) {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("ent").value = event.payment;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month() + 1) < 10 ? '0' + (event.start.month() + 1) : (event.start.month() + 1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour()) < 10 ? '0' + (event.start.hour()) : (event.start.hour())) + ":" + ((event.start.minute()) < 10 ? '0' + (event.start.minute()) : (event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour()) < 10 ? '0' + (event.end.hour()) : (event.end.hour())) + ":" + ((event.end.minute()) < 10 ? '0' + (event.end.minute()) : (event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    $.ajax({
                        url: "one-patient.php",
                        type: "POST",
                        data: {
                            pid: event.pid
                        },
                        success: function(resp) {
                            res = JSON.parse(resp);
                            document.getElementById("pp1x").value = res[0];
                            document.getElementById("pp2x").value = res[1];
                            document.getElementById("pp3x").value = res[2];
                            document.getElementById("pp4x").value = res[3];
                            document.getElementById("pp5x").value = res[4];
                            document.getElementById("pp6x").value = res[5];
                            document.getElementById("pp7x").value = res[6];
                            document.getElementById("pp8x").value = res[7];
                        }
                    });
                    $.ajax({
                        url: "pay.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(res) {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if (event.done != 0) {
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;

                    }
                    $.ajax({
                        url: "diag.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t5.clear().draw();
                            t5.rows.add(data); // Add new data
                            t5.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "sur.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t6.clear().draw();
                            t6.rows.add(data); // Add new data
                            t6.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "pres.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t7.clear().draw();
                            t7.rows.add(data); // Add new data
                            t7.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                },
                select: function(startDate, endDate) {
                    //alert('selected ' + startDate.format() + ' to ' + endDate.format());
                },
                eventRender: function(event, element) {
                    element.css('background-color', coloring(event));
                },
                customButtons: {

                }
            });


            $('#modal-calendar').fullCalendar({
                themeSystem: 'standard',
                eventLimit: true,
                //defaultView: 'agendaDay',

                events: {
                    url: 'load-dentist.php',
                    type: 'POST',
                    data: {
                        did: <?php echo $_SESSION['id'] ?>
                    },
                    error: function() {
                        console.log('there was an error while fetching events!');
                    }
                },
                //aspectRatio: 5,
                header: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'addEventButton'
                },
                businessHours: [ // specify an array instead
                    {
                        dow: [0, 1, 2, 3, 6], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [4, 5], // Thursday, Friday
                        start: '10:00', // 10am
                        end: '16:00' // 4pm
                    }
                ],
                dayClick: function(date) {
                    //alert('clicked ' + date.format());
                    //$("#myModal").modal("show");
                    //$('#calendar').fullCalendar('changeView', 'agendaDay');
                    //$('#calendar').fullCalendar('gotoDate',date);
                },
                eventClick: function(event) {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("ent").value = event.payment;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month() + 1) < 10 ? '0' + (event.start.month() + 1) : (event.start.month() + 1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour()) < 10 ? '0' + (event.start.hour()) : (event.start.hour())) + ":" + ((event.start.minute()) < 10 ? '0' + (event.start.minute()) : (event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour()) < 10 ? '0' + (event.end.hour()) : (event.end.hour())) + ":" + ((event.end.minute()) < 10 ? '0' + (event.end.minute()) : (event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    $.ajax({
                        url: "one-patient.php",
                        type: "POST",
                        data: {
                            pid: event.pid
                        },
                        success: function(resp) {
                            res = JSON.parse(resp);
                            document.getElementById("pp1x").value = res[0][1];
                            document.getElementById("pp2x").value = res[0][2];
                            document.getElementById("pp3x").value = res[0][3];
                            document.getElementById("pp4x").value = res[0][4];
                            document.getElementById("pp5x").value = res[0][5];
                            document.getElementById("pp6x").value = res[0][6];
                            document.getElementById("pp7x").value = res[0][7];
                            document.getElementById("pp8x").value = res[0][3];
                        }
                    });
                    $.ajax({
                        url: "pay.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(res) {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if (event.done != 0) {
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;

                    }
                    $.ajax({
                        url: "diag.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t5.clear().draw();
                            t5.rows.add(data); // Add new data
                            t5.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "sur.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t6.clear().draw();
                            t6.rows.add(data); // Add new data
                            t6.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "pres.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t7.clear().draw();
                            t7.rows.add(data); // Add new data
                            t7.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                },
                eventRender: function(event, element) {
                    element.css('background-color', coloring(event));
                },
                select: function(startDate, endDate) {
                    //alert('selected ' + startDate.format() + ' to ' + endDate.format());
                },
                customButtons: {
                    addEventButton: {
                        text: 'New Visit...',
                        click: function() {
                            $("#addModal").modal("show");

                        }
                    }
                }
            });


            $('#calendar').fullCalendar({
                themeSystem: 'standard',
                eventLimit: true,
                //defaultView: 'agendaDay',

                events: {
                    url: 'load-dentist.php',
                    type: 'POST',
                    data: {
                        did: <?php echo $_SESSION['id'] ?>
                    },
                    error: function() {
                        console.log('there was an error while fetching events!');
                    }
                },
                //aspectRatio: 5,
                height: $(window).height() * 0.96,
                header: {
                    left: 'prev,next,today addEventButton patients,dentists',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth logout'
                },
                selectable: true,
                selectHelper: true,
                weekNumbers: true,
                eventLimit: true, // allow "more" link when too many events
                businessHours: [ // specify an array instead
                    {
                        dow: [0, 1, 2, 3, 6], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [4, 5], // Thursday, Friday
                        start: '10:00', // 10am
                        end: '16:00' // 4pm
                    }
                ],
                dayClick: function(date) {
                    //alert('clicked ' + date.format());
                    $("#myModal").modal("show");
                    setTimeout(() => {
                        $('#modal-calendar').fullCalendar('changeView', 'agendaDay');
                        $('#modal-calendar').fullCalendar('gotoDate', date);
                    }, 150);

                },
                eventClick: function(event) {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("ent").value = event.payment;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month() + 1) < 10 ? '0' + (event.start.month() + 1) : (event.start.month() + 1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour()) < 10 ? '0' + (event.start.hour()) : (event.start.hour())) + ":" + ((event.start.minute()) < 10 ? '0' + (event.start.minute()) : (event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour()) < 10 ? '0' + (event.end.hour()) : (event.end.hour())) + ":" + ((event.end.minute()) < 10 ? '0' + (event.end.minute()) : (event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    console.log(event.pid)
                    $.ajax({
                        url: "one-patient.php",
                        type: "POST",
                        data: {
                            pid: event.pid
                        },
                        success: function(resp) {

                            res = JSON.parse(resp);
                            console.log(res)
                            document.getElementById("pp1x").value = res[0][1];
                            document.getElementById("pp2x").value = res[0][2];
                            document.getElementById("pp3x").value = res[0][3];
                            document.getElementById("pp4x").value = res[0][4];
                            document.getElementById("pp5x").value = res[0][5];
                            document.getElementById("pp6x").value = res[0][6];
                            document.getElementById("pp7x").value = res[0][7];
                            document.getElementById("pp8x").value = res[0][3];
                        }
                    });
                    $.ajax({
                        url: "pay.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(res) {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if (event.done != 0) {
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;

                    }
                    $.ajax({
                        url: "diag.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t5.clear().draw();
                            t5.rows.add(data); // Add new data
                            t5.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');

                        }
                    });
                    $.ajax({
                        url: "sur.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t6.clear().draw();
                            t6.rows.add(data); // Add new data
                            t6.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                    $.ajax({
                        url: "pres.php",
                        type: "POST",
                        data: {
                            vid: event.id
                        },
                        success: function(events) {
                            data = JSON.parse(events);
                            t7.clear().draw();
                            t7.rows.add(data); // Add new data
                            t7.columns.adjust().draw(); // Redraw the DataTable
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });
                },
                eventRender: function(event, element) {
                    element.css('background-color', coloring(event));
                },
                customButtons: {
                    addEventButton: {
                        text: 'New Visit...',
                        click: function() {
                            $("#addModal").modal("show");

                        }
                    },
                    logout: {
                        text: 'logout',
                        click: function() {
                            window.location.replace("logout.php");

                        }
                    },
                    patients: {
                        text: 'patients...',
                        click: function() {
                            $("#pModal").modal("show");

                        }
                    }
                }
            });

        });
        setInterval(function() {
            $('#calendar').fullCalendar('refetchEvents');
            $('#modal-calendar').fullCalendar('refetchEvents');

        }, 5000);
    </script>
</body>

</html>