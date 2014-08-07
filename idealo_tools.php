<?php

/*
	Idealo, Export-Modul

	(c) Idealo 2013,
	
	Please note that this extension is provided as is and without any warranty. It is recommended to always backup your installation prior to use. Use at your own risk.
	
	Extended by
	
	Christoph Zurek (Idealo Internet GmbH, http://www.idealo.de)
*/





include_once 'idealo_csv_shipping.php';
include_once 'idealo_csv_payment.php';
include_once 'idealo_universal.php';

class idealo_tools extends idealo_universal
{
     public $shipping_type = array ( '1' => 'hard',
     								 '2' => 'weight',
     								 '3' => 'price'
     								);
	 public $shipping = array ();
     protected  $_idLang = '';
	 public $payment = array ();
     public $filter = array('article_number'	=> array(	'name'		=> 'article_number',
     														'display'	=> 'Article Numbers',
															'values'	=> '',
     														'type'		=> 'filter',
     														'db'		=> 'ARTICLE_NUMBER'
     													),
     						'category'			=> array(	'name'		=> 'category',
															'display'	=> 'Categories',
															'values'	=> '',
     														'type'		=> 'filter',
     														'db'		=> 'CATEGORY'
     													),
							'brand'				=> array(	'name'		=> 'brand',
															'display'	=> 'Brands',
															'values'	=> '',
     														'type'		=> 'filter',
     														'db'		=> 'BRAND'
     													),
     						);
	public $filename = '';
	public $fieldseparator = '';
	public $quoting = '';
	public $comment = '';
	public $campaign;
	public $minOrderPrice = '';
	public $minOrder = '';
	public $idealoMinorderBorder = '';


	function __construct($id_lang){
		$this->_idLang = $id_lang;
	}


	
	 public function getFromDb(){
		$filename = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'MODULE_IDEALO_FILE_TITLE';");
		$this->filename = $filename[0]['SETTING'];
		$fieldseparator = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'FIELDSEPARATOR';");
		$this->fieldseparator = $fieldseparator[0]['SETTING'];

		$quoting = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'QUOTING';");
		$this->quoting = $quoting[0]['SETTING'];

		$comment = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'SHIPPINGCOMMENT';");
		$this->comment = $comment[0]['SETTING'];

		$campaign = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'IDEALO_CAMPAIGN';");
		$this->campaign = $campaign[0]['SETTING'];

		$idealo_payment = new idealo_csv_payment();
 		$this->payment = $idealo_payment->payment;
		foreach ( $this->payment as $pay ){

			$payment = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $pay [ 'db' ] . "_active';" );
			$this->payment [ $pay [ 'title' ] ] [ 'active' ] = $payment [0] [ 'SETTING' ];

			$fix = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $pay [ 'db' ] . "_fix';" );
			$this->payment [ $pay [ 'title' ] ] [ 'fix' ] = $fix [0] [ 'SETTING' ];

