<?php
/*
 * Simple Poll
 * 
 * Created by: CodeMunkyX                            
 * Modified by: Doni Ronquillo
 * 
 * Copyright (c) 2011 http://www.free-php.net
 *
 * GPLv3 - (see LICENSE-GPLv3 included in folder)               
 *                                                                        
 * GalleryGenerator is free software you can redistribute it and/or modify      
 * it under the terms of the GNU General Public License as published by   
 * the Free Software Foundation, either version 3 of the License, or      
 * (at your option) any later version.                                    
 *                                                                        
 * This program is distributed in the hope that it will be useful,        
 * but WITHOUT ANY WARRANTY; without even the implied warranty of         
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          
 * GNU General Public License for more details.                                                                                               
 * 
 */

function connect() {

  global $conn;

  $conn = mysql_connect( hostname, username, password  );

  if( !$conn ) {
	  echo "Couldn't connect to database!<BR>";
  }

    mysql_select_db(dbname);
}

function query($query) {
  // do query

  global $conn;

  $result = mysql_query($query, $conn);


  if (!$result) {
      echo "Invalid SQL: ".$query." :: ".$conn;
  }

  return $result;
}

function fetch($result) {

   if (isset($result)) {

     $row = mysql_fetch_array($result);

   } else {

     echo "Invalid Query Fetch";

   }

    return $row;
}

function num_rows($result) {

   // returns number of rows in query
   return mysql_num_rows($result);
}

function close() {

  // closes connection to the database

  return mysql_close();
}

function dooutput($template) {

    echo $template;

}

function storeoutput($template) {

    global $admincontent;

    $admincontent .= $template;

}

function gettemplate($templatedir,$template,$endung="html") {

    return str_replace("\"","\\\"",implode("",file($templatedir.$template.".".$endung)));

}

function pollheader($header_place = '') {
  if ($header_place == 'admin'){
	  $jspath = "../js/";
	  $csspath = "../css/";
  } else {
	  $jspath = "js/";
	  $csspath = "css/";
  }
  $content = '
	 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	 <html xmlns="http://www.w3.org/1999/xhtml">
	 <head>
	 
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		 <title>SimplePoll by Free-PHP.net</title>
		 <meta name="description" content="" />
		 <meta name="keywords" content="" />
		 <meta name="revisit-after" content="7days" />
		 <meta name="robots" content="index, follow" />
	 
		 <link rel="stylesheet" type="text/css" media="all" href="'.$csspath.'default.css" />
		 
		 <script type="text/javascript" src="'.$jspath.'jquery-1.5.2.min.js"></script>
		 <script type="text/javascript" src="'.$jspath.'jquery.formerize-0.1.js"></script>
		 <script type="text/javascript" src="'.$jspath.'simplepoll.js"></script>
		 
	 </head>
	 
	 <body>
	 
		 <div id="wrapper">
		 
			 <h1>Simple Poll</h1>';
		
		return $content;
}

function pollfooter($footer_place = '') {
  $content = '
	</div>
	
</body>
</html>';

  return $content;
}

function results($pollid = 0) {

	$simplepollurl = simplepollurl;
	
	$pollid = ($pollid > 0) ? $pollid : $_REQUEST['pollid'];

	$sql_result = query(sprintf("SELECT * FROM poll WHERE id = '%s'",
				mysql_real_escape_string($pollid)));


	if (isset($sql_result)) {

		$numpolls = num_rows($sql_result);

		for ($i=0; $i<$numpolls; $i++) {

			$row				= fetch($sql_result);
			$numpollvotes 		= $row[votes];
			$pollquestion    	= $row[question];
			$pollname        	= $row[name];

		}
	}

	$sql_result = query(sprintf("SELECT * FROM choices WHERE pollid = '%s'",mysql_real_escape_string($pollid)));


	if (isset($sql_result)) {

		$numpolls = num_rows($sql_result);

		for ($i=0; $i<$numpolls; $i++) {

			$row=fetch($sql_result);

			$width   = round(($row[votes]/$numpollvotes)*200);
			$percent = round(($row[votes]/$numpollvotes)*100);

			$pollresult .= '
				<p>
					<strong>' . $row[choice] . '</strong> <small>(' . $row[votes] . ' votes)</small>';
					
		   if ($row[votes] == 0) {
			    $pollresult .= '
					<span class="emptyPollBar" style="width:100%; display: block;">0 votes</span>
					';
			} else {
		       $pollresult .= '
					<span class="pollBar" style="width:'.$percent.'%; display: block;">&nbsp;</span>
					';
			}
		   $pollresult .= '
				</p>
			';
		}
	}
	
   $content = '
	<div id="divPoll-'.$pollid.'" class="poll">
	<h2>'.$pollname.'</h2>
	<p>'.$pollquestion.'</p>

	<h3>Total Votes: ' . $numpollvotes . '</h3>

	'.$pollresult.'
	<input type="hidden" id="spUrl-' . $pollid . '" name="spUrl" value="'.simplepollurl.'" />
	<div class="pollButtons"><input type="button" id="display-'.$pollid.'" name="display-'.$pollid.'" value="Back" class="inputSubmit pollButton" /></div>
	<div style="clear: both;"></div>
	<p><a href="http://www.free-php.net/622/simple-poll/" target="_blank">get a free poll</a></p></div>';
	
	return $content;
}

