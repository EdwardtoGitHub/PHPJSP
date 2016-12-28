
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>最大子串</title>
</head>

<form action="run2.php" method="get">
<table align="center">
<tr><td>第一个字符串:</td><td id="str1area"><?php echo $_GET['str1']?></td></tr>
<tr><td>第二个字符串:</td><td id="str2area"><?php echo $_GET['str2']?></td></tr>
<tr><td>匹配到的最大子串:</td><td >
<?php
	$a =$_GET['str1'];
	$b =$_GET['str2'];
$c = [];
$lenht1 = strlen($a);
$lenth2 = strlen($b);
for ($i=0;$i<$lenht1;$i++) {
    for ($j=0;$j<$lenth2;$j++) {
        $n = ($i-1>=0 && $j-1>=0)?$c[$i-1][$j-1]:0;
        $n = ($a[$i] == $b[$j]) ? $n+1:0;
        $c[$i][$j] = $n;
    }
}
foreach ($c as $key=>$val) {
    $max = max($val);
    foreach ($val as $key1 =>$val1) {
        if ($val1 == $max && $max>0) {
            $cdStr[$max] = substr($b,$key1-$max+1,$max);
        }
    }
}
ksort($cdStr);
print_r(end($cdStr));
$content=file_get_contents("php://input");
 echo "error"+$content+"error";
exit;
?>
</td></tr>
</table>
</form>

</body>
</html>