jQuery(document).ready(function($) {

	$('#pollinput').formerize();
	
	// Toggle Modify Form
	$(".modToggle").live('click', function() {
      var selectId      = this.id;
      var selectIdArray = selectId.split('-');
      var pollId        = selectIdArray[1];
		$('#modDiv-'+pollId).toggle();
	});
	
	// Toggle Choice Form
	$(".choiceToggle").live('click', function() {
      var selectId      = this.id;
      var selectIdArray = selectId.split('-');
      var pollId        = selectIdArray[1];
		$('#choiceDiv-'+pollId).toggle();
	});	
   
   $(".inputSubmit.pollButton").live('click', function() {
      var selectId      = this.id;
      var selectIdArray = selectId.split('-');
      var pollId        = selectIdArray[1];
      var pollButton    = selectIdArray[0];
      var aId           = $("input[name='aid-"+pollId+"']:checked").val();
      var pollUrl       = $("#spUrl-"+pollId).val();
      
		var dataRequest = ({action: pollButton, 
				              pollid: pollId,
				              aid: aId,
                          seed: Math.random()});
            
      $.ajaxSetup ({  
         cache: false,
         async: false
      });  
      
      // $("#tabs-2").html('<p><img src="' + wppgJsVars.pluginUrl + '/images/loader.gif"></p>');
      
      if (pollButton == 'display') {
         pollUrl = pollUrl+'ajax.php #divPoll-'+pollId;
      } else {
         pollUrl = pollUrl+'ajax.php';
      }
      
      $("#pollWrapper-"+pollId).load(pollUrl, dataRequest, function(response, status, xhr) {
         if (status == "error") {
            var msg = "<h2>Sorry but there was an error: try refreshing page.</h2>";
            $("#divPoll-"+pollId).empty().html(msg + xhr.status + " " + xhr.statusText);
         }
      });
   });
});