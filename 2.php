
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>最大子串</title>
</head>

<form name="myform" action="run2.php" method="get">
<table align="center">
<tr><td>第一个字符串:</td><td><input type="text" name="str1"></td></tr>
<tr><td>第二个字符串:</td><td><input type="text" name="str2"></td></tr>
<tr><td></td><td align="right"><input type="button" value="提交" onClick="go()"  ></td></tr>
</table>
</form>
<script type="text/javascript">
function go(){
	var a=document.myform.str1.value;
	var b=document.myform.str2.value;
	if(a=="" || b=="") alert("输入不能为空！");
	else
		document.myform.submit();
	
}
</script>
</body>
</html>