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

	include_once("../config.inc.php");
	require_once("../functions.inc.php");

	$simplepollurl = simplepollurl;

	echo pollheader('admin');
	connect();

	$subaction   = $_REQUEST['subaction'];
	$action      = $_REQUEST['action'];
	$name        = $_REQUEST['name'];
	$question    = $_REQUEST['question'];
	$orientation = $_REQUEST['orientation'];
	$pollid      = $_REQUEST['pollid'];
	$choice      = $_REQUEST['choice'];


	switch($subaction){
		case "add":
			$sql_result = query(sprintf("INSERT INTO poll VALUES (NULL,'%s','%s','%s')",
						mysql_real_escape_string($name),
						mysql_real_escape_string($question),
						'0'));
			break;
			
		case "modify":
			$sql_result = query(sprintf("UPDATE poll SET name='%s', question='%s' WHERE id='%s'",
						mysql_real_escape_string($name),
						mysql_real_escape_string($question),
						mysql_real_escape_string($pollid)));
			break;
			
		case "addchoice":
			$sql_result = query(sprintf("INSERT INTO choices VALUES (NULL,'%s','%s','%s')",
						mysql_real_escape_string($pollid),
						mysql_real_escape_string($choice),
						'0'));
			break;
		case "delete":
			$sql_result = query(sprintf("DELETE FROM poll WHERE id='%s' LIMIT 1",
							 mysql_real_escape_string($pollid)));
			break;
			
	}

	switch($action){	
		case "add":
			$admincontent .= '
			  <h2>'.$action.' poll</h2>
			  <form id="pollinput" name="pollinput" action="index.php" method="post">
				  <input type="hidden" name="subaction" value="'.$action.'" />
				  <input type="hidden" name="pollid" value="'.$pollid.'" />
				  <input type="text" title="Poll Name" name="name" value="'.$name.'" class="inputText" />
				  <input type="text" title="Poll Question" name="question" value="'.$question.'" class="inputText" />
				  <input type="submit" name="Submit" value="'.$action.' poll" class="inputSubmit" />
			  </form>
			 ';
			break;
			
		default;
	
			// view polls in admin page

			$poll_result = query("SELECT * FROM poll LIMIT 0,30");

			if (isset($poll_result)) {

				$numpolls = num_rows($poll_result);

				for ($i=0; $i<$numpolls; $i++) {

					$row			= fetch($poll_result);
					$pollid 		= $row['id'];
					$pollname  		= $row['name'];
					$pollquestion	= $row['question'];

					$admincontent .= '
							<div class="adminPolls">
								<h2>Poll Id: '.$pollid.' <span style="float:right; color: #FFF;">usage: &lt;?php $pollid = '.$pollid.'; include("simplepoll.php"); ?&gt;</span></h2>
							
								<ul class="pollOptions">
									<li>
										<a name="modLink-'.$pollid.'" id="modLink-'.$pollid.'" class="modToggle">modify poll</a>
										<div id="modDiv-'.$pollid.'" class="formModifyPoll">
											<form name="pollOptions'.$pollid.'" action="index.php" method="post">
												<input type="hidden" name="subaction" value="modify" />
												<input type="hidden" name="pollid" value="'.$pollid.'" />
												<input type="text" title="Poll Name" name="name" value="'.$pollname.'" class="inputText" />
												<input type="text" title="Poll Question" name="question" value="'.$pollquestion.'" class="inputText" />
												<input type="submit" name="Submit" value="submit" class="inputSubmit" />
											</form>
										</div>
									</li>
									<li>
										<a name="choiceLink-'.$pollid.'" id="choiceLink-'.$pollid.'" class="choiceToggle">add choice</a>
										<div id="choiceDiv-'.$pollid.'" class="formPollChoice">
										  <form name="pollchoice'.$pollid.'" action="index.php" method="post">
											  <input type="hidden" name="subaction" value="addchoice" />
											  <input type="hidden" name="pollid" value="'.$pollid.'" />
											  <input type="text" title="Choice" name="choice" class="inputText" />
											  <input type="submit" name="Submit" value="submit" class="inputSubmit" />
										  </form>										
										</div>
									</li>
									<li><a href="index.php?subaction=delete&amp;pollid='.$pollid.'" onclick="return confirm(\'Are you sure you want to delete this poll? '.$pollname.'\')">delete poll</a></li>
									
								</ul>
								

							</div>
							<div class="adminPoll">
							'.simplepoll($pollid).'
							</div>
							<div style="clear: both"></div>
					';
				}

			}
			break;
	}

?>
	<h2 class="newPoll">Create a New Poll</h2> 
	<form id="pollinput" name="pollinput" action="index.php" method="post">
		<input type="hidden" name="subaction" value="add" />
		<input type="text" title="Poll Name" name="name"  class="inputText" />
		<input type="text" title="Poll Question" name="question"  class="inputText" />
		<input type="submit" name="Submit" value="Create New Poll" class="inputSubmit" />
	</form>
	
    <?php echo $admincontent; ?>

<?php
   echo $error[0];

   close();
	echo pollfooter('admin');

?>