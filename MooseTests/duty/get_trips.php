<?php
include_once("../conn.php");

$wknd_id = $_POST['wknd_id'];

$getTripSuggs = $db->query("SELECT *, s.id as sched_id FROM trip_sched as s INNER JOIN trip_def as d
                            ON s.trip_id = d.id 
                            INNER JOIN wknd_def as w ON s.wknd_id = w.id
                            WHERE w.id = '$wknd_id' GROUP BY s.id")->fetchAll();

    foreach($getTripSuggs as $sugg) {
        $date = date("m/d/Y", strtotime($sugg['start_time']));
        $start_time = date("H:i", strtotime($sugg['start_time']));
        $end_time = date("H:i", strtotime($sugg['end_time']));

        echo "<div class='trip' id='" . $sugg["sched_id"] . "'>";
        //trip name
        echo "<p>" . $sugg["name"] . "</p>";
        
        //date of event
        echo "<p>" . $date . "</p>";


        //start and end times
        echo "<p>" . $start_time . "</p>";
        echo "<p>" . $end_time . "</p>";

        //see details
        echo "<button onclick='seeMore(" .$sugg["sched_id"] . ")'> See more </button>";

        echo "<div class='details' style='display:none'> " . $sugg["location"] . "<br>" . $sugg["description"] . "<br> $" . $sugg["cost"] . "<br>" . $sugg["capacity"] . " students <br>" . $sugg["vans_needed"] . " vans</div>";

        echo "<input type='checkbox' id='approved'>";

        echo "</div>";
    }
?>