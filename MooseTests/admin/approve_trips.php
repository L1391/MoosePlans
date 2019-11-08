<html>
<?php include_once("../conn.php"); ?>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
<div>
<select class="wknd" onchange="loadWknd()">
<?php
$now = date("m/d/y");
echo $now;
$get_weekends = $db->query("SELECT * FROM wknd_def GROUP BY id")->fetchAll(); //WHERE start_date > '$now'

foreach($get_weekends as $wknd) {
  $label = $wknd['start_date'] . " " . $wknd['end_date'];
  echo "<option value='" . $wknd['id'] . "'>" . $label . "</option>";
}
?>
</select>
</div>
<div class='results'></div>
 <br>
 <button onclick="submitAssignment()"> Submit </button>
</body>

<script>
function loadWknd() {
  var wknd_id = $(".wknd").val();

  datas = {
    "wknd_id": wknd_id
  };

  jQuery.ajax({
    type: "POST",
			url: "get_trips.php",
			dataType: 'html',
			data: datas,
      success: function(response) {
        $(".results").html(response);
      }
  });
}

function addTeacher(id) {
    $(".teach" ).first().clone().appendTo( "#" + id + " .teacherselect");
  }

function seeMore(id) {
    $("#" + id + " .details").toggle();
}

function submitAssignment() {
  var trip_ids = [];
  var dates = [];
  var start_times = [];
  var end_times = [];
  var teach_ids = [];
  var approved = [];

  $('.trip').each(function() {
    trip_teach_ids = [];
    trip_id = $(this).attr('id');
    trip_ids.push(trip_id);
    dates.push($("#" + trip_id + " .date").val());
    start_times.push($("#" + trip_id + " .start_time").val());
    end_times.push($("#" + trip_id + " .end_time").val());
    approved.push($("#" + trip_id + " #approved").is(':checked'));


    $("#" + trip_id + ' .teach').each( function() {
      trip_teach_ids.push($(this).val());
    });
    teach_ids.push(trip_teach_ids);
    
  });


  datas = {
    'trip_ids': trip_ids,
    'dates': dates,
    'start_times': start_times,
    'end_times': end_times,
    'approved': approved,
    'teach_ids': teach_ids
  };

  jQuery.ajax({
    type: "POST",
			url: "send_assignment.php",
			dataType: 'html',
			data: datas,
      success: function(response) {
        console.log(response);
      }
  });

}

</script>

</html>