function simplepoll($pollid = 0) { 
  // view polls in admin page
 
  $sql_result = query(sprintf("SELECT * FROM poll WHERE id='%s'",
					 mysql_real_escape_string($pollid)));
 
  if (isset($sql_result)) {
 
	  $numpolls = num_rows($sql_result);
 
	  for ($i=0; $i<$numpolls; $i++) {
 
		  $row=fetch($sql_result);
 
		  $pollid	 		= $row[id];
		  $pollquestion   = $row[question];
		  $pollname       = $row[name];
 
		  $sql_result2 = query(sprintf("SELECT * FROM choices WHERE pollid = '%s' ORDER BY id",mysql_real_escape_string($row[id])));
 
		  $pollanswers = '<ul class="simplePoll">';
 
		  if (isset($sql_result2)) {
 
			  $numanswers = num_rows($sql_result2);
 
			  for ($x=0; $x<$numanswers; $x++) {
 
				  $row2=fetch($sql_result2);
 
				  if ($x == 0) {
					  $selected = 'checked="checked"';
					  $dfltval  = $row2[id];
				  } else {
					  $selected = "";
				  }
 
				  $pollanswers .= "<li><input type=\"radio\" name=\"aid-".$pollid."\" value=\"".$row2[id]."\" ".$selected." />\n";
				  $pollanswers .= '' . $row2[choice] . '</li>';
 
			  }
			  
		  } else {
		  
			 $pollanswers .= "<li>No options have been entered</li>";
			 
		  }
 
		  $pollanswers .= "</ul>\n";
 
		  if ($numanswers < 1) {
			  $pollanswers = "You need to add an option.";
		  }
 
        $content = '
		   <div id="pollWrapper-'.$pollid.'">
			 <div id="divPoll-'.$pollid.'" class="poll">
				 <form name="poll-'.$pollid.'" action="">
					 <input type="hidden" id="spUrl-' . $pollid . '" name="spUrl" value="'.simplepollurl.'" />
					 <h2>'.$pollname.'</h2>
					 <p>'.$pollquestion.'</p>
				  
					 '.$pollanswers.'
						
					 <div class="pollButtons">
						 <input type="button" id="vote-'.$pollid.'" name="vote-'.$pollid.'" value="Vote" class="inputSubmit pollButton" />
						 <input type="button" id= "results-'.$pollid.'" name="results-'.$pollid.'" value="View Results" class="inputSubmit pollButton" />
					 </div>
					 
					 <div style="clear: both;"></div>
					 
					 <p class="powered"><a href="http://www.free-php.net/622/simple-poll/" target="_blank">get a free poll</a></p>
					 
				 </form>
			 </div>
			</div>
		';
			
			return $content;
	  }
 
  }
  
}

function vote($pollid = 0, $aid = 0) {
  
  $pollid      = ($pollid > 0) ? $pollid : $_REQUEST['pollid'];
  $aid         = ($aid > 0) ? $aid : $_REQUEST['aid'];
/*
  if ($_COOKIE["simplepoll".$pollid] == '') {
	 // This cookie is good for an hour
	 setcookie("simplepoll".$pollid, $pollid, time() + 3600);
	 // setcookie("simplepoll$pollid", "$pollid");
  }
  else {
	 echo results($pollid);
	 exit;
  }
*/
  $sql_result = query(sprintf("SELECT * FROM poll WHERE id = '%s'",mysql_real_escape_string($pollid)));
  
  
  if (isset($sql_result)) {
  
	$numpolls = num_rows($sql_result);
 
	for ($i=0; $i<$numpolls; $i++) {
  
		$row=fetch($sql_result);
  
		$numpollvotes = $row[votes] + 1;
		$pollquestion = $row[question];
		$pollname     = $row[name];
	}
  }
  
  $sql_result = query(sprintf("SELECT * FROM choices WHERE (id='%s' AND pollid='%s')",
					 mysql_real_escape_string($aid),mysql_real_escape_string($pollid)));
  
  
  if (isset($sql_result)) {
  
	$numpolls = num_rows($sql_result);
 
	for ($i=0; $i<$numpolls; $i++) {
  
		$row=fetch($sql_result);
  
		$numchoicevotes = $row[votes] + 1;
  
	}
  }
  
  $pollvote   = query(sprintf("UPDATE poll SET votes='%s' WHERE id='%s'",
										mysql_real_escape_string($numpollvotes),mysql_real_escape_string($pollid)));
  $choicevote = query(sprintf("UPDATE choices SET votes='%s' WHERE (id='%s' AND pollid='%s')",
										mysql_real_escape_string($numchoicevotes),mysql_real_escape_string($aid),mysql_real_escape_string($pollid)));
	
  $content .= results($pollid);
  
  return $content;
}
?>