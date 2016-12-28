<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>百度地图POI信息爬取（任意多边形区域）</title>
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}  
</style>
<script type="text/javascript" src="jquery.js"></script>

 <script src="http://webapi.amap.com/maps?v=1.3&key=61ff806238466050f92d9eebf10270ca"></script>
 
<script type="text/javascript">
   
    var tf; //文件句柄
    var pointList = new Array();    //坐标列表
	var searchList=new Array();
    var bounds; //矩形区域
    var map;
    var poi;
    var tipsDom;    //运行提示DOM
    var drawingManager;
    window.onload=function()//用window的onload事件，窗体加载完毕的时候
    {
        var map = new AMap.Map("container", {
        resizeEnable: true
    });
			AMap.service(["AMap.PlaceSearch"], function() {
				var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
					pageSize: 5,
					type: '餐饮服务',
					pageIndex: 1,
					city: "010", //城市
					map: map,
					panel: "panel"
				});
				
				var cpoint = [116.405467, 39.907761]; //中心点坐标
				placeSearch.searchNearBy('', cpoint, 200, function(status, result,poiList) {
							alert(poiList.length)
				});
			});
         
    }
	function text(result){
			var n=result.getNumPois();
			var i=0;
		  for(i=0;i<result.getCurrentNumPois();i++)
             {			
			 			alert(result.getCurrentNumPois())

						var obj=new Object();
						var poi=result.getPoi(i);
                        obj.title =poi.title;
						obj.address=poi.address;
						//if(poi.tag!=null)	
						try{
							obj.type=poi.tags[0];
						}catch(e){
							obj.type=0;
						}
							
						//else
							//alert("null")
					//	obj.type=0;
						obj.lng=poi.point.lng;
						obj.lat=poi.point.lat;
								var strjson = JSON.stringify(obj);
					//	runTips(strjson);
						  
					
									$.ajax({ 
										  cache: false,
										   async: false,   //注意：这里设置为flase，即同步操作，因为我们不需要异步操作，只是传参而已，当然								                                  ，你也可以设置成异步。
							contentType: "application/x-www-form-urlencoded; charset=utf-8",  
						//这个要写对，和你的页面照应，你的页面是gb2312就填gb2312，我这里是utf8，否则中文传参会出错。
						  url: "test.php",  //这里填上你的php操作页面，即接受js参数的php页面。
					
							  //打上127.0.0.1/AR/test.pho
								 type: "POST",        //这里和php照应，这里填POST，php中就要用$_POST[]接受！
								traditional: true,  //序列化数据
						 data:{"jsdata":strjson},  //传过去的参数，我传过去一个id，接受时php这样写：$data=$_POST["jsdata"];     变量名称当然可以更改。
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
						alert(data);
				 // var ss;
				 // ss=eval("("+a+")");  //eval()可以执行字符串中的js代码！
					   //  ffa(ss);         //这是一个函数，用来得到传回来的参数。
					}      
									
								   });	
					}
					if(result.getPageIndex()<result.getNumpages-1){
						locsearch.gotoPage(result.getPageIndex())
					}
	}

    function getLocation(index)
    {	
			
        var geo = new BMap.Geocoder();
        if(index < pointList.length)
        {
            var p = pointList[index];
            runTips("解析节点：["+ p.lng +"," + p.lat + "]，进度：" + index + "/" + pointList.length);
            geo.getLocation(p,function(gr){
                if(gr != null)
                {
                    var address = gr.addressComponents.city+gr.addressComponents.district+gr.addressComponents.street   //只取城市、区县、街道名称
                   
                   
					
                    var spList = gr.surroundingPois;
                    for(i in spList)
                    {	
						
						
						var obj=new Object();
                        obj.title =spList[i].title;
						obj.address=spList[i].address;	
						try{
						obj.type=spList[i].tags;
						alert(obj.type)
						}catch(e){
							alert(e)
						};
						
						obj.lng=spList[i].point.lng;
						obj.lat=spList[i].point.lat;
								var strjson = JSON.stringify(obj);
					//	runTips(strjson);
						  
					
									$.ajax({ 
										  cache: false,
										   async: false,   //注意：这里设置为flase，即同步操作，因为我们不需要异步操作，只是传参而已，当然								                                  ，你也可以设置成异步。
							contentType: "application/x-www-form-urlencoded; charset=utf-8",  
						//这个要写对，和你的页面照应，你的页面是gb2312就填gb2312，我这里是utf8，否则中文传参会出错。
						  url: "test.php",  //这里填上你的php操作页面，即接受js参数的php页面。
					
							  //打上127.0.0.1/AR/test.pho
								 type: "POST",        //这里和php照应，这里填POST，php中就要用$_POST[]接受！
								traditional: true,  //序列化数据
						 data:{"jsdata":strjson},  //传过去的参数，我传过去一个id，接受时php这样写：$data=$_POST["jsdata"];     变量名称当然可以更改。
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
						alert(data);
				 // var ss;
				 // ss=eval("("+a+")");  //eval()可以执行字符串中的js代码！
					   //  ffa(ss);         //这是一个函数，用来得到传回来的参数。
					}      
									
								   });	
						
                         runTips("加入数据："+title);
                    }
                }else{
                    console.log(null);
                }
                gIndex++;
                getLocation(gIndex);
            });
        }else{
            drawingManager.open();  //开启地图的绘制模式
         //   runTips("处理完成.");
            tf.Close();
        }
    }
    //创建指定路径文件,并返回文件句柄

</script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.css" />
</head>
 
<body>
<div id="tips" style=" margin-left:10px; margin-top:5px;float:left">
BY Edward
</div>
<div align="right" style="padding:5px 10px; margin-left:10px">
密度：<input type="text" value="0.001" id = "step"style="width:50px"/>&nbsp;<input type="button" value="设置" onclick="setStep(this)"/>
</div>
 
<div id="container"></div> 
<script type="text/javascript">
 
</script>
</body>
</html>
