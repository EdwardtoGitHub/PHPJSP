<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>数据库 POI点抓取JS爬虫实现</title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <script type="text/javascript" src="jquery.js"></script>
       <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=61ff806238466050f92d9eebf10270ca&plugin=AMap.DistrictSearch"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
 
</head>
<body>
<div id="container"></div>
<script type="text/javascript">
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
	
	alert("oooo")
	try{
	
	var districtSearch = new AMap.DistrictSearch();
	districtSearch.setLevel('country');
	districtSearch.setSubdistrict(4); 
	 districtSearch.search('中华人民共和国', function(status, result) {
        if(status=='complete'){
            getData(result);
        }else{
			alert(status+result.info)
		}
    });
	}catch(e){
		alert(e);
		}
//var center=new	AMap.LngLat(113.9430620000,22.5406900000) //东经­113°46'～114°37',北纬22°27'～22°52'
	 
    //placeSearch.getDetails("B000A83U0P", function(status, result) {
      //  if (status === 'complete' && result.info === 'OK') {
        //    placeSearch_CallBack(result);
        //}
   // });
    //回调函数
    function placeSearch_CallBack(data) {
        var poiArr = data.poiList.pois;
        //添加marker
		for(var i=0;i<poiArr.count;i++){
			alert(data.poiList.count)
		}
    		 //alert( poiArr[0].location.toString())
    }
	function getData(result){
		alert("yes");
		var arr=result.districtList; 
		alert(arr[0].name);
		var pro=arr[0].districtList;
		alert("共有省份"+pro.length);
		for(var i=0;i<pro.length;i++){
				//alert("proname:"+pro[i].name+"procode"+pro[i].citycode);
				var cityList=pro[i].districtList;
				for(var j=0;j<cityList.length;j++){
					alert("cityList.length"+cityList.length);
						var obj=new Object();
					obj.procode=(i+1);
                     obj.cityname =cityList[j].name;	
					 obj.citycode=cityList[j].citycode;
					 obj.lng=cityList[j].center.getLng();
					 obj.lat=cityList[j].center.getLat();//要加括号
					 try{	
					senddata(obj);
				}
				catch(e){
					alert(e);
				}
							
				}
				
			
		}
			
	}
	
	function senddata(obj){
		var strjson = JSON.stringify(obj);
		$.ajax({ 
										  cache: false,
										   async: false,   //注意：这里设置为flase，即同步操作，因为我们不需要异步操作，只是传参而已，当然								                                  ，你也可以设置成异步。
							contentType: "application/x-www-form-urlencoded; charset=utf-8",  
						//这个要写对，和你的页面照应，你的页面是gb2312就填gb2312，我这里是utf8，否则中文传参会出错。
						  url: "getcode.php",  //这里填上你的php操作页面，即接受js参数的php页面。
					
							  //打上127.0.0.1/AR/test.pho
								 type: "POST",        //这里和php照应，这里填POST，php中就要用$_POST[]接受！
								traditional: true,  //序列化数据
						 data:{"prodata":strjson},  //传过去的参数，我传过去一个id，接受时php这样写：$data=$_POST["jsdata"];     变量名称当然可以更改。
						  dataType: 'html',
   //出错处理，一般加上，但其实传参没什么出错。
						   error: function (XMLHttpRequest, textStatus, errorThrown) {
             $("#p_test").innerHTML = "there is something wrong!";
               alert(XMLHttpRequest.status);
               alert(XMLHttpRequest.readyState);
               alert(textStatus);
       				 },  
					 success:function (data)  //成功后的函数，注意，这里接受php返回的参数
					{
						//注意！！由于传参时会进行base64加密，所以你穿过去的参数和返回的参数都会很长，如果我们不用json的话，参数就会丢失一									          部分，因为传递有长度限制！所以我们不得不涉及到一个麻烦的东西json数组！
						alert("ndlsn");
						alert(data);
				 // var ss;
				 // ss=eval("("+a+")");  //eval()可以执行字符串中的js代码！
					   //  ffa(ss);         //这是一个函数，用来得到传回来的参数。
					}      
									
		  });	
	
	}
</script>
</body>
</html>			