<?php
class Events{
    private $connection;
    function __construct($mysqli){
        $this->connection = $mysqli;
    }
    function newEvent($type, $date, $price, $descr){

        $stmt = $this->connection->prepare("INSERT INTO events_archive (eventType, eventDate, eventPrice, eventDescr) VALUES (?,?,?,?)");
        $stmt->bind_param("ssds", $type, $date, $price, $descr);



        if($stmt->execute()){
            $eventNotice="Event successfully saved!";
            header("Refresh:1");
        }else{
            $eventNotice = "Failed to save...";
        }
        return $eventNotice;
    }
    function getAllEvents (){

        $stmt = $this->connection->prepare("SELECT id, eventType, eventDate, eventPrice, eventDescr FROM events_archive WHERE deleted is NULL");
        $stmt->bind_result($id, $type, $date, $price, $descr);

        $stmt->execute();

        $result = array();

        //seni kuni on üks rida andmeid saada(10 rida = 10 korda)
        while($stmt->fetch()){
            $event = new StdClass();
            $event->eventId = $id;
            $event->eventType = $type;
            $event->eventDate = $date;
            $event->eventPrice = $price;
            $event->eventDescr = $descr;
            array_push($result, $event);
        }

        $stmt->close();

        return $result;
    }
    function delEvent($id){

        $stmt = $this->connection->prepare("UPDATE events_archive SET deleted=NOW() WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    function getSingleEventData($edit_id){



        $stmt = $this->connection->prepare("SELECT eventType, eventDate, eventPrice, eventDescr FROM events_archive WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $edit_id);
        $stmt->bind_result($eventType, $eventDate, $eventPrice, $eventDescr);
        $stmt->execute();

        //tekitan objekti
        $event = new stdclass();

        //saime ühe rea andmeid
        if($stmt->fetch()){
            // saan siin alles kasutada bind_result muutujaid
            $event->type = $eventType;
            $event->date = $eventDate;
            $event->price = $eventPrice;
            $event->descr = $eventDescr;


        }else{
            // ei saanud rida andmeid kätte
            // sellist id'd ei ole olemas
            // see rida võib olla kustutatud
            header("Location: data.php");
            exit();
        }

        $stmt->close();
        return $event;

    }
    function updateEvent($id, $type, $date, $price, $descr){


        $stmt = $this->connection->prepare("UPDATE events_archive SET eventType=?, eventDate=?, eventPrice=?, eventDescr=? WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("ssdsi",$type, $date, $price, $descr, $id);

        // kas õnnestus salvestada
        if($stmt->execute()){
            // õnnestus
            echo "salvestus õnnestus!";
        }

        $stmt->close();

    }
    function getDeletedEvents (){

        $stmt = $this->connection->prepare("SELECT id, eventType, eventDate, eventPrice, eventDescr, deleted FROM events_archive WHERE deleted IS NOT NULL");
        $stmt->bind_result($id, $type, $date, $price, $descr, $deleted);

        $stmt->execute();

        $result = array();

        //seni kuni on üks rida andmeid saada(10 rida = 10 korda)
        while($stmt->fetch()){

            $archevent = new StdClass();
            $archevent->eventId = $id;
            $archevent->eventType = $type;
            $archevent->eventDate = $date;
            $archevent->eventPrice = $price;
            $archevent->eventDescr = $descr;
            $archevent->eventDeleted = $deleted;
            array_push($result, $archevent);
        }

        $stmt->close();

        return $result;
    }
    function restoreEvent($id){

        $stmt = $this->connection->prepare("UPDATE events_archive SET deleted=NULL WHERE id=? AND deleted IS NOT NULL");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    function delForeverEvent($id){

        $stmt = $this->connection->prepare("DELETE FROM events_archive WHERE id=?");
        $stmt->bind_param("d", $id);
        $stmt->execute();
        $stmt->close();
    }
}