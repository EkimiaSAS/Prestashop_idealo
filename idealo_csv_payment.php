<?php

/*
	Idealo, Export-Modul

	(c) Idealo 2013,
	
	Please note that this extension is provided as is and without any warranty. It is recommended to always backup your installation prior to use. Use at your own risk.
	
	Extended by
	
	Christoph Zurek (Idealo Internet GmbH, http://www.idealo.de)
*/


	
	
 
 
class idealo_csv_payment{
	public $payment = array('PREPAID' => array(		'title' => 'PREPAID',
													'active' => '0',
													'exrtafee' => '',
													'percent' => '',
													'shipping_incl' => '0',
													'max_order' => '',
													'db' => 'moneyorder',
													'country' => ''),
							'COD' => array(			'title' => 'COD',
												  	'active' => '0',
													'exrtafee' => '',
													'percent' => '',
													'shipping_incl' => '0',
													'max_order' => '',
													'db' => 'cod',
												  	'country' => ''),
							'PAYPAL' => array(		'title' => 'PAYPAL',
												  	'active' => '0',
												  	'exrtafee' => '',
												  	'percent' => '',
												  	'shipping_incl' => '0',
												  	'max_order' => '',
												  	'db' => 'paypal',
												  	'country' => ''),
							'CREDITCARD' => array(	'title' => 'CREDITCARD',
												  	'active' => '0',
												  	'exrtafee' => '',
												  	'percent' => '',
												  	'shipping_incl' => '0',
												  	'max_order' => '',
												  	'db' => 'creditcard',
												  	'country' => ''),
							'MONEYBOOKERS' => array('title' => 'MONEYBOOKERS',
											  		'active' => '0',
												  	'exrtafee' => '',
												  	'percent' => '',
												  	'shipping_incl' => '0',
												  	'max_order' => '',
												  	'db' => 'moneybookers',
												  	'country' => ''),
							'INVOICE' => array(		'title' => 'INVOICE',
												  	'active' => '0',
												  	'exrtafee' => '',
												  	'percent' => '',
												  	'shipping_incl' => '0',
												  	'max_order' => '',
												  	'db' => 'invoice',
												  	'country' => ''),
							'DIRECTDEBIT' => array(	'title' => 'DIRECTDEBIT',
											  		'active' => '0',
											  		'exrtafee' => '',
											 		'percent' => '',
											  		'shipping_incl' => '0',
											  		'max_order' => '',
											  		'db' => 'directdebit',
											  		'country' => '')			  
							);	
									
}

?>
