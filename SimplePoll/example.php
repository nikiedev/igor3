<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>SimplePoll by Free-PHP.net</title>
   <meta name="description" content="" />
   <meta name="keywords" content="" />
   <meta name="revisit-after" content="7days" />
   <meta name="robots" content="index, follow" />

   <link rel="stylesheet" type="text/css" media="all" href="css/default.css" />
   <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
   <script type="text/javascript" src="js/jquery.formerize-0.1.js"></script>
   <script type="text/javascript" src="js/simplepoll.js"></script>
   
</head>

<body>
	 
		 <div id="wrapper">
		 
			 <h1>Simple Poll</h1>

	       <?php
          $pollid = 1; // pollid is listed on admin page poll display
          include("simplepoll.php");
          ?>
       </div>
	
</body>
</html>