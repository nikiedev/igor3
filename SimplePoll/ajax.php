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

	include("config.inc.php");
	include("functions.inc.php");
   
	connect();
	
	$pollid = ($pollid > 0) ? $pollid : $_REQUEST['pollid'];
	
	$defaultmsg = "<h2>Sorry, this page cannot be accessed directly.";
	
	if (isset($_REQUEST['action'])) {
		switch ( $_REQUEST['action'] ) {
			case 'results' :
				echo results($pollid);
				break;
			case 'vote' :
				echo vote($pollid);
				break;
			case 'display' :
				echo simplepoll($pollid);
				break;
			default :
			   echo $defaultmsg;
		}
	} else {
		echo $defaultmsg;		
	}
	
	close();

?>