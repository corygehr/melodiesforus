<?php

class SurveyParts {
	public $sections;

	function getSongs() {
		$songstring = file_get_contents(dirname(__FILE__).'/../songs/song_info.txt', true);
		$songs = array();
		foreach(explode("\n",$songstring) as $line) {
			$split = explode(":", $line);
			if(count($split)>1){
				$songs[] = $split[1];
			}
		}
		return array_merge(array(''),$songs);
	}
	function fillArrays() {
		$integrityPre = 'Please answer the following questions exactly as asked.';
		$integrity = array('pre' => $integrityPre, 'title' => 'Additional questions',
		'data' => array(
		 'check5' => array('label' => 'Please select the rightmost option.', 'type' => 'likert', 'size' => '5'),
		 'check3' => array('label' => 'Please select the middle option.', 'type' => 'likert', 'size' => '5'),
		 'check1' => array('label' => 'Please select the leftmost option.', 'type' => 'likert', 'size' => '5')

		));
		$demoPre = 'Please answer the following demographic questions.';
		$demo = array('pre' => $demoPre, 'title' => 'Survey',
		'data' => array(
			'post_mturk_id' => array('label' => "What is your Mechanical Turk ID?"),
			'post_age' => array('label' => 'What is your age (in years)?'),
			'post_gender' => array('label' => 'What is your gender?', 'type' => 'radio', 'options' => array('Male', 'Female', 'Decline to answer')),
			'post_education' => array('label' => 'What is the highest level of education that you have completed?', 'type' => 'radio', 'options' => array('Some high school', 'High school', 'Some college', 'Two year college degree', 'Four year college degree', 'Graduate or professional degree')),
			'post_country' => array('label' => 'What is your country of origin?', 'type' => 'radio', 'options' => array('United States', 'India', 'Canada', 'None of the above'))
			));


		$times = array('', 'Daily', 'Weekly', 'Monthly', 'Less than once per month', 'Never');

		$shopping =  array('title'=>'Shopping questions',
		'data'=>array(
			'shopping_whichSong' => array('label' => 'Which song did you purchase?', 'type' => 'select', 'options' => $this->getSongs(),'numbered'=>true),
			'shopping_oftenPurchase' => array('label' => 'How often do you purchase music online?', 'type' => 'select', 'options' => $times),
			'shopping_spendPerMonth'=> array('label'=> 'How much do you spend on average per month on music purchases? $'),
			'shopping_oftenStreaming' => array('label' => 'How often do you stream music online?', 'type' => 'select', 'options' => $times),
			'disconcerting_yn' => array('label' => 'Was anything in this task disconcerting or troubling to you?', 'type' => 'select', 'options' => array('','Yes - will describe below', 'No')),
			'disconcerting_expl'=> array('label'=> 'Why did you choose the above answer?', 'type'=>'textarea'),
		));



		$scamAvoid =  array('title'=>'Online experience questions',
		'data'=>array(
			'scamAvoid_creditCard' => array('label' => 'How often do you check your credit card statements?', 'type' => 'select', 'options' => $times),
			'scamAvoid_finePrint' => array('label' => 'How often do you read privacy statements online?', 'type' => 'select', 'options' => $times),
		));
 
		$badExp =  array('title'=>'Online experience questions',
		'data'=>array(
			'badExp_wrongProductCount' => array('label' => 'How many times have you received the wrong product when ordering online?', 'type' => 'radio', 'options' => array('0','1-2','3-4','5+')),
			'badExp_didntRemember' => array('label' => 'Have you ever received a product that you did not remember ordering?', 'type' => 'radio', 'options' => array('Yes', 'No')),
			'badExp_beenScamTarget' => array('label' => 'Have you ever been the target of any kind of purchasing scam?', 'type' => 'radio', 'options' => array('Yes', 'No')),
			'badExp_privacyConcern' => array('label' => 'How concerned are you about your privacy online?', 'type' => 'likert', 'left'=>'Not concerned','right'=>'Very concerned'),
			'badExp_securityConcern' => array('label' => 'How concerned are you about your security online?', 'type' => 'likert', 'left'=>'Not concerned','right'=>'Very concerned'),
		));
        


		$comfort_impulse =  array('title'=>'Personal Questions', 'pre'=>'Please indicate how much you agree with each of the statements below.',
		'data'=>array(
			'comfort_safeOnline' => array('label' => 'I feel safe when I am on the Internet.', 'type' => 'likert', 'size' => 7),
			'comfort_peaceOnline' => array('label' => 'I often find it peaceful to be online.', 'type' => 'likert', 'size' => 7),
			'comfort_careFreeOnline' => array('label' => 'When I am online, I can be carefree.', 'type' => 'likert', 'size' => 7),

			'impulse_beyondControl' => array('label' => 'My use of the Internet sometimes seems beyond my control.', 'type' => 'likert', 'size' => 7),
			'impulse_dontThinkResponOnline' => array('label' => 'When I am online, I don\'t think about my responsibilities.', 'type' => 'likert', 'size' => 7),
			'impulse_moreCarefulOffline' => array('label' => 'I am more careful purchasing things offline than I am online.', 'type' => 'likert', 'size' => 7),
		)); 

		$safeDelivery =  array('title'=>'SafeDelivery questions',
		'data'=>array(
			'safeDelivery_whatDoes'=> array('label'=> 'What does the SafeDelivery service do?', 'type'=>'textarea'),
			'safeDelivery_didYouSubscribe' => array('label' => 'Did you purchase the SafeDelivery service?', 'type' => 'select', 'options' => array('','Yes','No','I don\'t know')),

			'safeDelivery_howValuableService' => array('label' => 'How valuable is the SafeDelivery service to you?', 'type' => 'likert', 'size' => 5, 'left'=>'Not valuable', 'right'=>'Very valuable'),
			'safeDelivery_howValuableService_expl'=> array('label'=> 'Why did you choose the above rating?', 'type'=>'textarea'),
			'safeDelivery_howValuableDiscount' => array('label' => 'How valuable is the discount offered by the SafeDelivery service to you?', 'type' => 'likert', 'size' => 5, 'left'=>'Not valuable', 'right'=>'Very valuable'),
			'safeDelivery_relationship' => array('label' => 'What is the relationship between MelodiesFor.us and SafeDelivery?', 'type' => 'radio', 'options' => array('MelodiesFor.us and SafeDelivery are the same site.','MelodiesFor.us and SafeDelivery are partners.','MelodiesFor.us and SafeDelivery are unrelated.','I do not know what the relationship between MelodiesFor.us and SafeDelivery is.')),
		));                                                              

		$this->addComponents($demo);
		$this->addComponents($shopping);
		$this->addComponents($safeDelivery);
		$this->addComponents($badExp);
		$this->addComponents($scamAvoid);
		$this->addComponents($comfort_impulse);
		$this->addComponents($integrity);
	}

