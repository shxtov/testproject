<?php
require ("functions.php");

//kas on sisseloginud, kui ei ole siis
//suunata login lehele

//kas ?logout on aadressireal
if (isset($_GET['logout'])){
    session_destroy();
    header("Location: login.php");
}

if (!isset ($_SESSION["userId"])){
    header("Location: login.php");
}



$confirm = "";
$eventNotice = "";
$eventTypeError = "";
$eventDateError = '';
$eventPriceError = '';
$eventDescrError = '';
$eventType = '';
$eventDescr = '';
$eventPrice = '';
$eventDate = date("Y-m-d");
$eventId = "";

if(!empty($_POST['delValue'])) {
    $Events->delEvent($_POST['delValue']);
}

if(!empty($_POST['restoreValue'])){
    $Events->restoreEvent($_POST['restoreValue']);
}

if(!empty($_POST['delforeverValue'])){
    $Events->delForeverEvent($_POST['delforeverValue']);
}

if (isset ($_POST["eventType"])){
    if (empty($_POST['eventType'])){
        $eventTypeError = "Please choose the event type!";
    } else {
        $eventType = $_POST["eventType"];
    }
}

if (isset ($_POST ["eventDate"])){
    if (empty ($_POST ["eventDate"])){
        $eventDateError = "Please choose the date!";
    } else {
        $eventDate = $_POST["eventDate"];
    }
}

if (isset ($_POST ["eventPrice"])){
    if (empty ($_POST ["eventPrice"])){
        $eventPriceError = "Please type in the price!";
    } else {
        $eventPrice = $_POST["eventPrice"];
    }
}

if (isset ($_POST ["eventDescr"])){
    if (empty ($_POST ["eventDescr"])){
        $eventDescrError = "Please type in the description!";
    }elseif (strlen($_POST["eventDescr"])< 10) {
        $eventDescrError = "Description must be longer than 10 symbols!";
        $eventDescr = $_POST['eventDescr'];
    }else{
        $eventDescr = $_POST['eventDescr'];
    }
}

$event = $Events->getAllEvents();
$archevent = $Events->getDeletedEvents();



if(!empty($_POST['editValue'])) {
    $editValue_fill = explode("|", $_POST["editValue"]);
    $eventId = $editValue_fill[0];
    $eventType = $editValue_fill[1];
    $eventDate = $editValue_fill[2];
    $eventPrice = $editValue_fill[3];
    $eventDescr = $editValue_fill[4];
}



if(empty($eventTypeError)&& empty($eventDateError)&& empty($eventPriceError) && empty($eventDescrError)
    && isset($_POST['eventType']) && isset($_POST['eventDate']) && isset ($_POST['eventPrice']) && isset
    ($_POST['eventDescr'])) {
    $eventNotice = $Events->newEvents($Helper->cleanInput($eventType), $Helper->cleanInput($eventDate), $Helper->cleanInput($eventPrice), $Helper->cleanInput($eventDescr));
}
?>



<html>

<style>
    @import "styles.css";
    ul.tab {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }
    ul.tab li {float: left;}
    ul.tab li a {
        display: inline-block;
        color: black;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        transition: 0.3s;
        font-size: 17px;
    }
    ul.tab li a:hover {
        background-color: #ddd;
    }
    ul.tab li a:focus, .active {
        background-color: #ccc;
    }
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>


