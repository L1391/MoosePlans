<!DOCTYPE html>
<html>
<body>

<?php
// Variable to check
$url="'string'https://www.w3schoolsÅÅ.com";

// Encode characters
$url = filter_var($url, FILTER_SANITIZE_ENCODED);
echo $url;
?>

</body>
</html>
