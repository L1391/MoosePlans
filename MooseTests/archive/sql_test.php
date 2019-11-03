<!DOCTYPE html>

<?php 
include_once("conn.php");
?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<div class='teacherselect'>
  <?php
  $availableStaff = $db->query("SELECT users.id as user_id, users.first_name FROM users INNER JOIN wknd_def ON users.id = wknd_def.teach_id 
                      WHERE wknd_def.id = 1")->fetchAll();
  
  echo "<select class='teach'>";
  foreach($availableStaff as $s) {
    echo "<option value='" . $s["user_id"] . "'>" . $s["first_name"] . "</option>";
    
  }
  echo "</select>";
  ?>
  </div>

  <?
  $availableTrips = $db->query("SELECT * FROM trip_def")->fetchAll();

  echo "<select id='trip'>";
  foreach($availableTrips as $t) {
    echo "<option value='" . $t["id"] . "'>" . $t["name"] . "</option>";
  }
  echo "</select>";

  $availableDays = $db->query("SELECT start_time, end_time FROM wknd_def WHERE id = 1 LIMIT 1")->fetch();
  //echo $availableDays['start_time'];
  $end = date("m/d/Y", strtotime($availableDays['end_time'] . ' +1 day' ));

  $period = new DatePeriod(
    new DateTime($availableDays['start_time']),
    new DateInterval('P1D'),
    new DateTime($end));

  echo "<select id='date'>";
  foreach($period as $d) {
    echo "<option value='" . $d->format("m/d/Y") . "'>" . $d->format("m/d/Y") . "</option>";
    
  }
  echo "</select>";
  ?>
  <input type="text" id="start_time" maxlength="5" placeholder="hh:mm">
  <input type="text" id="end_time" maxlength="5" placeholder="hh:mm">

  <button onclick="addTeacher()"> Add teacher </button>
  <button onclick="submitAssignment()"> Submit </button>
</body>
<script>
  function submitAssignment() {
    var teach_ids = "";
     $('.teach').each( function() {
      teach_ids = teach_ids + $(this).val() + " ";
    });
    var trip_id = $('#trip').val();
    var date = $('#date').val();
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();

    var datas = {
	        'trip_id': trip_id,
          'teach_ids': teach_ids,
          'date': date,
          'start_time': start_time,
          'end_time': end_time
		};
		jQuery.ajax({
		  type: "POST",
			url: "schedule_trip.php",
			dataType: 'html',
			data: datas,
      success: function(response) {
        console.log(response);
      }
		});
  }

  function addTeacher() {
    $( ".teach" ).first().clone().appendTo( "#teacherselect");
  }
</script>
</html>
