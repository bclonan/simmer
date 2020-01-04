<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Spacegallery</title>
    <link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/spacegallery.css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/custom.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/eye.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/spacegallery.js"></script>
    <script type="text/javascript" src="js/layout.js"></script>
</head>





<body>
    

    
    <div class="wrapper">
       
        <ul class="navigationTabs">
            <li><a href="#about" rel="about"></a></li>
            
        </ul>
        
               
	    <div id="myGallery" class="spacegallery">
		
		<?php
		    include_once "sql_connect.php";
		    include_once "functions.php";
		    $userid = $_SESSION['id'];
		    
		    $q = mysql_query("SELECT * FROM photos");
		    while ($photos = mysql_fetch_array($q))
		    {
			$photoURL = $photos['photo'];
			if ($photos['userid'] == $userid)
			{
			    print "<img src='$photoURL' alt=''>";
			}
			
		    }
		?>
	    
		    <img src="carouselimages/bw3.jpg" alt="" />
		    <img src="carouselimages/lights3.jpg" alt="" />
		    <img src="carouselimages/fail.jpg" alt="" />
		    <img src="carouselimages/bw2.jpg" alt="" />
		    <img src="carouselimages/lights2.jpg" alt="" />
		    <img src="carouselimages/bw1.jpg" alt="" />
		    <img src="carouselimages/lights1.jpg" alt="" />
	    </div>
            
    </div>
</body>
</html>