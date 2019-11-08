<?php
include_once("../conn.php");

$trip_ids = $_POST['trip_ids'];
$dates = $_POST['dates'];
$start_times = $_POST['start_times'];
$end_times = $_POST['end_times'];
$teach_ids = $_POST['teach_ids'];
$approved = $_POST['approved'];

$num_trips = count($trip_ids);


for ($i = 0; $i < $num_trips; $i++) {
    $num_teach_in_trip = count($teach_ids[$i]);
    $start_date = date("Y-m-d H:i:s", strtotime($dates[$i] . " " . $start_times[$i]));
    $end_date = date("Y-m-d H:i:s", strtotime($dates[$i] . " " . $end_times[$i]));

    $first_teach = $teach_ids[$i][0];
    $trip_id = $trip_ids[$i];
    //convert true/false string to 1/0 
    $trip_approved = $approved[$i]=='true' ? 1:0;
    
    $num_existing_row = $db->query("SELECT COUNT(*) FROM trip_sched WHERE id='$trip_id'")->fetchColumn();
    $existing_row = $db->query("SELECT approved FROM trip_sched WHERE id='$trip_id' GROUP BY id")->fetch();
  if ($num_existing_row == 1 || !empty($existing_row['approved']) ) {
    $update_row = $db->prepare("UPDATE trip_sched SET 
                        start_time='$start_date', end_time='$end_date', approved='$trip_approved', teach_id='$first_teach' WHERE id='$trip_id'");
    
    $update_row->execute();

    if ($num_teach_in_trip > 1) {
        $updated_row = $db->query("SELECT * FROM trip_sched WHERE id='$trip_id'")->fetch();
        $trip_def_id = $updated_row['trip_id'];
        $wknd_id = $updated_row['wknd_id'];

        for ($j = 1; $j < $num_teach_in_trip; $j++) {
            $teach_id = $teach_ids[$i][$j];
            $insert_row = $db->prepare("INSERT INTO trip_sched (id, trip_id, start_time, end_time, wknd_id, teach_id, approved) VALUES
                                    ('$trip_id', '$trip_def_id', '$start_date', '$end_date', '$wknd_id', '$teach_id','$trip_approved')");
            $insert_row->execute();
        }
    }
  } else {
      echo "Trip already finalized";
  }
}

echo "Assignment Updated!"
?>