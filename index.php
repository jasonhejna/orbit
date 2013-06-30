<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div id="minmaxLL"></div>
<div id="movingDot"></div>

<script type="text/javascript">

//document.getElementById("minmaxLL").innerText += minmaxLatLon();
boxBuilder(minmaxLatLon());

function boxBuilder(mathInfo){
//Latitudes range from -90 to 90.
//Longitudes range from -180 to 180.

//get each value from our array at the end of the minmaxLatLon function
    // mathInfo[0] : greatestLat - leastLat
    // mathInfo[1] : greatestLon - leastLon
    // mathInfo[2] : greatestLat
    // mathInfo[3] : greatestLon
    // mathInfo[4] : leastLat
    // mathInfo[5] : leastLon

// find the element's dimensions, alternatively pass in the width/hight of anything (be creative)
var elementHeight = document.getElementById("minmaxLL").clientHeight;
var elementWidth = document.getElementById("minmaxLL").clientWidth;
//console.log(elementHeight, elementWidth);


//console.log(latWidthRatio, lonHeightRatio);
var gpsArray = getAndDecodeJSON();
var fastArray = new Array();
var thisPixel;
for (var i = 0; i < gpsArray.length; i++) {

    for(latlon in gpsArray[i]){
        if(latlon == "lat"){
            thisPixel = Math.round((gpsArray[i][latlon] - mathInfo[4]) * (800 / (mathInfo[2] - mathInfo[4])));

            //document.getElementById("movingDot").style.top = LatDiff + "px";

        }
        if(latlon == "lon"){
            thisPixel = Math.round(((gpsArray[i][latlon] - mathInfo[5])) * (800 / (mathInfo[3] - mathInfo[5])));

            //document.getElementById("movingDot").style.left = LonDiff + "px";
        }
    }
    
    
    fastArray[i] = thisPixel;
}
playRoute(fastArray);
} //end box builder function


function playRoute(fastArray){
for (var i = 0; i < fastArray.length; i++) {
console.log(fastArray[i]);

if(i%2 == 0) {
    setTimeout("moveItem("+u+","+k+")",1000);
}else {
    setTimeout("moveItem("+u+","+k+")",1000);
}
}

}

function plotRoute(){
    document.getElementById("movingDot").style.top = lat + "px";
    document.getElementById("movingDot").style.left = lon + "px";  
}

function getAndDecodeJSON(){

var incomingData = <?php echo file_get_contents('finiteGPS_TestRace1.json'); ?>;
//console.log(incomingData);

var stringJSON = JSON.stringify(incomingData);
var gpsArray = JSON.parse(stringJSON);
//console.log(gpsArray);
return gpsArray;

}

function minmaxLatLon(){

//Get an Array of GPS data back by calling the getAndDecodeJSON function
var gpsArray = getAndDecodeJSON();

//defining variables for our for loop
 var j=0;
 var greatestLat;
 var leastLat;
 var greatestLon;
 var leastLon;
for (var i = 0; i < gpsArray.length; i++) {
    //console.log(gpsArray[i]);

    for(latlon in gpsArray[i]){
    	
    	if(latlon == "lat"){
    		//console.log("lat");
    		if(j == 0){
    			greatestLat = gpsArray[i][latlon];
    			leastLat = gpsArray[i][latlon];
    		}
    		if(j%2 == 0){
	    		if(greatestLat < gpsArray[i][latlon]){
	    			greatestLat = gpsArray[i][latlon];
	    		}
	    		if(leastLat > gpsArray[i][latlon]){
	    			leastLat = gpsArray[i][latlon];
	    		}
    		}
    	}else if(latlon == "lon"){
    		if(j == 1){
    			greatestLon = gpsArray[i][latlon];
    			leastLon = gpsArray[i][latlon];
    		}
    		if(j%2 != 0){
	    		if(greatestLon < gpsArray[i][latlon]){
	    			greatestLon = gpsArray[i][latlon];
	    		}
	    		if(leastLon > gpsArray[i][latlon]){
	    			leastLon = gpsArray[i][latlon];
	    		}
    		}
    	}else{
    		console.log("parse error");
    	}

    	j++;
	}

}
    //make an array, which we will return
    var dataReturnArray = new Array();
    dataReturnArray[0] = (greatestLat - leastLat).toFixed(6);
    dataReturnArray[1] = (greatestLon - leastLon).toFixed(6);
    dataReturnArray[2] = greatestLat;
    dataReturnArray[3] = greatestLon;
    dataReturnArray[4] = leastLat;
    dataReturnArray[5] = leastLon;

    return dataReturnArray;

}//end minmaxLatLon func

</script>
</body>
</html>