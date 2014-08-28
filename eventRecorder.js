function logEvent(subject_name, event_name, async) {
	page_name = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
   if(!page_name) page_name='index.php';

	now = new Date();
	current_time = getCurrentTime(now);
	current_time_ms = now.getTime();

	$.ajax({url: "recordEvent.php", 
			  data: {"current_time":current_time,
			 			"current_time_ms":current_time_ms,
						"page_name":page_name, 
			  			"subject_name":subject_name, 
			  			"event_name":event_name
					  },
				'async': async
		    });
}

function getCurrentTime(now) {
	a = now;
	formatted = a.getFullYear()+" "+(a.getMonth()+1)+"/"+a.getDate()+" "+a.getHours() + ":" + a.getMinutes() + ":" + a.getSeconds() + ":" + a.getMilliseconds();
	return formatted;
}

//stuff to do when the page loads
$(document).ready(function() {
	logEvent('page','load');

	$('a, button').bind("click",function(e) {
		async = true;
      if($(this).attr('href') != '#' || $(this).attr('type') == 'submit') {
			async = false;
		}

		logEvent($(this).attr('id'),'click', async);
	});
}); 
