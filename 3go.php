
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$_GET['table']?></title>
</head>
<body>
<center><fieldset >
<?php
 $basename="student";
 $table =$_GET['table'];
 @$flag=$_POST['flag'];
 $link = new mysqli("localhost","root","", $basename);
 $link->query('set names utf8');
 if($flag==1){
	 $sql="insert into " . $table ." values(" . $_POST['addid'] . ",'" . $_POST['addname'] . "'," . $_POST['addphone'] . ",'" .$_POST['addaddress']."')";
 	$Rult  = $link -> query($sql);
 } 
 echo $flag;
 if($flag==2){
	 $uid=$_POST['updateid'];
	 $uname=$_POST['updatename'];
	 $uphone=$_POST['updatephone'];
	 $uaddress=$_POST['updateaddress'];
	 //三者均不为空
	 if($uname!=null && $uphone!=null && $uaddress!=null)
	 	$sql = "update " . $table ." set name='" . $uname . "',phone=" . $uphone. ",address='".$uaddress."' where id=" . $uid;
	 //只有一个为空
	 else if($uname==null && $uphone!=null && $uaddress!=null)
	 	$sql = "update " . $table ." set phone=" . $uphone. ",address='".$uaddress."' where id=" . $uid;
	 else if($uname!=null && $uphone==null && $uaddress!=null)
	 	$sql = "update " . $table ." set name='" . $uname . "',address='".$uaddress."' where id=" . $uid;
	 else if($uname!=null && $uphone!=null && $uaddress==null)
	 	$sql = "update " . $table ." set name='" . $uname . "',phone=" . $uphone. " where id=" . $uid;
	 //两个为空
	 else if($uname==null && $uphone==null && $uaddress!=null)
	 	$sql = "update " . $table ." set address='".$uaddress."' where id=" . $uid;
	 else if($uname==null && $uphone!=null && $uaddress==null)
	 	$sql = "update " . $table ." set phone=" . $uphone." where id=" . $uid;
	 else if($uname!=null && $uphone==null && $uaddress==null)
	 	$sql = "update " . $table ." set name='" . $uname .  "' where id=" . $uid;
	 
 	$Rult  = $link -> query($sql);
 }
 
 if($flag==3){
	 $delid=$_POST['delid'];
	 $sql = "delete from " . $table ." where id=" . $delid;
	 $Rult  = $link -> query($sql);
 }
 
 $sql="select * from " . $table;
 $Rult  = $link -> query($sql);
 $num=$Rult->num_rows;
 $fieldnum = $Rult->field_count;
 echo "<legend><font size='+3'><b>" . $table . "</b></font></legend><br>";
 echo "<table border='1' bordercolor='#1F77A8'><tr>";
 
 while ( $rs = $Rult->fetch_field()){
	 echo "<td style='width:100px;word-break:break-all;text-align:center'>" . $rs->name . "</td>";
 }
 echo "</tr>";
 
 while( $rs = $Rult -> fetch_array() ) {
 
 	echo "<tr>";
 	for($x=0;$x<$fieldnum;$x++){
 		echo "<td style='width:100px;text-align:center'>" . $rs[$x] . "</td>";
     	
		
	}
	

	echo "</tr>";
 }
 echo "</table>";
?>

<br>
<b>新增用户</b><br>
<form action="3go.php?table=<?=$table?>" target="_self" method="post" name="addform">
<table>
<tr><td>Id：&nbsp;&nbsp; </td> <td><input type="text" name="addid"></td></tr>
<tr><td>姓名：&nbsp;&nbsp; </td> <td><input type="text" name="addname"></td></tr>
<tr><td>手机：&nbsp;&nbsp;</td> <td><input type="text" name="addphone"></td></tr>
<tr><td>地址：&nbsp;&nbsp;</td> <td><input type="text" name="addaddress"></td><td><input type="button" value="添加" onclick="addnew()"></td></tr>
<input type="hidden" name="flag" value=1>
</table>
</form>

<br>
<b>修改用户</b><br>
<form action="3go.php?table=<?=$table?>" target="_self" method="post" name="updateform">
<table>
<tr><td>需要修改的ID：</td> <td><input type="text" name="updateid"></td></tr>
<tr><td>新姓名：</td> <td><input type="text" name="updatename" placeholder="不修改则不填写"></td></tr>
<tr><td>新手机：</td> <td><input type="text" name="updatephone" placeholder="不修改则不填写"></td></tr>
<tr><td>新地址：</td> <td><input type="text" name="updateaddress" placeholder="不修改则不填写"></td><td><input type="button" value="修改" onclick="update()"></td></tr>
<input type="hidden" name="flag" value=2>
</table>
</form>

<br>
<b>删除用户</b><br>
<form action="3go.php?table=<?=$table?>" target="_self" method="post" name="delform">
<table>
<tr><td>需要删除的ID：</td> <td><input type="text" name="delid"></td> <td><input type="button" value="删除" onclick="del()"></td></tr>
<input type="hidden" name="flag" value=3>
</table>
</form>
</fieldset>
</center>

<script type="text/javascript">
function addnew(){
	var id = document.addform.addid.value;
	var name=document.addform.addname.value;
	var phone=document.addform.addphone.value;
	var address=document.addform.addaddress.value;
	if(id==""||name==""||phone==""||address=="") alert("输入不能为空");
	else
	document.addform.submit();
}

function update(){
	var name=document.updateform.updatename.value;
	var phone=document.updateform.updatephone.value;
	var address=document.updateform.updateaddress.value;
	if(name=="" && phone=="" && address=="") alert("输入不能为空");
	else{
	document.updateform.submit();}
}


function del(){
	var delid=document.delform.delid.value;
	
    if(delid=="") 
		alert("输入不能为空");
	
	else 
		document.delform.submit();
}

</script>
</body>
</html>