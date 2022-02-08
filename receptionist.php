<?php
//index.php
session_start();
if(isset($_SESSION['type']) && $_SESSION['hidden'] === '0'){
    if($_SESSION['type'] != 2) {

        echo "Unauthorized access!!";
        if($_SESSION['type'] === 1){
            $url = 'admin.php';
        }
        if($_SESSION['type'] === 3){
            $url = 'dentist.php';
        }
        header('Location: ' . $url);
    }
    
}else {
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
    <link rel="stylesheet" type="text/css" href="public/datatable/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="public/datatable/select.dataTables.min.css"/>
    <script type="text/javascript" src="public/datatable/datatables.min.js"></script>
    <script type="text/javascript" src="public/datatable/dataTables.select.min.js"></script>
    <script>
    $( function() {
        $( ".date" ).datepicker({ dateFormat: 'dd-mm-yy' });
    } );
    </script>

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
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content" style="  height: auto; min-height: 90%;">
            <div class="modal-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#pi" aria-controls="pi" role="tab" data-toggle="tab">Choose patient and dentist</a>

                        </li>
                        <li role="presentation"><a href="#vi" aria-controls="vi" role="tab" data-toggle="tab">Visit date</a>

                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="pi">
                            <div class="container">
                            
                                    <div class="row">
                                        <div class="col-xs-6" style="width:60%">
                                            <h4>Choose patient...</h4>
                                            <div>
                                                <button type="button" id="new-ext" class="btn btn-primary save" style="width:100%" onclick="altt()">New patient</button>
                                            </div>
                                            <div id="add-new-patient" style="display:none">


<div class="container" style="margin-left: -15px">
<div class="row">
<div class="col-xs-3">

                                                <label for="new-patient-name"><b>Name</b></label>
                                                <input type="text" placeholder="Name" name="new-patient-name"id="new-patient-name" class="form-control" style="margin-bottom: 20px">
                                                </div><div class="col-xs-3">
                                                <label for="new-patient-ssn"><b>Phone</b></label>
                                                <input type="text" placeholder="Phone" name="new-patient-ssn"id="new-patient-ssn" class="form-control" style="margin-bottom: 20px">
                                                
                                                </div></div></div>
                                                <div style="display: none">
                                                    <label for="new-phone"><b>Phone</b></label>
                                                    <input type="number" placeholder="Phone" name="new-phone"id="new-phone" class="form-control" style="margin-bottom: 20px">
                                                </div>

<div class="container" style="margin-left: -15px">
<div class="row">
<div class="col-xs-3">
                                                <label for="sex"><b>Sex</b></label>
                                                <select type="text" placeholder="sex" name="sex"id="sex" class="form-control" style="margin-bottom: 20px">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>

                                                </select>
                                                </div><div class="col-xs-3">
                                                <label for="bd"><b>Birthdate</b></label>
                                                <input type="text" placeholder="bd" name="bd"id="bd" class="date form-control" style="margin-bottom: 20px">
                                                </div></div></div>
                                                
                                                <label for="address"><b>Address</b></label>
                                                <input type="text" placeholder="address" name="address"id="address" class="form-control" style="margin-bottom: 20px">
                                                
                                                <div class="container" style="margin-left: -15px">
<div class="row">
<div class="col-xs-3">
                                                
                                                <label for="nation"><b>Nationality</b></label>
                                                <input type="text" placeholder="nationality" name="nation"id="nation" class="form-control" style="margin-bottom: 20px">



</div><div class="col-xs-3">





                                                <label for="new-comment"><b>Comment</b></label>
                                                <input type="text" placeholder="Comment" name="new-comment"id="new-comment" class="form-control" style="margin-bottom: 20px">
                                                </div></div></div>
                                                
                                                
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
                                    <div class="col-xs-4 pull-right" style="margin-top:32px;width:35%">
                                        <h4>Choose dentist...</h4>
                                        <table id="dentists" class="display" style="width:100%">
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
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vi">
                            <label for="date"><b>date</b></label>
                            <input type="text" placeholder="date" name="date"id="date" class="date form-control" style="margin-bottom: 20px">
                            <label for="start"><b>start</b></label>
                            <input type="time" placeholder="start" name="start"id="start" class="form-control" style="margin-bottom: 20px">
                            <div style="display: none">
                            <label for="end"><b>end</b></label>
                            <input type="time" placeholder="end" name="end"id="end" class="form-control" style="margin-bottom: 20px">
                            </div>
                            <label for="Comment"><b>Comment</b></label>
                            <input type="text" placeholder="Comment" name="Comment"id="Comment" class="form-control" style="margin-bottom: 20px">
                        </div>
                    </div>
                </div>
                <label for="payment"><b>Entry fees</b></label>
                <input type="number" placeholder="payment" name="payment"id="payment" class="form-control" style="margin-bottom: 20px; width:100%" >

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
                <button type="button" class="btn btn-default"  onclick="patientList()" id = "vv" style="display: none">Back</button>
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
                        <div class="modal-footer" id = "cc" style="display: none">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-default"  onclick="dentistList()"id = "cc" style="display: none">Back</button>
            </div>    
           
        </div>
    </div>
</div>




<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
                
                        <div >
                            <div style="display: none">
                            <label for="vid"><b>Visit ID</b></label>
                            <input type="number" placeholder="vid" name="vid"id="vid" class="form-control" style="margin-bottom: 20px" disabled>
                            </div>
                            <label for="date"><b>date</b></label>
                            <input type="text" placeholder="date" name="Edate"id="Edate" class="date form-control" style="margin-bottom: 20px">
                            <label for="start"><b>start</b></label>
                            <input type="time" placeholder="start" name="Estart"id="Estart" class="form-control" style="margin-bottom: 20px">
                            <div style="display:none">
                            <label for="end"><b>end</b></label>
                            <input type="time" placeholder="end" name="Eend"id="Eend" class="form-control" style="margin-bottom: 20px">
                            </div>
                            <div class="container">
                            <div class="row">
                            <div class="col-xs-3">
                            <label for="payment"><b>payment</b></label>
                            <input type="number" placeholder="payment" name="Epayment"id="Epayment" class="form-control" style="margin-bottom: 20px" disabled>
                            </div><div class="col-xs-3">
                            <label for="ent"><b>entry</b></label>
                            <input type="number" placeholder="ent" name="ent"id="ent" class="form-control" style="margin-bottom: 20px">
                            </div></div></div>
                            <label for="Comment"><b>Comment</b></label>
                            <input type="text" placeholder="Comment" name="EComment"id="EComment" class="form-control" style="margin-bottom: 20px">
                        </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save" onclick="delEdit()">Delete Visit</button>
                <button type="button" class="btn btn-primary save" onclick="saveEdit()">Save Visit</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="pp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
                
                        <div >
                        <div class="container" style="margin-left: -15px">
<div class="row">
<div class="col-xs-3">

                                                <label for="pp1"><b>Name</b></label>
                                                <input type="text" placeholder="Name" name="pp1"id="pp1" class="form-control" style="margin-bottom: 20px">
                                                </div><div class="col-xs-3">
                                                <label for="pp2"><b>Phone</b></label>
                                                <input type="text" placeholder="Phone" name="pp2"id="pp2" class="form-control" style="margin-bottom: 20px">
                                                
                                                </div></div></div>
                                                <div style="display: none">
                                                    <label for="pp3"><b>Phone</b></label>
                                                    <input type="text" placeholder="Phone" name="pp3"id="pp3" class="form-control" style="margin-bottom: 20px">
                                                </div>

<div class="container" style="margin-left: -15px">
<div class="row">
<div class="col-xs-3">
                                                <label for="pp4"><b>Sex</b></label>
                                                <select type="text" placeholder="sex" name="pp4"id="pp4" class="form-control" style="margin-bottom: 20px">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>

                                                </select>
                                                </div><div class="col-xs-3">
                                                <label for="pp5"><b>Birthdate</b></label>
                                                <input type="text" placeholder="bd" name="pp5"id="pp5" class="date form-control" style="margin-bottom: 20px">
                                                </div></div></div>
                                                
                                                <label for="pp6"><b>Address</b></label>
                                                <input type="text" placeholder="address" name="pp6"id="pp6" class="form-control" style="margin-bottom: 20px">
                                                
                                                <div class="container" style="margin-left: -15px">
<div class="row">
<div class="col-xs-3">
                                                
                                                <label for="pp7"><b>Nationality</b></label>
                                                <input type="text" placeholder="nationality" name="pp7"id="pp7" class="form-control" style="margin-bottom: 20px">



</div><div class="col-xs-3">





                                                <label for="pp8"><b>Comment</b></label>
                                                <input type="text" placeholder="Comment" name="pp8"id="pp8" class="form-control" style="margin-bottom: 20px">
                                                </div></div></div>

                        </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save" onclick="pp()">Save</button>
            </div>
        </div>
    </div>
</div>


    <script>
        window.onbeforeunload = confirmExit;
        function confirmExit() {
            return "You have attempted to leave this page. Are you sure?";
        }
        var p = -1;
        var pid = -1;
        var did = -1;
        var d = -1;

        function altt(){
            if(document.getElementById("add-new-patient").style.display === "none"){
                document.getElementById("add-new-patient").style.display = "block";
                document.getElementById("patientss").style.display = "none";
                document.getElementById("new-ext").innerHTML = "Existing patient";
            }else{
                document.getElementById("add-new-patient").style.display = "none";
                document.getElementById("patientss").style.display = "block";
                document.getElementById("new-ext").innerHTML = "New patient";
            }
        }
        function savePatient(){
            var name = document.getElementById("new-patient-name").value;
            var ssn = document.getElementById("new-patient-ssn").value;
            var phone = document.getElementById("new-phone").value;
            var comment = document.getElementById("new-comment").value;
            var sex = $('#sex').val();
            var bdate = $('#bd').val();
            var address = $('#address').val();
            var nationality = $('#nation').val();
            if(name === ""){
                alert("name field is empty");
                return;

            }
            if(ssn === ""){
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
            console.log(data);
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-patient.php',
                data: {myData: dataString},
                type: 'POST',
                success: function(response) {
                    var tle = $('#patients').DataTable();
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
                error: function(response){
                    alert("some problem happened, please try again");
                }
            });
        }

        function pp(){
            var id = $("#pp3").val();
            var name = $("#pp1").val();
            var phone = $("#pp2").val();
            var sex = $("#pp4").val();
            var bdate = $("#pp5").val();
            var address = $("#pp6").val();
            var nation = $("#pp7").val();
            var comment = $("#pp8").val();
            var data = {
                "id": id,
                "name": name,
                "phone": phone,
                "sex": sex,
                "bdate": bdate,
                "address": address,
                "nation": nation,
                "comment": comment
            };
            console.log(data);
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'edit-patient.php',
                data: {myData: dataString},
                type: 'POST',
                success: function(response) {
                    var tle = $('#patients').DataTable();
                    tle.ajax.reload();
                    $("#pp").modal("hide");
                },
                error: function(response){
                    alert("some problem happened, please try again");
                }
            });
        }

        function coloring(event){ 
            var dt = moment(new Date());
            if(event.end == null)console.log(event)
            if(event.done === 0 && moment(event.start._i).isBefore(dt) && moment(event.end._i).isAfter(dt)){
                return "orange";
            }
            if(event.done === 0 && moment(event.start._i).isBefore(dt) && moment(event.end._i).isBefore(dt)){
                
                return "red";
            }
            if(event.done === 0 && moment(event.start._i).isAfter(dt) && moment(event.end._i).isAfter(dt)){
                return "blue";
            }
            return "black"
        }
        function patientList(){
            document.getElementById("disp-patient-calendar").style.display = "none";
            document.getElementById("pt").style.display = "block";
            document.getElementById("vv").style.display = "none";
            $('#disp-patient-calendar').fullCalendar('removeEventSources');
        }
        function dentistList(){
            document.getElementById("disp-dentist-calendar").style.display = "none";
            document.getElementById("dt").style.display = "block";
            document.getElementById("cc").style.display = "none";
            $('#disp-dentist-calendar').fullCalendar('removeEventSources');
        }
        function save(){
            var date1 = document.getElementById("date").value;
            var start1 = document.getElementById("start").value;
            var end1 = document.getElementById("end").value;
            var payment1 = document.getElementById("payment").value;
            var comment1 = document.getElementById("Comment").value;
            if(date1 == ""){
                date1 = moment().format("YYYY-MM-DD");
                
            }else console.log(date1);
            if(start1 == ""){
                start1=moment().format('HH:mm');
                console.log(moment().format('HH:mm'))
                
            }
            end1="23:59:59";
            if(payment1 == ""){
                payment1 = 0;
            }
            if(d == -1){
                alert("select dentist first!!");
                return;
            }
            if(p == -1){
                var name = document.getElementById("new-patient-name").value;
                var ssn = document.getElementById("new-patient-ssn").value;
                var phone = document.getElementById("new-phone").value;
                var comment = document.getElementById("new-comment").value;
                var sex = $('#sex').val();
                var bdate = $('#bd').val();
                var address = $('#address').val();
                var nationality = $('#nation').val();
                if(name === ""){
                    alert("Patient name is a mandatory!!");
                    return;

                }
                if(ssn === ""){
                    alert('Patient phone is a mandatory!!');
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
                console.log(data);
                var dataString = JSON.stringify(data);
                $.ajax({
                    url: 'add-patient.php',
                    data: {myData: dataString},
                    type: 'POST',
                    success: function(response) {
                        var tle = $('#patients').DataTable();
                        tle.ajax.reload();
                        tle.page('last').draw('page');
                        document.getElementById("new-patient-name").value = "";
                        document.getElementById("new-patient-ssn").value = "";
                        document.getElementById("new-phone").value = "";
                        document.getElementById("new-comment").value = "";
                        $('#sex').val("");
                        $('#bd').val("");
                        $('#address').val("");
                        $('#nation').val("");
                        console.log("p");
                        p = response;
                        var data = {
                            "patientId": p,
                            "dentistId": d,
                            "start": date1 + " " + start1,
                            "end": date1 + " " + end1,
                            "payment": payment1, 
                            "Comment": comment1
                        };
                        console.log(data)
                        var dataString = JSON.stringify(data);
                        $.ajax({
                            url: 'add-visit.php',
                            data: {myData: dataString},
                            type: 'POST',
                            success: function(response) {
                                $('#calendar').fullCalendar('refetchEvents');
                                $('#modal-calendar').fullCalendar('refetchEvents');
                                $('[href="#pi"]').tab('show');
                                document.getElementById("date").value = "";
                                document.getElementById("start").value = "";
                                document.getElementById("end").value = "";
                                document.getElementById("payment").value = "";
                                document.getElementById("Comment").value = "";
                                p = -1;
                                d = -1;
                                t1.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
                                t2.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
                                $("#addModal").modal("hide");
                                return;
                            }
                        });
                        

                    },
                    error: function(response){
                        alert("some problem happened, please try again");
                        return;
                    }
                });
                
                
                
            }
            if(d == -1){
                alert("select dentist first!!");
                return;
            }
            console.log("p");
            console.log(p);

            var data = {
                "patientId": p,
                "dentistId": d,
                "start": date1 + " " + start1,
                "end": date1 + " " + end1,
                "payment": payment1, 
                "Comment": comment1
            };
            console.log(data)
            var dataString = JSON.stringify(data);
            $.ajax({
                url: 'add-visit.php',
                data: {myData: dataString},
                type: 'POST',
                success: function(response) {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#modal-calendar').fullCalendar('refetchEvents');
                    $('[href="#pi"]').tab('show');
                    document.getElementById("date").value = "";
                    document.getElementById("start").value = "";
                    document.getElementById("end").value = "";
                    document.getElementById("payment").value = "";
                    document.getElementById("Comment").value = "";
                    p = -1;
                    d = -1;
                    t1.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
                    t2.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
                    $("#addModal").modal("hide");
                }
            });
           

        }
        function delEdit(){
            var vid = document.getElementById("vid").value;
            if(confirm("Are you sure!")){

                var data = {
                    "vid": vid,
                };
                var dataString = JSON.stringify(data);
                $.ajax({
                    url: 'del-visit.php',
                    data: {myData: dataString},
                    type: 'POST',
                    success: function(response) {
                        
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#modal-calendar').fullCalendar('refetchEvents');
                        $("#editModal").modal("hide");
                    }
                });
                    
            }
        }
        function saveEdit(){
            var vid = document.getElementById("vid").value;
            var date1 = document.getElementById("Edate").value;
            var start1 = document.getElementById("Estart").value;
            var end1 = document.getElementById("Eend").value;
            var payment1 = document.getElementById("ent").value;
            var comment1 = document.getElementById("EComment").value;
            document.getElementById("Edate").disabled = false;
            document.getElementById("Estart").disabled = false;
            document.getElementById("Eend").disabled = false;
            document.getElementById("Epayment").disabled = true;
            document.getElementById("ent").disabled = false;
            document.getElementById("EComment").disabled = false;
            if(date1 == ""){
                alert("select date first!!");
                return;
            }
            if(start1 == ""){
                alert("select starting time first!!");
                return;
            }
            if(end1 == ""){
                alert("select ending time first!!");
                return;
            }
            if(payment1 == ""){
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
                data: {myData: dataString},
                type: 'POST',
                success: function(response) {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#modal-calendar').fullCalendar('refetchEvents');
                    if(pid != -1){
                        $('#disp-patient-calendar').fullCalendar('removeEventSources');
                        $.ajax({
                            url:"load-patient.php",
                            type:"POST",
                            data:{pid:pid},
                            success:function(events)
                            {
                                data = JSON.parse(events);
                                $('#disp-patient-calendar').fullCalendar('addEventSource', data);
                                //$('#disp-patient-calendar').fullCalendar('renderEvents');
                            }
                        });
                    }
                    if(did != -1){
                        $('#disp-dentist-calendar').fullCalendar('removeEventSources');
                        $.ajax({
                            url:"load-dentist.php",
                            type:"POST",
                            data:{did:did},
                            success:function(events)
                            {
                                data = JSON.parse(events);
                                $('#disp-dentist-calendar').fullCalendar('addEventSource', data);
                                //$('#disp-patient-calendar').fullCalendar('renderEvents');
                            }
                        });
                    }
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#modal-calendar').fullCalendar('refetchEvents');
                }
            });
            
            $("#editModal").modal("hide");

        }
        $(document).ready(function(){
            
            t1 = $('#patients').DataTable( {
                "bInfo" : false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": true,
                select: {
                    style: 'single'
                },
                "ajax": "patients.php"
            } );
            $('#patients tbody').on( 'dblclick', 'tr', function (ev) {
                
                        var cell = t1.row( this );
                        r = cell.data();
                        $("#pp1").val(r[1]);
                        $("#pp2").val(r[2]);
                        $("#pp3").val(r[0]);
                        $("#pp4").val(r[3]);
                        $("#pp5").val(r[4]);
                        $("#pp6").val(r[5]);
                        $("#pp7").val(r[6]);
                        $("#pp8").val(r[7]);

                        $("#addModal").modal("hide");
                        $("#pp").modal("show");
                    
            } );
            t2 = $('#dentists').DataTable( {
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "bInfo" : false,
                "serverSide": false,
                select: {
                    style: 'single'
                },
                "ajax": "dentists.php"
            } );
            t3 = $('#disp-patients').DataTable( {
                "bInfo" : false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": true,
                "ajax": "patients.php"
            } );
            t4 = $('#disp-dentists').DataTable( {
                "bInfo" : false,
                "lengthChange": false,
                "iDisplayLength": 5,
                "processing": true,
                "serverSide": false,
                "ajax": "dentists.php"
            } );
            var column = t1.column( $(this).attr('ID') );
            column.visible( ! column.visible() );
            column = t2.column( $(this).attr('ID') );
            column.visible( ! column.visible() );
            column = t3.column( $(this).attr('ID') );
            column.visible( ! column.visible() );
            column = t4.column( $(this).attr('ID') );
            column.visible( ! column.visible() );

            $('.dataTable').on('click', 'tbody tr', function() {
                if(t1.row(this).data()){
                    p = t1.row(this).data()[0];
                }
                if(t2.row(this).data()){
                    d = t2.row(this).data()[0];
                }
                if(t3.row(this).data()){
                    pid = t3.row(this).data()[0];
                    document.getElementById("disp-patient-calendar").style.display = "block";
                    document.getElementById("pt").style.display = "none";
                    document.getElementById("vv").style.display = "block";
                    $.ajax({
                        url:"load-patient.php",
                        type:"POST",
                        data:{pid:t3.row(this).data()[0]},
                        success:function(events)
                        {
                            data = JSON.parse(events);
                            $('#disp-patient-calendar').fullCalendar('addEventSource', data);
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });

                    
                    
                }
                if(t4.row(this).data()){
                    did = t4.row(this).data()[0];
                    document.getElementById("disp-dentist-calendar").style.display = "block";
                    document.getElementById("dt").style.display = "none";
                    document.getElementById("cc").style.display = "block";
                    $.ajax({
                        url:"load-dentist.php",
                        type:"POST",
                        data:{did:t4.row(this).data()[0]},
                        success:function(events)
                        {
                            data = JSON.parse(events);
                            $('#disp-dentist-calendar').fullCalendar('addEventSource', data);
                            //$('#disp-patient-calendar').fullCalendar('renderEvents');
                        }
                    });

                    
                    
                }
            });
            $('#addModal').on('hidden.bs.modal', function () {
                $('[href="#pi"]').tab('show');
                document.getElementById("date").value = "";
                document.getElementById("start").value = "";
                document.getElementById("end").value = "";
                document.getElementById("payment").value = "";
                document.getElementById("Comment").value = "";
                p = -1;
                d = -1;
                t1.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
                t2.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
                
            })
            $('#pModal').on('hidden.bs.modal', function () {
                document.getElementById("disp-patient-calendar").style.display = "none";
                document.getElementById("pt").style.display = "block";
                $('#disp-patient-calendar').fullCalendar('removeEventSources');
                pid = -1;
            });
            $('#dModal').on('hidden.bs.modal', function () {
                document.getElementById("disp-dentist-calendar").style.display = "none";
                document.getElementById("dt").style.display = "block";
                $('#disp-dentist-calendar').fullCalendar('removeEventSources');
                did = -1;
            });
            $('#editModal').on('hidden.bs.modal', function () {
                document.getElementById("Edate").disabled = false;
                document.getElementById("Estart").disabled = false;
                document.getElementById("Eend").disabled = false;
                document.getElementById("Epayment").disabled = true;
                document.getElementById("ent").disabled = false;
                document.getElementById("EComment").disabled = false;
            });

        });
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
                        dow: [ 0, 1, 2, 3, 6 ], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [ 4, 5 ], // Thursday, Friday
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
                eventClick:function(event)
                {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month()+1)<10?'0'+(event.start.month()+1):(event.start.month()+1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour())<10?'0'+(event.start.hour()):(event.start.hour())) + ":" + ((event.start.minute())<10?'0'+(event.start.minute()):(event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour())<10?'0'+(event.end.hour()):(event.end.hour())) + ":" + ((event.end.minute())<10?'0'+(event.end.minute()):(event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    document.getElementById("ent").value = event.payment;

                    $.ajax({
                        url:"pay.php",
                        type:"POST",
                        data:{vid:event.id},
                        success:function(res)
                        {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if(event.done != 0){
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;
                        document.getElementById("ent").disabled = true;

                    }

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
                        dow: [ 0, 1, 2, 3, 6 ], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [ 4, 5 ], // Thursday, Friday
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
                eventClick:function(event)
                {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month()+1)<10?'0'+(event.start.month()+1):(event.start.month()+1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour())<10?'0'+(event.start.hour()):(event.start.hour())) + ":" + ((event.start.minute())<10?'0'+(event.start.minute()):(event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour())<10?'0'+(event.end.hour()):(event.end.hour())) + ":" + ((event.end.minute())<10?'0'+(event.end.minute()):(event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    document.getElementById("ent").value = event.payment;

                    $.ajax({
                        url:"pay.php",
                        type:"POST",
                        data:{vid:event.id},
                        success:function(res)
                        {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if(event.done != 0){
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;
                        document.getElementById("ent").disabled = true;

                    }

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
                    url: 'load-all.php',
                    type: 'POST',
                    data: {
                        pid: 3
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
                        dow: [ 0, 1, 2, 3, 6 ], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [ 4, 5 ], // Thursday, Friday
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
                eventClick:function(event)
                {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month()+1)<10?'0'+(event.start.month()+1):(event.start.month()+1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour())<10?'0'+(event.start.hour()):(event.start.hour())) + ":" + ((event.start.minute())<10?'0'+(event.start.minute()):(event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour())<10?'0'+(event.end.hour()):(event.end.hour())) + ":" + ((event.end.minute())<10?'0'+(event.end.minute()):(event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    document.getElementById("ent").value = event.payment;

                    $.ajax({
                        url:"pay.php",
                        type:"POST",
                        data:{vid:event.id},
                        success:function(res)
                        {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if(event.done != 0){
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;
                        document.getElementById("ent").disabled = true;

                    }

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
                    url: 'load-all.php',
                    type: 'POST',
                    data: {
                        pid: 3
                    },
                    error: function() {
                        console.log('there was an error while fetching events!');
                    }
                },
                //aspectRatio: 5,
                height: $(window).height()*0.96,
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
                        dow: [ 0, 1, 2, 3, 6 ], // Sunday, Monday, Tuesday, Wednesday, Saturday
                        start: '08:00', // 8am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [ 4, 5 ], // Thursday, Friday
                        start: '10:00', // 10am
                        end: '16:00' // 4pm
                    }
                ],
                dayClick: function(date) {
                    //alert('clicked ' + date.format());
                    $("#myModal").modal("show");
                    setTimeout(() => {
                        $('#modal-calendar').fullCalendar('changeView', 'agendaDay');
                        $('#modal-calendar').fullCalendar('gotoDate',date);
                    }, 150);
                    
                },
                eventClick:function(event)
                {
                    $("#editModal").modal("show");
                    document.getElementById("vid").value = event.id;
                    document.getElementById("Edate").value = ((event.start.year()) + "-" + ((event.start.month()+1)<10?'0'+(event.start.month()+1):(event.start.month()+1)) + "-" + event.start.date());
                    document.getElementById("Estart").value = ((event.start.hour())<10?'0'+(event.start.hour()):(event.start.hour())) + ":" + ((event.start.minute())<10?'0'+(event.start.minute()):(event.start.minute()));
                    document.getElementById("Eend").value = ((event.end.hour())<10?'0'+(event.end.hour()):(event.end.hour())) + ":" + ((event.end.minute())<10?'0'+(event.end.minute()):(event.end.minute()));
                    document.getElementById("EComment").value = event.comment;
                    document.getElementById("ent").value = event.payment;

                    $.ajax({
                        url:"pay.php",
                        type:"POST",
                        data:{vid:event.id},
                        success:function(res)
                        {
                            document.getElementById("Epayment").value = res;
                        }
                    });
                    if(event.done != 0){
                        document.getElementById("Edate").disabled = true;
                        document.getElementById("Estart").disabled = true;
                        document.getElementById("Eend").disabled = true;
                        document.getElementById("ent").disabled = true;

                    }

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
                        text: 'Logout',
                        click: function() {
                            window.location.replace("logout.php");
                        
                        }
                    },
                    patients: {
                        text: 'patients...',
                        click: function() {
                            $("#pModal").modal("show");
                        
                        }
                    },
                    dentists: {
                        text: 'dentists...',
                        click: function() {
                            $("#dModal").modal("show");
                        
                        }
                    }
                }
            });
            /*
            var calendar = $('#calendar').fullCalendar('getCalendar');
            calendar.on('dayClick', function(date, jsEvent, view) {
                console.log('clicked on ' + date.format());
            });
            */
        });
        setInterval(function(){
            $('#calendar').fullCalendar('refetchEvents');
            $('#modal-calendar').fullCalendar('refetchEvents');
        }, 5000);
    </script>
</body>

</html>