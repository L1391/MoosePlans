<!DOCTYPE=html>
<html>
<head>
  <title> Weekend Preferences </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

<p>Name:</p>
  <input type='text' id="name">
<br>
<p>Location:</p>
  <input type='text' id="location"  >
<br>
<p>Date:</p>
  <input type="text" id="date" placeholder="MM/DD/YYYY">
<br>
<p>Start time:</p>
  <input type=”text” id="starttime"   maxlength=5 placeholder="hh:mm">
<br>
<p>End time:</p>
  <input type=”text” id="endtime"   maxlength=5 placeholder="hh:mm">
<br>
<p>Student capacity:</p>
<input type='number' id="capacity"  min=0>
<br>
<p>Estimated Cost:</p>
  <input type='number' id="cost" min=0>
<br>
<p>Bring money?:</p>
<input type='checkbox' id='bringmoney'>
<br>
<p>On campus?:</p>
<input type='checkbox' id='oncampus'>
<br>
<p>Bus needed?:</p>
<input type='checkbox' id='busneeded'>
<br>
<p>Number of vans:</p>
  <input type='number' id="vans"   min=0 max=5>
<br>
<p>Description:</p>
  <input type='text' id="description"  >
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
