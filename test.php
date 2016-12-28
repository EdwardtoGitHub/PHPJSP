<?php
	 $basename="ar";
	 $link = new mysqli("localhost","root","", $basename);
 	 $link->query('set names utf8');
	  $table ="POI";
	if ($data=$_POST['jsdata'])  //这里的名字要和js里写的一样。
	{
		$obj =json_decode($data);
		
		selecta($obj);   //执行函数，这个函数是自定义的。。
	}
	function selecta($obj)
	{
/* 你的操作数据库的命令。。。。。。。。。。。。。。
         这里有一个很重要的东西，就是你返回的数据需要放到json数组里	           
json的写法不在详细介绍，样例是一维数组写法。   */
		 $sql="insert into POI "." values('" .$obj->{title} . "','" . $obj->{address} . "','" .$obj->{type} . "','" 
		 .$obj->{lng}. "','" .$obj->{lat}."')";
		  $basename="ar";
	 $link = new mysqli("localhost","root","", $basename);
 	 $link->query('set names utf8');
		 $Rult  = $link -> query($sql);
		//$a['data']=$rows['t_name'];  //$rows['t_name']是数据库的数据。这样就有了一个json数组$a,它的键data中有值。
		echo "		". $sql;  //这句非常重要，这是php-->js的方式，如果不需要，就不用写。
	}
?>