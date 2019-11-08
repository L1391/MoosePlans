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
<p> First Prefernce</p>
<input type='radio' name='shift_off' class='shift_off_1' value=0> FRI Night <br>
<input type='radio' name='shift_off' class='shift_off_1' value=1> SAT Morning
<input type='radio' name='shift_off' class='shift_off_1' value=2> SAT Afternoon
<input type='radio' name='shift_off' class='shift_off_1' value=3> SAT Evening <br>
<input type='radio' name='shift_off' class='shift_off_1' value=4> SUN Morning
<input type='radio' name='shift_off' class='shift_off_1' value=5> SUN Afternoon <br>
<p> Second Prefernce</p>
<input type='radio' name='shift_off' class='shift_off_2' value=0> FRI Night <br>
<input type='radio' name='shift_off' class='shift_off_2' value=1> SAT Morning
<input type='radio' name='shift_off' class='shift_off_2' value=2> SAT Afternoon
<input type='radio' name='shift_off' class='shift_off_2' value=3> SAT Evening <br>
<input type='radio' name='shift_off' class='shift_off_2' value=4> SUN Morning
<input type='radio' name='shift_off' class='shift_off_2' value=5> SUN Afternoon <br>
<p> Third Prefernce</p>
<input type='radio' name='shift_off' class='shift_off_3' value=0> FRI Night <br>
<input type='radio' name='shift_off' class='shift_off_3' value=1> SAT Morning
<input type='radio' name='shift_off' class='shift_off_3' value=2> SAT Afternoon
<input type='radio' name='shift_off' class='shift_off_3' value=3> SAT Evening <br>
<input type='radio' name='shift_off' class='shift_off_3' value=4> SUN Morning
<input type='radio' name='shift_off' class='shift_off_3' value=5> SUN Afternoon <br>
<br>
<p> First Prefernce</p>
<input type='radio' name='meal' class='meal_2' value=0> FRI Dinner <br>
<input type='radio' name='meal' class='meal_2' value=1> SAT Breakfast
<input type='radio' name='meal' class='meal_2' value=2> SAT Lunch
<input type='radio' name='meal' class='meal_2' value=3> SAT Dinner <br>
<input type='radio' name='meal' class='meal_2' value=4> SUN Breakfast
<input type='radio' name='meal' class='meal_2' value=5> SUN Lunch <br>
<p> Second Prefernce</p>
<input type='radio' name='meal' class='meal_1' value=0> FRI Dinner <br>
<input type='radio' name='meal' class='meal_1' value=1> SAT Breakfast
<input type='radio' name='meal' class='meal_1' value=2> SAT Lunch
<input type='radio' name='meal' class='meal_1' value=3> SAT Dinner <br>
<input type='radio' name='meal' class='meal_1' value=4> SUN Breakfast
<input type='radio' name='meal' class='meal_1' value=5> SUN Lunch <br>
<p> Third Prefernce</p>
<input type='radio' name='meal' class='meal_3' value=0> FRI Dinner <br>
<input type='radio' name='meal' class='meal_3' value=1> SAT Breakfast
<input type='radio' name='meal' class='meal_3' value=2> SAT Lunch
<input type='radio' name='meal' class='meal_3' value=3> SAT Dinner <br>
<input type='radio' name='meal' class='meal_3' value=4> SUN Breakfast
<input type='radio' name='meal' class='meal_3' value=5> SUN Lunch <br>

<div class='results'></div>
<br>
<button onclick="submitPref()"> Submit </button>

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

function seeMore(id) {
    $("#" + id + " .details").toggle();
}

function submitPref() {
  var trip_ids = [];
  var wknd_id = $(".wknd").val();
  var meal_1 = $(".meal_1").val();
  var meal_2 = $(".meal_2").val();
  var meal_3 = $(".meal_3").val();

  var shift_1 = $(".shift_off_1").val();
  var shift_2 = $(".shift_off_2").val();
  var shift_3 = $(".shift_off_3").val();

  $('.trip').each(function() {
    trip_id = $(this).attr('id');
    approved = ($("#" + trip_id + " #approved").is(':checked'));
    if (approved) {
      trip_ids.push(trip_id);
      
    }
  });

  datas = {
    'trip_ids': trip_ids,
    'wknd_id': wknd_id,
    'meal_1': meal_1,
    'meal_2': meal_2,
    'meal_3': meal_3,
    'shift_off_1': shift_off_1,
    'shift_off_2': shift_off_2,
    'shift_off_3': shift_off_3
  };

  jQuery.ajax({
    type: "POST",
			url: "send_pref.php",
			dataType: 'html',
			data: datas,
      success: function(response) {
        console.log(response);
      }
  });

}

</script>
</html>