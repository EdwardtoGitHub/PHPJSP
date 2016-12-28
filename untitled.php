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

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=91a73a33c8964682fdba3f89dc96f279"></script>

 
<!--加载鼠标绘制工具-->
<script type="text/javascript" src="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.js"></script>
<script type="text/javascript">
    try{
        var fso = new ActiveXObject("Scripting.FileSystemObject");//获取对象
    }catch(e)
    {
        alert(e+"ActiveXObject对象创建失败，数据将无法保存。");  
    }
    var tf; //文件句柄
    var pointList = new Array();    //坐标列表
	var searchList=new Array();
    var bounds; //矩形区域
    var step = 0.00005;   //密度
    var map;
    var poi;
    var tipsDom;    //运行提示DOM
    var drawingManager;
    window.onload=function()//用window的onload事件，窗体加载完毕的时候
    {
        tipsDom = document.getElementById("tips");
        map = new BMap.Map('container');
        poi = new BMap.Point(113.9430620000,22.5406900000);
        map.centerAndZoom(poi, 16);
        map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
        map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
        map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
        map.enableScrollWheelZoom();
		try{
         locsearch=new BMap.LocalSearch(poi);
		 locsearch.searchNearby("餐饮",poi,10000);
		 locsearch.setPageCapacity(1000);
		 locsearch.setSearchCompleteCallback(text);
		// alert(locsearch.getStatus())
		}catch(e){
		   alert(e);
		}
		
       newDrawingManager()
         
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
    function newDrawingManager()
    {
        var styleOptions = {
            strokeColor:"red",    //边线颜色。
            fillColor:"red",      //填充颜色。当参数为空时，圆形将没有填充效果。
            strokeWeight: 3,       //边线的宽度，以像素为单位。
            strokeOpacity: 0.8,    //边线透明度，取值范围0 - 1。
            fillOpacity: 0.6,      //填充的透明度，取值范围0 - 1。
            strokeStyle: 'solid' //边线的样式，solid或dashed。
        }
        //实例化鼠标绘制工具
        drawingManager = new BMapLib.DrawingManager(map, {
            isOpen: true, //是否开启绘制模式
            drawingToolOptions: {
                anchor: BMAP_ANCHOR_TOP_RIGHT, //位置
                offset: new BMap.Size(5, 5), //偏离值
                scale: 0.8 //工具栏缩放比例
            },
            circleOptions: styleOptions, //圆的样式
            polylineOptions: styleOptions, //线的样式
            polygonOptions: styleOptions, //多边形的样式
            rectangleOptions: styleOptions //矩形的样式
        });
        drawingManager.setDrawingMode(BMAP_DRAWING_POLYLINE);
        drawingManager.disableCalculate();
        drawingManager.addEventListener('overlaycomplete', overlaycomplete);
        drawingManager.open();  
    }
     
    var overlaycomplete =function (e){
        //绘制完成回调函数
        runTips("图形绘制完成.");
        var o = e.overlay;
        bounds = o.getBounds();
        drawingManager.close();//关闭地图的绘制状态
        hanPoint2(bounds);
    }
     
     
    function hanPoint2(bounds)
    {
        runTips("开始处理.");
        var southWest = bounds.getSouthWest();  //矩形区域的西南角
        var northEast = bounds.getNorthEast();  //矩形区域的东北角
        var startX = southWest.lat;     //X轴开始循环值
        var startY = southWest.lng;     //Y轴开始循环值
        var endX = northEast.lat;       //X轴结束循环值
        var endY = northEast.lng;       //Y轴结束循环值
		alert("southwest"+southWest+"\n"+"northEast"+northEast+"\n"+"startx"+startX+"\n"
		+"startY"+startY+"\n"+"endX"+endX+"\n"+"endY"+endY);
        if(southWest.equals(northEast))
        {
            //点
            pointList.push(new BMap.Point(startY,startX));
        }else if(startX == endX || startY == endY)
        {
            //线 
            if(startX == endX){
                for(startY = southWest.lng;startY <= endY; startY += step)
                {
                    pointList.push(new BMap.Point(startY,startX));
                }
            }else{
                for(startX = southWest.lat;startX <= endX;startX += step)
                {
                    pointList.push(new BMap.Point(startY,startX));
                }
            }
        }else{
             
            //面
            var boundsList = cuttingBounds(bounds);
            if(boundsList.length > 1)
            {
                for( i in boundsList)
                {
                    var b = boundsList[i];
                    if(bounds.containsBounds(b))
                    {
                        //完全包含
                        pointList = pointList.concat(getPointByBounds(b));
                    }else{
                        //不完全包含,进行过滤
                        pointList = pointList.concat(containsPonint(getPointByBounds(b)));  
                    }
                     
                }
            }else{
                //自身区域,需过滤
                pointList = pointList.concat(containsPonint(getPointByBounds(boundsList[0])));
            }
        }
        geocoder();
    }
     
    //切割区域,返回切割后的区域列表
    function cuttingBounds(bounds)
    {
        runTips("区域切割.");
        var lengX = step * 10;  //切割长度X
        var lengY = step * 10;  //切割长度Y
        var boundsList = new Array();
        var southWest = bounds.getSouthWest();  //矩形区域的西南角
        var northEast = bounds.getNorthEast();  //矩形区域的东北角
        var startX = southWest.lat;     //X轴开始循环值
        var startY = southWest.lng;     //Y轴开始循环值
        var endX = northEast.lat;       //X轴结束循环值
        var endY = northEast.lng;       //Y轴结束循环值
        if(endX - startX >= lengX || endY - endX >= lengY)
        {
            boundsList.push(bounds);
            return boundsList;
        }
        while(startX < endX)
        {
            var tempX = startX + lengX;
            if(tempX >= endX)
            {
                //超出范围
                tempX = endX;
            }
            startY = southWest.lng;
            isY = true;
            while(startY < endY)
            {
                var tempY = startY + lengY;
                if(tempY >= endY)
                {
                    //超出范围
                    tempY = endY;
                }
                boundsList.push(new BMapLib.Bounds(new BMapLib.Point(startY,startX),new BMapLib.Point(tempY,tempX)));
                startY = tempY + step;
            }
            startX = tempX + step;
        }
        return boundsList;
    }
    //获取矩形区域内的所有点
    function getPointByBounds(bounds)
    {
        runTips("获取点数据.");
        var southWest = bounds.getSouthWest();  //矩形区域的西南角
        var northEast = bounds.getNorthEast();  //矩形区域的东北角
        var startX;     //X轴开始循环值
        var startY;     //Y轴开始循环值
        var endX = northEast.lat;       //X轴结束循环值
        var endY = northEast.lng;       //Y轴结束循环值
        var pl = new Array();
        for(startX = southWest.lat;startX <= endX;startX += step)
        {
            for(startY = southWest.lng;startY <= endY; startY += step)
            {
                pl.push(new BMap.Point(startY,startX));
            }
        }
        return pl;
    }
    //过滤此区域内的点
    function containsPonint(list)
    {
        runTips("点有效性检查.");
        var l = new Array();
        for(i in list)
        {
            var p = list[i];
            if(bounds.containsPoint(p))
            {
                //在此区域内
                l.push(p);
            }
        }
        return l;
    }
    //如果点未处理过且在矩形区域内
    function isPoint(point)
    {
        if(bounds.containsPoint(point) == false)
        {
            //不在区域内
            return false;
        }
        for(i in pointList)
        {
            if(pointList[i].equals(point))
            {
                //列表中已存在
                return false;
            }
        }
        return true;
    }
    var gIndex =0;
    //逆地址解析
    function geocoder()
    {
        runTips("准备解析数据.");
        if(pointList != null && pointList.length > 0)
        {
			var ForWriting=2;
				
				alert(pointList.length);
           for(var i =0;i<1000;i++)  //地址解析线程
           {
           setTimeout(function(){
              getLocation(gIndex);
               },100)
                gIndex++;
                 
            }	
             
        }
    }
    //解析列表地址,同步
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
    function createFile(path)
    {
        if(fso != null)
        {
            tf = fso.CreateTextFile(path, true);//创建一个文件夹
        }
       return tf;
        
    }
    //设置爬取密度
    function setStep(t)
    {
         
            try{
            var temp = parseFloat(document.getElementById("step").value);
            if(temp > 0)
            {
                step = temp;
                alert("设置成功.");
            }else{
                alert("值必需大于0.");   
            }
        }catch(e)
        {
            alert("设置失败，请检查输入值的有效性。")   
        }
    }
     
    //运行信息提示
    function runTips(message)
    {
        tipsDom.innerHTML = message;
    }
    //清除绘制
    function clearOverlays()
    {
        map.clearOverlays();
        drawingManager.close();
        newDrawingManager();
    }
</script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.css" />
</head>
 
<body>
<div id="tips" style=" margin-left:10px; margin-top:5px;float:left">
左键单击开始绘制多边形，双击完成绘制。使用左侧工具栏改变地图位置，结果数据保存在c:\poi.txt，自行使用工具处理。此程序只进行了简单的测试。 By：悠树
</div>
<div align="right" style="padding:5px 10px; margin-left:10px">
密度：<input type="text" value="0.001" id = "step"style="width:50px"/>&nbsp;<input type="button" value="设置" onclick="setStep(this)"/>
</div>
 
<div id="container"></div> 
<script type="text/javascript">
 
</script>
</body>
</html>
