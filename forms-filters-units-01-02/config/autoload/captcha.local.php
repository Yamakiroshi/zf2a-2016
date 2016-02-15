<?php
return array(
	// See http://framework.zend.com/manual/2.2/en/modules/zend.captcha.adapters.html
	'service_manager' => array(
		'services' => array(
		    'captcha_options' => array(
		    	'expiration' => 300,
		    	'font'		=> __DIR__ . '/../../data/fonts/FreeSansBold.ttf',
		    	'fontSize'	=> 24,
		    	'height'	=> 50,
		    	'width'		=> 200,
		    	'imgDir'	=> __DIR__ . '/../../public/captcha',
		    	'imgUrl'	=> '/captcha',
		    ),
		),
	),
);