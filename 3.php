
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Table</title>
</head>
<body>
<center>
<?php
 $basename="student";
 $link = new mysqli("localhost","root","", $basename);
 $link->query('set names utf8');
 $sql="show tables from " . " " . $basename;
 $Rult  = $link -> query($sql);
 $num=$Rult->num_rows;
 $x=1;
 echo "<font size='+3'>数据库<b>".$basename."</b>中共有".$num."个表</font>";
 while( $rs = $Rult -> fetch_array() ) {
 $tablename=$rs['Tables_in_student'];
 echo "<div><font size='+3'>" , $x , ".<a href='3go.php?table=",$tablename,"' target='_blank'>", $tablename,"</a></font></div>";	 
 $x++;
 
 }
?>
</center>
</body>
</html>