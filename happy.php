<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>数据库 POI点抓取JS爬虫实现</title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=61ff806238466050f92d9eebf10270ca&plugin=AMap.PlaceSearch"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
<div id="container"></div>
<script type="text/javascript">
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
    var placeSearch = new AMap.PlaceSearch();  //构造地点查询类
    //详情查询
	placeSearch.setCity("深圳");
	placeSearch.setCityLimit(true) 
	placeSearch.setPageIndex(1);
	placeSearch.setPageSize(50);
//var center=new	AMap.LngLat(113.9430620000,22.5406900000) //东经­113°46'～114°37',北纬22°27'～22°52'
for(var i=0;i<50;i++){
	for(var j=0;j<50;j++){
		try{
		var center=new	AMap.LngLat(113.9430620000+i*0.0002,22.5406900000+j*0.0002);
		 placeSearch.searchNearBy("",center,50,function(status,result){
				if (status === 'complete' && result.info === 'OK') {
					placeSearch_CallBack(result);
				   }else{
						//alert(status+result.info)忘记加key了
				   }
				
	 	 }) 
		}catch(e){
				alert(e)	
		}
	}
}
	 
    //placeSearch.getDetails("B000A83U0P", function(status, result) {
      //  if (status === 'complete' && result.info === 'OK') {
        //    placeSearch_CallBack(result);
        //}
   // });
    //回调函数
    function placeSearch_CallBack(data) {
        var poiArr = data.poiList.pois;
        //添加marker
		alert(data.poiList.count)
    		 //alert( poiArr[0].location.toString())
    }
</script>
</body>
</html>			