<body>
<form method ="post">
    <table class="table1">
        <tr>
            <td style="text-align:center"><h1>Data</h1></td>
        </tr>
        <tr>
            <th><h2>Profile</h2></th>
        </tr>
        <tr>
            <td>
                <table class="table2">
                    <tr>
                        <td colspan="3"">Welcome <?=$_SESSION['email'];?>!</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:center"><a href="?logout=1">Log out</a></td>
                    </tr>
                </table>
        <tr>
            <td>

                    <tr>
                        <td>
                            <ul class="tab">
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Add/edit')" id="defaultOpen">Add/edit</a></li>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Events')">Events</a></li>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(event, 'Archive')">Deleted archive</a></li>
                            </ul>

                            <div id="Add/edit" class="tabcontent">
                                <table class="table2">
                                    <tr>
                                        <td>Events type:<span class = 'redtext'>*</span></td>
                                        <td style="text-align:left">
                                            <select name="eventType">

                                                <?php if(empty($eventType)){?>
                                                    <option value="" selected>Choose here</option>
                                                <?php } else { ?>
                                                    <option value="">Choose here</option>
                                                <?php } ?>

                                                <?php if($eventType == "Planned service"){?>
                                                    <option value="Planned service" selected>Planned service</option>
                                                <?php } else { ?>
                                                    <option value="Planned service">Planned service</option>
                                                <?php } ?>

                                                <?php if($eventType == "Unplanned service"){?>
                                                    <option value="Unplanned service" selected>Unplanned service</option>
                                                <?php } else { ?>
                                                    <option value="Unplanned service">Unplanned service</option>
                                                <?php } ?>

                                                <?php if($eventType == "Fuel checks"){?>
                                                    <option value="Fuel checks" selected>Fuel checks</option>
                                                <?php } else { ?>
                                                    <option value="Fuel checks">Fuel checks</option>
                                                <?php } ?>

                                                <?php if($eventType == "Tuning"){?>
                                                    <option value="Tuning" selected>Tuning</option>
                                                <?php } else { ?>
                                                    <option value="Tuning">Tuning</option>
                                                <?php } ?>

                                                <?php if($eventType == "Car accident"){?>
                                                    <option value="Car accident" selected>Car accident</option>
                                                <?php } else { ?>
                                                    <option value="Car accident">Car accident</option>
                                                <?php } ?>

                                            </select>
                                        </td>
                                    </tr>
                                    <tr><td colspan="3" class="redtext" style="text-align:center"><?=$eventTypeError?></td></tr>
                                    <tr>
                                        <td>Date:<span class = 'redtext'>*</span></td>
                                        <td style="text-align:left"><input name="eventDate" type ="date" min="1900-01-01" max = "<?=date('Y-m-d'); ?>" value = "<?=$eventDate?>" placeholder="YYYY-MM-DD"></td>
                                    </tr>
                                    <tr><td colspan="3" class="redtext" style="text-align:center"><?=$eventDateError?></td></tr>
                                    <tr>
                                        <td>Price:<span class = 'redtext'>*</span></td>
                                        <td style="text-align:left"><input type="text" name="eventPrice" placeholder="ex. 15.50" onkeypress="return onlyNumbersWithDot(event);" / value = "<?=$eventPrice?>"></td>

                                        <script type="text/javascript">
                                            function onlyNumbersWithDot(e) {
                                                var charCode;
                                                if (e.keyCode > 0) {
                                                    charCode = e.which || e.keyCode;
                                                }
                                                else if (typeof (e.charCode) != "undefined") {
                                                    charCode = e.which || e.keyCode;
                                                }
                                                if (charCode == 46)
                                                    return true
                                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                                    return false;
                                                return true;
                                            }
                                        </script>

                                    </tr>
                                    <tr><td colspan="3" class="redtext" style="text-align:center"><?=$eventPriceError?></td></tr>
                                    <tr>
                                        <td>Description:<span class = 'redtext'>*</span></td>
                                        <td style="text-align:left"><textarea name="eventDescr" cols="50" rows="10" placeholder="Describe event here..."><?=$eventDescr?></textarea></td>
                                    </tr>
                                    <tr><td colspan="3" class="redtext" style="text-align:center"><?=$eventDescrError?></td></tr>
                                    <tr>
                                        <td colspan="3" style="text-align:center"><button type ="submit" value = "Submit">Save</button></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" style="text-align:center"><p class = "redtext"><?=$eventNotice;?></p></td>
                                    </tr>
                                </table>
                            </div>
</form>
<form method="post">


    <div id="Events" class="tabcontent">
        <table class="table2">
            <tr>
                <td colspan="3"">
                <?php
                $html = "<table>";
                $html .= "<tr>";
                $html .= "<th>Events type</th>";
                $html .= "<th>Date</th>";
                $html .= "<th>Price(€)</th>";
                $html .= "<th>Description</th>";
                $html .= "<th> </th>";
                $html .= "<th> </th>";
                $html .= "</tr>";

                foreach($event as $e){
                    $html .= "<tr>";
                    $html .= "<td>$e->eventType</td>";
                    $html .= "<td>$e->eventDate</td>";
                    $html .= "<td>$e->eventPrice</td>";
                    $html .= "<td>$e->eventDescr</td>";
                    $html .= "<td><button style='border:none; background-color: transparent;' value='$e->eventId' name='delValue' onclick=\"return confirm('Do you really want to delete this row?')\"><img src='delete.png' width='20' height='20'></button></td>";
                    $html .= "<td><a href='edit.php?id=".$e->eventId."'><img src='edit.png' width='20' height='20'></a></td>";
                    $html .= "</tr>";
                }

                $html .= "</table>";
                echo $html;

                ?>
                </td>
            </tr>
         </table>

    </div>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

</form>

<form method="post">

<div id="Archive" class="tabcontent">
    <table class="table2">
        <tr>
            <td colspan="3"">
            <?php
            $html = "<table>";
            $html .= "<tr>";
            $html .= "<th>Events type</th>";
            $html .= "<th>Date</th>";
            $html .= "<th>Price(€)</th>";
            $html .= "<th>Description</th>";
            $html .= "<th>Deleted date</th>";
            $html .= "<th> </th>";
            $html .= "<th> </th>";
            $html .= "</tr>";


            foreach($archevent as $ae){
                $html .= "<tr>";
                $html .= "<td>$ae->eventType</td>";
                $html .= "<td>$ae->eventDate</td>";
                $html .= "<td>$ae->eventPrice</td>";
                $html .= "<td>$ae->eventDescr</td>";
                $html .= "<td>$ae->eventDeleted</td>";
                $html .= "<td><button style='border:none; background-color: transparent;' value='$ae->eventId' name='delforeverValue' onclick=\"return confirm('Do you really want to delete this row forever?')\"><img src='delete.png' width='20' height='20'></button></td>";
                $html .= "<td><button style='border:none; background-color: transparent;' value='$ae->eventId' name='restoreValue'><img src ='restore.png' width ='20' height='20'></button></td>";
                $html .= "</tr>";
            }

            $html .= "</table>";
            echo $html;

            ?>
            </td>
        </tr>
    </table>

</div>
</form>




</body>
</html>