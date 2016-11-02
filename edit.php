<?php
//edit.php
require("functions.php");

//kas kasutaja uuendab andmeid
if(isset($_POST["update"])){

$Events->updateEvent($Helper->cleanInput($_POST["eventId"]), $Helper->cleanInput($_POST["eventType"]), $Helper->cleanInput($_POST["eventDate"]), $Helper->cleanInput($_POST['eventPrice']), $Helper->cleanInput($_POST['eventDescr']));

header("Location: edit.php?id=".$_POST["id"]."&success=true");
exit();

}

//saadan kaasa id
$event = $Events->getSingleEventData($_GET["id"]);

?>
<style>
    @import "styles.css";
</style>




<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <table class="table1">
        <tr>
            <td style="text-align:center"><h1>Edit</h1></td>
        </tr>
        <tr>
        <td>
            <table class="table2">
             <tr>
                 <td>Event type:<span class = 'redtext'>*</span></td>
                <td style="text-align:left">
                    <input type="hidden" name="eventId" value="<?=$_GET["id"];?>">
                        <select name="eventType">
                         <?php if($event->type == "Planned service"){?>
                                <option value="Planned service" selected>Planned service</option>
                         <?php } else { ?>
                                <option value="Planned service">Planned service</option>
                            <?php } ?>

                            <?php if($event->type== "Unplanned service"){?>
                                <option value="Unplanned service" selected>Unplanned service</option>
                            <?php } else { ?>
                                <option value="Unplanned service">Unplanned service</option>
                            <?php } ?>

                            <?php if($event->type == "Fuel checks"){?>
                                <option value="Fuel checks" selected>Fuel checks</option>
                            <?php } else { ?>
                                <option value="Fuel checks">Fuel checks</option>
                            <?php } ?>

                            <?php if($event->type == "Tuning"){?>
                                <option value="Tuning" selected>Tuning</option>
                            <?php } else { ?>
                                <option value="Tuning">Tuning</option>
                            <?php } ?>

                            <?php if($event->type == "Car accident"){?>
                                <option value="Car accident" selected>Car accident</option>
                            <?php } else { ?>
                                <option value="Car accident">Car accident</option>
                            <?php } ?>
                        </select>
                </td>
            </tr>
    <tr>
        <td>Date:<span class = 'redtext'>*</span></td>
        <td style="text-align:left"><input name="eventDate" type ="date" min="1900-01-01" max = "<?=date('Y-m-d'); ?>" value = "<?=$event->date?>" placeholder="YYYY-MM-DD"></td>
    </tr>
    <tr>
        <td>Price:<span class = 'redtext'>*</span></td>
        <td style="text-align:left"><input type="text" name="eventPrice" placeholder="ex. 15.50" onkeypress="return onlyNumbersWithDot(event);" / value = "<?=$event->price?>"></td>

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
    <tr>
        <td>Description:<span class = 'redtext'>*</span></td>
        <td style="text-align:left"><textarea name="eventDescr" cols="50" rows="10" placeholder="Describe event here..."><?=$event->descr?></textarea></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center"><button type ="submit" value = "Submit">Save</button></td>
        </tr>
                <tr>

        <td colspan ='2' style="text-align:center"><a href="data.php">Back...</a></td>
    </tr>

            </table>
    </table>
</form>