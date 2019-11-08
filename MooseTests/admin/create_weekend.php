<html>
<?php include_once("../conn.php"); ?>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<input id='start_date' placeholder='MM/DD/YYY'>
<input id='end_date' placeholder='MM/DD/YYY'>

<?php
//teacher selection area
echo "<div class='teacherselect'>";
        
$availableStaff = $db->query("SELECT users.id as user_id, users.first_name, users.last_name FROM users WHERE role='D'")->fetchAll();

echo "<select class='teach'>";
foreach($availableStaff as $s) {
  echo "<option value='" . $s["user_id"] . "'>" . $s["first_name"] . " " . $s["last_name"] .  "</option>";
  
}
echo "</select>";
?>
</div>
<button onclick='addTeacher()'> Add teacher </button>
<button onclick='submitWeekend()'> Submit </button>

</body>
<script>
function addTeacher() {
    $(".teach" ).first().clone().appendTo(".teacherselect");
  }

function submitWeekend() {
    teach_ids = [];
    start_date = $('#start_date').val();
    end_date = $('#end_date').val();

    $('.teach').each( function() {
      teach_ids.push($(this).val());
    });

    datas = {
        'teach_ids': teach_ids,
        'start_date': start_date,
        'end_date': end_date
    }

    jQuery.ajax({
    type: "POST",
			url: "send_weekend.php",
			dataType: 'html',
			data: datas,
      success: function(response) {
        console.log(response);
      }
  });

}
</script>
</html>