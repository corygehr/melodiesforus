<!-- Some credit to http://24ways.org/2009/have-a-field-day-with-html5-forms/ for css -->

<link rel="stylesheet" type="text/css" href="./survey/css/surveyStyle.css">
<script src="//code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="./survey/js/jquery.validate.js"></script>
<script type="text/javascript" src="./survey/js/jquery.cookie.js"></script>
 


<script>
$(document).ready(function(){
	$('form#survey input, form textarea, form select').not([type="submit"]).addClass('required');

	$("form#survey").validate({
		errorPlacement: function(error, element) {
			if(error.html() == 'This field is required.') 
				error.html('This question is required.');
			
			type = $(element[0]).attr('type');
			if(type=='text' || !type) {
				error.appendTo(element.parent());
			}
			else {
         	error.insertAfter($('label[for="'+element.attr('id')+'"]'));
			}

			var errorMsgTop = $('.errorMsgTop');
			//errorMsgTop.html('<span style="color:#AA0000">Questions in red are required and have not been filled out. Please fill in these questions.</span>');
		},
		rules: {
			disconcerting_expl: {
				required: false,
			},
			age: {
				required: true,
				digits: true,
				minlength:2,
				maxlength:2,
			} 
		},  
	});

});
</script>               
</head>

<body>


		<style>
		.input-block-level { clear:none; }
		label.error { display:inline; padding-left:5px; color:red }
		</style>     

<form name='survey' id='survey' method='GET'>

<?php
if(array_key_exists('lab', $_GET)) {
	echo "<input type='hidden' id='lab' name='lab' value='lab'>\n";
}

require_once(dirname(__FILE__).'/SurveyParts.class.php');

$s = new SurveyParts();
$s->printSections();


?>

<fieldset>
<input type='hidden' name='prevPage' value='survey' />
<button type='submit' value='Submit'>Submit</button>
</fieldset>
</form>
