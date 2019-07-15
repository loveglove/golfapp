<!DOCTYPE html>
<html>
  <head>
    <style>
    p {
      font-family: verdana;
      font-size: 400px;
      color: #FFFFFF;
    }
    </style>
    <title>Compass</title>
    <script>
    // Get event data
    function deviceOrientationListener(event) {
      var alpha    = event.alpha; //z axis rotation [0,360)
      var beta     = event.beta; //x axis rotation [-180, 180]
      var gamma    = event.gamma; //y axis rotation [-90, 90]
      //Check if absolute values have been sent
      if (typeof event.webkitCompassHeading !== "undefined") {
        alpha = event.webkitCompassHeading; //iOS non-standard
        var heading = alpha
        document.getElementById("heading").innerHTML = heading.toFixed([0]);
      }
      else {
        alert("Your device is reporting relative alpha values, so this compass won't point north :(");
        var heading = 360 - alpha; //heading [0, 360)
        document.getElementById("heading").innerHTML = heading.toFixed([0]);
      }
      
      // Change backgroud colour based on heading
      // Green for North and South, black otherwise
      if (heading > 359 || heading < 1) { //Allow +- 1 degree
        document.body.style.backgroundColor = "green";
        document.getElementById("heading").innerHTML = "N"; // North
      }
      else if (heading > 179 && heading < 181){ //Allow +- 1 degree
        document.body.style.backgroundColor = "green";
        document.getElementById("heading").innerHTML = "S"; // South
      } 
      else { // Otherwise, use near black
        document.body.style.backgroundColor = "#161616";
      }
    }
    
    // Check if device can provide absolute orientation data
    if (window.DeviceOrientationAbsoluteEvent) {
      window.addEventListener("DeviceOrientationAbsoluteEvent", deviceOrientationListener);
    } // If not, check if the device sends any orientation data
    else if(window.DeviceOrientationEvent){
      window.addEventListener("deviceorientation", deviceOrientationListener);
    } // Send an alert if the device isn't compatible
    else {
      alert("Sorry, try again on a compatible mobile device!");
    }
    </script>
  </head>
  <body>
    <br><br>
    <p id="heading" style="text-align:center"></p>
  </body>
</html>