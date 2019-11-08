<?php
include_once("../conn.php");

$wknd_id = $_POST['wknd_id'];

$getTripSuggs = $db->query("SELECT *, s.id as sched_id FROM trip_sched as s INNER JOIN trip_def as d
                            ON s.trip_id = d.id 
                            INNER JOIN wknd_def as w ON s.wknd_id = w.id
                            WHERE w.id = '$wknd_id' GROUP BY s.id")->fetchAll();

    foreach($getTripSuggs as $sugg) {
        $end = date("m/d/Y", strtotime($sugg['end_date'] . ' +1 day' ));
        $period = new DatePeriod(
        new DateTime($sugg['start_date']),
        new DateInterval('P1D'),
        new DateTime($end));

        echo "<div class='trip' id='" . $sugg["sched_id"] . "'>";
        //trip name
        echo "<p>" . $sugg["name"] . "</p>";
        
        //date of event
        echo "<select class='date'>";
        foreach($period as $d) {

            echo "<option value='" . $d->format("m/d/Y") . "'";
            if ($d->format("m/d/Y") == date("m/d/Y", strtotime($sugg["start_time"])) ) echo " selected='selected'";
            echo ">" . $d->format("m/d/Y") . "</option>";
    
        }
        echo "</select>";

        //start and end times
        echo "<input type='text' class='start_time' maxlength='5' value='" . date("H:i", strtotime($sugg["start_time"])) . "'>";
        echo "<input type='text' class='end_time' maxlength='5' value='" . date("H:i", strtotime($sugg["end_time"])) . "'>";

        //teacher selection ar    ea
        echo "<div class='teacherselect'>";
        
        $availableStaff = $db->query("SELECT users.id as user_id, users.first_name, users.last_name FROM users INNER JOIN wknd_def ON users.id = wknd_def.teach_id 
                            WHERE wknd_def.id = '$wknd_id'")->fetchAll();
        
        echo "<select class='teach'>";
        foreach($availableStaff as $s) {
          echo "<option value='" . $s["user_id"] . "'>" . $s["first_name"] . " " . $s["last_name"] .  "</option>";
          
        }
        echo "</select> </div>";
        //add teacher
        echo "<button onclick='addTeacher(" .$sugg["sched_id"] . ")'> Add teacher </button>";
        //see details
        echo "<button onclick='seeMore(" .$sugg["sched_id"] . ")'> See more </button>";

        echo "<div class='details' style='display:none'> " . $sugg["location"] . "<br>" . $sugg["description"] . "<br> $" . $sugg["cost"] . "<br>" . $sugg["capacity"] . " students</div>";

        echo "<input type='checkbox' id='approved'>";

        echo "</div>";
    }
?>