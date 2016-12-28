
<!DOCTYPE html>
<html>
<body>

<?php
date_default_timezone_set("Asia/Shanghai");
echo("now:   ");
echo date("jS \of F Y h:i:s A");
echo "<br>";

$second1=strtotime("2016-12-25");
$second2=strtotime("2016-11-22");

$days=($second1-$second2)/86400;
echo "今天与2016-12-25相差" . $days. "天";
?>
  
</body>
</html>