			$percent = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $pay [ 'db' ] . "_percent';" );
			$this->payment [ $pay [ 'title' ] ] [ 'percent' ] = $percent [0] [ 'SETTING' ];

			$inclusive = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $pay [ 'db' ] . "_shipping';" );
			$this->payment [ $pay [ 'title' ] ] [ 'shipping' ] = $inclusive [0] [ 'SETTING' ];

		}

		$idealo_shipping = new idealo_csv_shipping();
 		$this->shipping = $idealo_shipping->shipping;
		foreach ( $this->shipping as $ship ){

			$selection = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $ship [ 'country' ] . "_active';" );
			$this->shipping [ $ship ['country' ] ] [ 'active' ] = $selection [0] [ 'SETTING' ];

			$free_shipping = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $ship [ 'country' ] . "_free';" );
			$this->shipping [ $ship [ 'country' ] ] [ 'free' ] = $free_shipping [0] [ 'SETTING' ];

			$fixed_shipping = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $ship [ 'country' ] . "_costs';" );
			$this->shipping [ $ship [ 'country' ] ] [ 'costs' ] = $fixed_shipping [0] [ 'SETTING' ];

			$type_shipping = Db::getInstance()->ExecuteS ( "SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'idealo_" . $ship [ 'country' ] . "_type';" );
			$this->shipping [ $ship [ 'country' ] ] [ 'type' ] = $type_shipping [0] [ 'SETTING' ];

		}

		$this->getFilter();

		$selection = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'IDEALO_MINORDERPRICE';");
		$this->minOrderPrice = $selection[0]['SETTING'];

		$selection = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'IDEALO_MINORDER';");
		$this->minOrder = $selection[0]['SETTING'];

		$selection = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE 'IDEALO_MINORDERBORDER';");
		$this->idealoMinorderBorder = $selection[0]['SETTING'];

	 }

	 
	 public function getFilter(){
		foreach($this->filter as $filter){
			$type = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE '" . $filter['db'] . "_TYPE';");
			$this->filter[$filter['name']]['type'] = $type[0]['SETTING'];

			$values = Db::getInstance()->ExecuteS("SELECT `SETTING` FROM `idealo_csv` WHERE `FIELDNAME` LIKE '" . $filter['db'] . "_VALUES';");
			$this->filter[$filter['name']]['values'] = $values[0]['SETTING'];
		}
	 }

	 
     public function getShippingModules(){
     	$carrier = Db::getInstance()->ExecuteS('SELECT DISTINCT `name` FROM `'._DB_PREFIX_.'carrier` WHERE `active` = 1');

     	foreach($carrier as $ca){
     		$car1 = Db::getInstance()->ExecuteS("SELECT MAX(`id_carrier`) FROM `"._DB_PREFIX_."carrier` WHERE `active` = 1 AND `name` LIKE '" . mysql_real_escape_string($ca['name']) . "'");
     		$car = Db::getInstance()->ExecuteS("SELECT `id_carrier`, `name`, `id_tax_rules_group` FROM `"._DB_PREFIX_."carrier` WHERE `active` = 1 AND `name` LIKE '" . mysql_real_escape_string($ca['name']) . "' AND `id_carrier` = " . $car1[0]['MAX(`id_carrier`)'] . ";");
     		$zone = Db::getInstance()->ExecuteS("SELECT `id_zone` FROM `"._DB_PREFIX_."carrier_zone` WHERE `id_carrier` = ". $car[0]['id_carrier'] . ";");
     		$text = Db::getInstance()->ExecuteS("SELECT `delay` FROM `"._DB_PREFIX_."carrier_lang` WHERE `id_carrier` = ". $car[0]['id_carrier'] . " AND `id_lang` = " . $this->_idLang. ";");
     		$this->carriers[] = array(	'id'	=>	$car[0]['id_carrier'],
     									'name'	=>	$car[0]['name'],
     									'tax'	=>	$car[0]['id_tax_rules_group'],
     									'text'	=>	$text[0]['delay'],
     									'zone'	=>	$zone
     							);
     	}
     }


     
     public function getZonesAndCoutries()
     {
     	foreach($this->shipping as $ship){
     		$active = Db::getInstance()->ExecuteS("SELECT `active` FROM `" ._DB_PREFIX_. "country` WHERE `iso_code` LIKE '" . $ship['country'] . "' AND `active` = 1");

     		if($active) {
    			if($active[0]['active'] == '1') {
    				$zones = Db::getInstance()->ExecuteS("SELECT `id_zone` FROM `" ._DB_PREFIX_. "country` WHERE `iso_code` LIKE '" . $ship['country'] . "'");
         			$this->shipping[$ship['country']]['zone'] = $zones[0]['id_zone'];
         			foreach($this->carriers as $ca) {
         				if($this->coutryzoneIsInCarrierzone($zones[0]['id_zone'], $ca['zone']) === true){
         					$this->shipping[$ship['country']]['carrier'][] = $ca;
         				}
         			}
                }
     	    }
     	}
     }


     
     public function coutryzoneIsInCarrierzone($coutry_zone, $carrier_zones){
     	foreach($carrier_zones as $ca){
     		if($ca['id_zone'] == $coutry_zone){
     			return true;
     		}
     	}
     	return false;
     }
}