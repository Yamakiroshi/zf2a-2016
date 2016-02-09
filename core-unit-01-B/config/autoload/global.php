<?php
/**
 * In this file you will be overriding "PhlyContact" settings
 * for the "ContactControllerFactory" and redirecting 2 view templates
 */

return array(
    'controllers' => array(
        'factories' => array(
        	/**
        	 * NOTE: this key will be overridden in the lab
        	 * No need to change this file!
        	 */
            'PhlyContact\Controller\Contact' => 'Application\Service\ContactControllerFactory',
        ),
    ),
	'view_manager' => array(
		'template_map' => array(
			/**
			 * Add 2 entries to redirect the "index" and "thank-you" view templates
			 */
		),
	),
);
