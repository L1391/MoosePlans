<html>
<head>
<?php include_once("conn.php"); ?>
  <title> Weekend Preferences </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    var trip_names = [
      <?php $trips = $db->query("SELECT name FROM trip_def")->fetchAll();
      foreach($trips as $index=>$t) {
        echo "'" . addslashes($t['name']) . "'";
        if ($index < sizeof($trips) - 1) {
          echo ",";
        }
      }
      ?>
    ];
    $("#name").autocomplete({
      source: trip_names
    });
  });

  function updateFields() {
    var trip_names = [
      <?php $trips = $db->query("SELECT name FROM trip_def")->fetchAll();
      foreach($trips as $index=>$t) {
        echo "'" . addslashes($t['name']) . "'";
        if ($index < sizeof($trips) - 1) {
          echo ",";
        }
      }
      ?>
    ];
    var name = $('#name').val();
    if (trip_names.includes(name)) {
      $('.optional').hide();
    } else {
      $('.optional').show();
    }
  }
  </script>
</head>
<body>

Name:
  <input type='text' id="name" onchange='updateFields()'>
<br>
<div class='optional'>
Location:
  <input type='text' id="location"  >
</div>
Date:
  <input type="text" id="date" placeholder="MM/DD/YYYY">
<br>
Start time:
  <input type=”text” id="starttime"   maxlength=5 placeholder="hh:mm">
<br>
End time:
  <input type=”text” id="endtime"   maxlength=5 placeholder="hh:mm">
<br>
<div class='optional'>
Student capacity:
<input type='number' id="capacity"  min=0>
<br>
Estimated Cost:
  <input type='number' id="cost" min=0>
<br>
Bring money?:
<input type='checkbox' id='bringmoney'>
<br>
On campus?:
<input type='checkbox' id='oncampus'>
<br>
Bus needed?:
<input type='checkbox' id='busneeded'>
<br>
Number of vans:
  <input type='number' id="vans"   min=0 max=5>
<br>
Description:
  <input type='text' id="description"  >
</div>
<br>


<button onclick="sendSuggest()"> Submit Suggestion </button>
</body>
<script>
function sendSuggest() {
    var name = $('#name').val(),
      location = $('#location').val(),
      date = $('#date').val(),
      start_time = $('#starttime').val(),
      end_time = $('#endtime').val(),
      capacity = $('#capacity').val(),
      cost = $('#cost').val(),
      bring_money = $('#bringmoney').is(":checked"),
      on_campus = $('#oncampus').is(":checked"),
      bus_needed = $('#busneeded').is(":checked"),
      vans = $('#vans').val(),
      description = $('#description').val();

      var datas = {
          'name': name,
	        'location': location,
          'date': date,
          'start_time': start_time,
          'end_time': end_time,
          'capacity': capacity,
          'cost': cost,
          'bring_money': bring_money,
          'on_campus': on_campus,
          'bus_needed': bus_needed,
          'vans': vans,
          'description': description
		};
    jQuery.ajax({
		  type: "POST",
			url: "send_suggestion.php",
			dataType: 'html',
			data: datas,
      success: function(response) {
        console.log(response);
      }
		});
  }
</script>
</html>