	function __construct($randomizeSections = false, $firstStable = true) {
		$this->fillArrays();
	
		for($i=0;$i<count($this->sections);$i++) {
			$sect = $this->sections[$i];
			$pre = '';
			if(array_key_exists('pre', $sect)) {
				$pre = $sect['pre'];
			}
			$this->sections[$i] = $this->getHtmlFromSurvey($sect['data'], $pre, $sect['title']); 
		}

		if($randomizeSections) {
			if($firstStable) {
         	$first = $this->sections[0];
				$this->sections = array_slice($this->sections, 1);
			}
			shuffle($this->sections);

			if($firstStable) {
				array_unshift($this->sections, $first);
			}
		}
	}

	function addComponents() {
		$components = func_get_args();

		foreach($components as $component) {
			$this->sections[] = $component;
		}
	}

	function getHtmlFromSurvey($survey, $preMsg = '', $title = 'Survey') {
		$result = '';
		$result .= "<legend>$title</legend><fieldset>";
		$result .= "<p class='preMsg'>$preMsg<span class='errorMsgTop'</p><ul>";
		foreach($survey as $param => $details) {
			if(!array_key_exists('value', $details)) {
				$details['value'] = '';
			}
			if(!array_key_exists('type', $details)) {
				$details['type'] = 'text';
			}
			if(!array_key_exists('label', $details)) {
				$details['label'] = "What is your $param?";
			}

			if($details['type'] !='hidden')
				$result .= "<li><label for='$param'>".$details['label']."</label>";
			
			if($details['type'] == 'likert') {
				if(!array_key_exists('left', $details)) {
					$details['left'] = 'totally disagree';
				}
				if(!array_key_exists('right', $details)) {
					$details['right'] = 'totally agree';
				} 

				$size = 5;
				if(array_key_exists('size', $details)) {
					$size = intval($details['size']);
				}
				$result .= '<br><ul><li><span style="float:left;min-width:50px;padding-right:10px;">'.$details['left'].'</span>';

				for($i=1;$i<=$size;$i++) {
					$result .= "<input type='radio' name='$param' id='$param' value='$i'>\n";
				}
				$result .= "<span style='padding-left:10px'>".$details['right'].'</span></li></ul>';

			}
			elseif($details['type'] == 'radio') {
				$result .= "<br><ul>";
				$i = 0;

				foreach($details['options'] as $option) {
					$option2 = strtolower(str_replace(' ','_',$option));
					$result .= "<li>$option<input align='left' name='$param' id='$param' type='".$details['type']."' value='".$option2."'></li>\n";
					$i++;
				}
				$result .= '</ul></li>';
			}
			elseif($details['type'] == 'select') {
				$result .= "<select style='margin-left:5px' id='$param' name='$param'>";
				$i = 0;
				foreach($details['options'] as $option) {
					if($option == '') {
						$result .= "<option value=''>Select an option</option>\n";
					}
					else {
						$i++;
						$option2 = strtolower(str_replace(' ','_',$option));
						if(array_key_exists('numbered', $details) && $details['numbered']) {
							$option2 = $i;

						}
						$result .= "<option value='$option2'>$option</option>\n";
					}
				}

				$result .= '</select></li>';
			}   
			else if($details['type'] == 'textarea'){
				$result .= "<textarea name='$param' id='$param'>".$details['value']."</textarea>\n";
				$result .= '</li>';
			}  
			else {
				$result .= "<input name='$param' id='$param' type='".$details['type']."' value='".$details['value']."'>\n";
				if($details['type'] != 'hidden') {
					$result .= '</li>';
				}
			}
		}
		$result .= '</ul></fieldset><hr>';

		return $result;
	}

	function printSections() {
		foreach($this->sections as $section) {
			print $section;
		}
	}
}    
