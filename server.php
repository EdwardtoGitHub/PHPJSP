 <?php
 
  $basename="ar";
 $link = new mysqli("localhost","root","", $basename);
 $link->query('set names utf8');

	// include ("conj.php");//连接数据库
error_reporting(E_ALL^ E_NOTICE);
 $username=$_GET['name'];//接收客户端发来的username；
$content=file_get_contents("php://input");
$obj =json_decode($content);

//var_dump($username);
//$text=username:data;
	// $sql="select * from users where name='$name'";
	
	// $query=mysql_query($sql);
	
	// $rs = mysql_fetch_array($query);if(is_array($rs)){
	
	// if($_POST['pwd']==$rs['password']){
		//  echo "error".$content."error".$username;
		 // echo $obj->{'name'}.$obj->{'password'};
		 
	switch($obj->{'flag'}){
		case "0": 
				 $sql="select * from user " ."where name='". $obj->{'name'}."' and password='".$obj->{'password'}."'";
			$Rult  = $link -> query($sql);
			 $num=$Rult->num_rows;
			 if($num=="0"){
				echo "110"; 	
			  }else{ 
				echo "200"; 
			 }
			
			break;
		case "1":
		   $sql="insert into user values('".$obj->{'name'}."','".$obj->{'password'}."')" ;
		   $Rult  = $link -> query($sql);
		    if($Rult==NULL){
				echo "233"; 	
			  }else{ 
				echo "666"; 
			 }
			 break;
			
		}
 ?>
 <!doctype html>
 <head>
<meta charset="utf-8">
<title></title>
</head>
<html>

