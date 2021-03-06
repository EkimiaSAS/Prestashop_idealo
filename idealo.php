<?php

/*
	Idealo, Export-Modul

	(c) Idealo 2013,
	
	Please note that this extension is provided as is and without any warranty. It is recommended to always backup your installation prior to use. Use at your own risk.
	
	Extended by
	
	Christoph Zurek (Idealo Internet GmbH, http://www.idealo.de)
*/





define('CAMPAIGN', '?ref=94511215');

class idealo
{
	public $shipping = array();

	public $payment = array();

	public $filter = array();
	public $filename = '';
	public $fieldseparator = '';
	public $quoting = '';
	public $comment = '';
	public $campaign;


	public $id_lang = '';
	public $filter_array = array();
	public $shipping_costs = array();
	public $delivery = array();
	public $id_coutry = array();
	public $minOrderPrice = '';
	public $minOrder = '';
	public $idealoMinorderBorder = '';

	protected $_idealocsv;
	
	protected $shippingCheckValue = array();

	protected $countryId = '';

	public function __construct()
	{
	    $this->_idealocsv = new idealocsv();
	    
	    $params = Context::getContext();
	    $this->countryId = $params->country->id;
	}

	public function runExport()
	{
	    $this->id_lang = $_POST['id_lang'];

	    $this->saveSettings();
	    $this->getSetting();
	    
	    $fieldSeparatorCounter = $this->_countFieldSeparatorCounter($csvFileText);
	    $fieldSeparatorCounterAlertTxt = $this->_getFieldSeparatorCounterAlertTxt($fieldSeparatorCounter);
	    
	    global $smarty;
	    $smarty->assign(array(
	            'base_url'                      => _PS_BASE_URL_.__PS_BASE_URI__,
	            'cleanFileName'                 => $this->filename,
	            'fieldSeparatorCounter'         => $fieldSeparatorCounter,
	            'fieldSeparatorCounterAlertTxt' => $fieldSeparatorCounterAlertTxt,
	    ));
	    
	    if(count($this->shippingCheckValue) > 0){
	    	return $smarty->fetch(_PS_MODULE_DIR_. 'idealocsv/views/templates/back/idealo_wrong_shipping.tpl');
	    }
	     		
	    $csvFileText = $this->_getCSVFileText();
	    $this->_writeCSVFile($csvFileText);

	  

	    return $smarty->fetch(_PS_MODULE_DIR_. 'idealocsv/views/templates/back/idealo_export_done.tpl');
	}


	
	public function saveSettings()
	{
	    $tools = new idealo_tools($this->id_lang);
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". self::_sanitizeFileName(trim($_POST['filename'])) ."' WHERE `FIELDNAME` LIKE 'MODULE_IDEALO_FILE_TITLE';");
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['fieldseparator']) ."' WHERE `FIELDNAME` LIKE 'FIELDSEPARATOR';");
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['quoting']) ."' WHERE `FIELDNAME` LIKE 'QUOTING';");
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['comment']) ."' WHERE `FIELDNAME` LIKE 'SHIPPINGCOMMENT';");
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['campaign']) ."' WHERE `FIELDNAME` LIKE 'IDEALO_CAMPAIGN';");

	    $idealo_payment = new idealo_csv_payment();
	    $payment = $idealo_payment->payment;
	    foreach($payment as $pay) {
	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST[$pay['db']]) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $pay['db'] . "_active';");
	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST[$pay['db'] . '_fix']) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $pay['db'] . "_fix';");
	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST[$pay['db'] . '_percent']) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $pay['db'] . "_percent';");
	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['shipping_' . $pay['db'] . '_inclusive']) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $pay['db'] . "_shipping';");
	    }

	    $idealo_shipping = new idealo_csv_shipping();
	    $shipping = $idealo_shipping->shipping;
	    foreach($shipping as $ship) {
	        if(isset($_POST['shipping_' . $ship['country']]))
	            Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['shipping_' . $ship['country']]) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $ship['country'] . "_active';");

	        if(isset($_POST['free_shipping_' . $ship['country']]))
	            Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['free_shipping_' . $ship['country']]) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $ship['country'] . "_free';");

	        if(isset($_POST['fixed_shipping_' . $ship['country']]))
	            Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['fixed_shipping_' . $ship['country']]) ."' WHERE `FIELDNAME` LIKE 'idealo_" . $ship['country'] . "_costs';");

	        if(isset($_POST['shipping_' . $ship['country']]))
    	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['shipping_' . $ship['country'] . '_pay_type']) . "' WHERE `FIELDNAME` LIKE 'idealo_" . $ship['country'] . "_type';");
    	    
    	    if(trim($_POST['shipping_' . $ship['country']]) == '1'){
    	    	$tools->checkShipping(trim($_POST['shipping_' . $ship['country'] . '_pay_type']), trim($_POST['fixed_shipping_' . $ship['country']]), $ship['country']);
    	    }    
	    }
	    
	    $this->shippingCheckValue = array_merge($this->shippingCheckValue, $tools->shippingCheckValue);
	    foreach($tools->filter as $filter) {
	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST[$filter['name']]) ."' WHERE `FIELDNAME` LIKE '" . $filter['db'] . "_TYPE';");
	        Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST[$filter['name'] . '_values']) ."' WHERE `FIELDNAME` LIKE '" . $filter['db'] . "_VALUES';");
	    }

	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['minorder']) ."' WHERE `FIELDNAME` LIKE 'IDEALO_MINORDER';");
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['small_order_value_surcharge']) ."' WHERE `FIELDNAME` LIKE 'IDEALO_MINORDERPRICE';");
	    Db::getInstance()->Execute("UPDATE `idealo_csv` SET `SETTING` = '". trim($_POST['upper_limit']) ."' WHERE `FIELDNAME` LIKE 'IDEALO_MINORDERBORDER';");
	}


	
	 public function getSetting()
	 {
	 	$tools = new idealo_tools($this->id_lang);
	 	$tools->getFromDb();

	 	$tools->getShippingModules();

		$this->shipping = $tools->shipping;
		$this->payment = $tools->payment;
 	  	$this->filter = $tools->filter;

 	  	$this->filename = $tools->filename;
		$this->fieldseparator = $tools->fieldseparator;
		$this->quoting = $tools->quoting;
		$this->comment = $tools->comment;
		$this->campaign = $tools->campaign;

		$this->minOrderPrice = $tools->minOrderPrice;
		$this->minOrder = $tools->minOrder;
		$this->idealoMinorderBorder = $tools->idealoMinorderBorder;
	 }


	public function getPrice ( $id )
	{
		$price = Db::getInstance()->ExecuteS("SELECT `price` FROM `" ._DB_PREFIX_. "product` WHERE `id_product`  = " . $id . ";");
		$price = $price [0] [ 'price' ];
		$price = $price * 1.23;

		return round ( $price, 2 );
	}

	
	public function getTaxRate($id_tax_rules_group){
		$tax = Db::getInstance()->ExecuteS("SELECT `rate`
											FROM `" ._DB_PREFIX_. "tax` tax, `" ._DB_PREFIX_. "tax_rule` tax_rule
											WHERE tax_rule.id_tax_rules_group = " . $id_tax_rules_group . " AND
												  tax_rule.id_country = " . $this->countryId . " AND
												  tax_rule.id_tax = tax.id_tax;");
		return $tax[0]['rate'];
	}

	public function sortAttributeCombinations($attributeCombinations){
		$sortAttributeCombinations = array();
		
		$i = 0;
		
		while(!empty($attributeCombinations)){
			$sortAttributeCombinations[$i][0] = array_shift($attributeCombinations);
			if(empty($attributeCombinations)){
				break;
			}
			
			foreach($attributeCombinations as $combination){
				if($sortAttributeCombinations[$i][0]['id_product_attribute'] == $combination['id_product_attribute']){
					$sortAttributeCombinations[$i][] = $combination;
					unset($attributeCombinations[array_search($combination, $attributeCombinations)]);
				}
			}
			
			$i++;
		}

		return $sortAttributeCombinations;
	}

	public function getCombinationString($combination){
		$combinationString = '';
		foreach($combination as $com){
			$combinationString .= $com['group_name'] . ': ' .  $com['attribute_name'] . '; ';
		}
		
		return substr($combinationString, 0, -2);
	}
	

	public function getImegeLinkOfAtrribute($id_product_attribute){
		$image = Db::getInstance()->ExecuteS("SELECT `id_image`
											FROM `" ._DB_PREFIX_. "product_attribute_image`
											WHERE `id_product_attribute` = " . $id_product_attribute . ";");
		return $image[0]['id_image'];
	}

	
	 private function _getCSVFileText()
	 {
	 	$link = new Link();
	 	$schema = '';
        $schema .= $this->quoting . $this->_idealocsv->l('id', 'idealo')                . $this->quoting . $this->fieldseparator .
				   $this->quoting . $this->_idealocsv->l('brand', 'idealo')             . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('title', 'idealo')             . $this->quoting . $this->fieldseparator .
				   $this->quoting . $this->_idealocsv->l('Category', 'idealo')          . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('Short Description', 'idealo') . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('description', 'idealo')       . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('image_link', 'idealo')        . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('link', 'idealo')              . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('price', 'idealo')             . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('ean', 'idealo')             . $this->quoting . $this->fieldseparator .
        		   $this->quoting . $this->_idealocsv->l('availability', 'idealo')      . $this->quoting . $this->fieldseparator;
      	foreach($this->shipping as $ship) {
      		if($ship['active'] == '1') {
      			foreach($this->payment as $pay) {
	      			if($pay['active'] == '1') {
		     	        $schema .= $this->quoting .
		     	         strtoupper ($pay['db']) . '_' . $ship['country'] . $this->quoting . $this->fieldseparator;
		      		}
	      		}
      		}
      	}
      	foreach($this->shipping as $ship) {
      		if($ship['active'] == '1') {
      			$schema .= $this->quoting . $this->_idealocsv->l('shipping', 'idealo') . '_' . $ship['country'] . $this->quoting . $this->fieldseparator;
      		}
      	}

      	$schema .= $this->quoting . $this->_idealocsv->l('shipping_weight', 'idealo')      . $this->quoting . $this->fieldseparator.
      			   $this->quoting . $this->_idealocsv->l('baseprice', 'idealo')   . $this->quoting . $this->fieldseparator .
      			   $this->quoting . $this->_idealocsv->l('EAN', 'idealo')         . $this->quoting . $this->fieldseparator .
      			   $this->quoting . $this->_idealocsv->l('condition', 'idealo')   . $this->quoting . $this->fieldseparator .
      			   $this->quoting . 'portocomment' . $this->quoting . $this->fieldseparator;

      	if ( $this->minOrderPrice != '' ) {
      		$schema .= $this->quoting . $this->_idealocsv->l('Small order value surcharge', 'idealo') . $this->quoting . $this->fieldseparator;
      	}
      	
		$schema .= $this->quoting . 'Attributes' . $this->quoting . $this->fieldseparator;

		$schema .= "\n";

		setlocale( LC_ALL, 'de_DE' );
		$date = date( "d.m.y H:i:s" );
		$schema .= $this->quoting . sprintf($this->_idealocsv->l('Last file created on %s o\'clock', 'idealo'), $date ) . $this->quoting . $this->fieldseparator;
		$schema .= "\n";
		$schema .= sprintf($this->_idealocsv->l('idealo - CSV export-modul V %s for PrestaShop from %s', 'idealo'), IDEALO_MODULE_VERSION, IDEALO_MODULE_DATE);
		$schema .= "\n";

		$article = $this->getArticleNumbers();

		foreach($article as $a) {
			$product = new Product($a['id_product'], false, $this->id_lang);
						
			$productlink = $product->getLink();

			if($this->campaign == '1') {
				$productlink .= CAMPAIGN;
			}

			$cat = $product->getProductCategoriesFull($a['id_product'], $this->id_lang);
			$brand = $this->getBrand($product->id_manufacturer);
			$cat_text = $this->getCatText($cat);

			if($this->checkFilter($cat_text, $brand, $a['id_product']) === true) {
				
				$images = $product->getCover($a['id_product']);
				$imagelink = $link->getImageLink($product->link_rewrite[1], $product->id .'-'. $images['id_image'],'');
				$price = number_format ( $product->getprice(), 2, '.', '' );
				
				$attributeCombinations = $product->getAttributeCombinaisons($this->id_lang);

				if(!empty($attributeCombinations)){
					$attributeCombinations = $this->sortAttributeCombinations($attributeCombinations);
					$taxRate = $this->getTaxRate($product->id_tax_rules_group);
					
					$i = 1;
					foreach($attributeCombinations as $combination){
						if($combination[0]['quantity'] > 0){
							$image = '';
							$image_id = $this->getImegeLinkOfAtrribute($combination[0]['id_product_attribute']);
							if($image_id == 0){
								$image = $imagelink;
							}else{
								$image = new Image($image_id);
								$image = _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath().'.jpg';
							}
							
							$articleId = $a['id_product'] . '_' . $i;
							$combinationString = $this->getCombinationString($combination);
							$title = $product->name . ' ' . str_replace(';', ',', $combinationString);
							$combinationPrice = $price + number_format($combination[0]['price'] * (1 + ($taxRate / 100)), 2, '.', '');
							$weight = $product->weight + $combination[0]['weight'];
							$combinationEan = $combination[0]['ean13'];
							
							$schema .= $this->getProductLine($product, $articleId, $brand, $title, $cat_text, $image, $productlink, $combinationPrice, $weight, $combinationString, $$combinationEan);
						}				

						$i++;
						if($i >= 100){
							break;
						}
					}
				}else{
					$schema .= $this->getProductLine($product, $a['id_product'], $brand, $product->name, $cat_text, $imagelink, $productlink, $price, $product->weight);
				}

			}
		}

		return $schema;
	 }
	 
	 
	 private function getProductLine($product, $articleId, $brand, $title, $cat_text, $imagelink, $productlink, $price, $weight, $attributes = '', $commbinationEan = ''){
		$schema = 	$this->quoting . $articleId . $this->quoting . $this->fieldseparator .
					$this->quoting . $this->cleanText($brand, 100) . $this->quoting . $this->fieldseparator .
					$this->quoting . $this->cleanText($title, 100) . $this->quoting . $this->fieldseparator .
					$this->quoting . $this->cleanText($cat_text, 200) . $this->quoting . $this->fieldseparator .
					$this->quoting . $this->cleanText($product->description_short, 200) . $this->quoting . $this->fieldseparator .
					$this->quoting . $this->cleanText($product->description, 1000) . $this->quoting . $this->fieldseparator .
					$this->quoting . $imagelink . $this->quoting . $this->fieldseparator .
					$this->quoting . $productlink . $this->quoting . $this->fieldseparator .
					$this->quoting . $price . $this->quoting . $this->fieldseparator.
					$this->quoting . $product->ean13 . $this->quoting . $this->fieldseparator. 
		            $this->quoting . $product->available_now . $this->quoting . $this->fieldseparator;

		foreach($this->shipping as $ship) {
			if($ship['active'] == '1') {
      			$shippingCosts = $this->getShippingCosts((float)$price, $product->weight, $ship);
      			foreach($this->payment as $pay) {
	      			if($pay['active'] == '1') {
		     	        $schema .= 	$this->quoting . number_format($this->getPaymentCosts($pay, $shippingCosts, (float)$price) + $product->additional_shipping_cost, 2, '.', '') . $this->quoting . $this->fieldseparator;
		      		}
	      		}
      		}
      	}

		foreach($this->shipping as $ship) {
      		if($ship['active'] == '1') {
      			$schema .= 	$this->quoting . $this->getAvailableText($ship['country'], $product->id_product) . $this->quoting . $this->fieldseparator;
      		}
      	}

		$schema .= 	$this->quoting . $weight . $this->quoting . $this->fieldseparator;

		if( $product->unit_price_ratio > 0 ) {
			$schema .= $this->quoting . number_format($price / $product->unit_price_ratio, 2, '.', '') . ' Euro / ' . $product->unity . $this->quoting . $this->fieldseparator;
		}else{
			$schema .= $this->quoting . '' . $this->quoting . $this->fieldseparator;
		}
		
		if($commbinationEan != ''){
		    $schema .=	$this->quoting . $commbinationEan . $this->quoting . $this->fieldseparator;
		}else{
		    $schema .=	$this->quoting . $product->ean13 . $this->quoting . $this->fieldseparator;
		}
		
		$schema .=$this->quoting . $product->condition . $this->quoting . $this->fieldseparator;

			$portocoment = $this->comment;

      	if($this->checkMinOrder($price)) {
      		$portocoment = $this->_idealocsv->l('Minimum order value:', 'idealo') . ' ' .  number_format($this->minOrder, 2, '.', '') . ' EUR';
      	}

      	if($this->minOrderPrice != '') {
 	     	if($this->checkMinExtraPrice($price)) {
	     		$portocoment = number_format($this->minOrderPrice, 2, '.', '') . ' ' .
	     					   $this->_idealocsv->l('EUR Minimum order surcharge under', 'idealo') . ' ' .
	     					   number_format($this->idealoMinorderBorder, 2, '.', '') . ' ' .
	     					   $this->_idealocsv->l('EUR product value', 'idealo');
	     	}
    	}

		$schema .=  $this->quoting . $portocoment . $this->quoting . $this->fieldseparator;

		if ( $this->minOrderPrice != '' ) {
	     	if ( $this->checkMinExtraPrice ( $price ) ) {
	     		$schema .= $this->quoting . number_format( $this->minOrderPrice, 2, '.', '' ) . $this->quoting . $this->fieldseparator;
	     	}else{
	     		$schema .= $this->quoting . '0.00' . $this->quoting . $this->quoting . $this->fieldseparator;
	     	}
	     }
	     
	    $schema .=  $this->quoting . $attributes . $this->quoting . $this->fieldseparator; 

		$schema .= "\n";
		
		return $schema;
	 }

	 
	 private function _countFieldSeparatorCounter( $schema )
	 {

        $fieldSeparatorCounter = 0;

        if ($this->quoting) {
            preg_match_all('/\\' . $this->quoting . '(.*?)\\' . $this->quoting. '/', $schema, $match);

            foreach ( $match[1] as $textInsideQuoting ) {
    		    $posTextInsideQuoting = strpos($textInsideQuoting, $this->fieldseparator);
    		    if ( $posTextInsideQuoting !== false)
    		        $fieldSeparatorCounter = $fieldSeparatorCounter + $posTextInsideQuoting;
    		}
        }

		return $fieldSeparatorCounter;
	 }

	 
	 private function _getFieldSeparatorCounterAlertTxt($fieldSeparatorCounter)
	 {
	     if ($fieldSeparatorCounter <= 0)
	         return '';

	     $sugestedFieldSeparator = array('|', '$', '~', ',', '@', '*', '%', '<', '>', '#', '{', '}', '^');
	     $alertTxt  = sprintf($this->_idealocsv->l('The column dividing value "%s" that you are using is currently coming up %s times in your feed text!', 'idealo'), $this->fieldseparator, $fieldSeparatorCounter). '\n\n';
	     $alertTxt .= $this->_idealocsv->l('This can lead to column displacements in your feed (file).', 'idealo') . '\n\n';
	     $alertTxt .= $this->_idealocsv->l('As an alternative, you should use one of the following column dividing values:', 'idealo') . '\n\n';

	     foreach ($sugestedFieldSeparator as $singleSeparator) {
	         if ($singleSeparator != $this->fieldseparator)
	             $alertTxt .= $singleSeparator.'\n';
	     }

	     return $alertTxt;
	 }

	 
	 private function _writeCSVFile($schema)
	 {
	     if (!$fp = fopen(_PS_ROOT_DIR_.'/export/' . $this->filename, "w+")) {
	         print 'Kann die Datei '. $this->filename .' nicht öffnen';
	         exit;
	     }

	     if (!fwrite($fp, $schema)) {
	         print 'Kann die Datei '. $this->filename .' nicht schreiben';
	         exit;
	     }

	     fclose($fp);
	 }


	
	public function getAvailableText( $country, $productID )
	{
		$country = strtolower ( $country );

		$langID = Db::getInstance()->ExecuteS("SELECT `id_lang`
	  											FROM `" ._DB_PREFIX_. "lang`
	  											WHERE `iso_code` LIKE '" . $country . "';");

	  	if(!isset($langID[0]['id_lang'])) {
	  		return '';
	  	}

	  	$langID = $langID[0]['id_lang'];

	  	if ($langID == '') {
	  		return '';
	  	}

	  	$text = Db::getInstance()->ExecuteS("SELECT `available_now`
	  											FROM `" ._DB_PREFIX_. "product_lang`
	  											WHERE `id_lang` LIKE '" . $langID . "'
	  											AND id_product LIKE '" . $productID . "';");

		return $text [0][ 'available_now' ];
	}

	
	public function checkMinOrder ( $art_price )
	{
		if ( $this->minOrder != '' ) {
			if ( ( float ) $this->minOrder >= ( float ) $art_price ) {
				return true;
			}
		}

		return false;
	}

	
	 public function checkMinExtraPrice ( $art_price )
	 {
	 	if ( ( float ) $this->idealoMinorderBorder > ( float ) $art_price ) {
	 		return true;
	 	}

	 	return false;
	 }


	
	 private function getPaymentCosts($pay, $costs, $price)
	 {
 		if ( $pay [ 'percent' ] != '' ) {
	 		if ( $pay [ 'shipping' ] == '1' ) {
	 			$costs = $costs + ( ( $costs + $price ) * ( float ) $pay [ 'percent' ] / 100 );
	 		}else{
	 			$costs = $costs + ( $price * ( float ) $pay [ 'percent' ] / 100 );
	 		}
	 	}

	 	if ( $pay [ 'fix' ] != '' ) {
	 		$costs = $costs + ( float ) $pay [ 'fix' ];
	 	}

	 	return $costs;
	 }


	 
	 private function getShippingCosts($price, $weight, $ship)
	 {
	     if ($ship['free'] != '' ) {
	 		if ((float)$price >= (float)$ship['free']) {
		 		return '0';
		 	}
	 	}

	 	if($ship['type'] == 'hard') {
	 		return $ship['costs'];
	 	}

 		$costs = explode(';', $ship['costs']);
 		$value = '';

 		if ($ship['type'] == 'weight') {
 			$value = $weight;
 		}

 		if($ship['type'] == 'price') {
 			$value = $price;
 		}

 		$last = '';
 		foreach($costs as $co) {
 			$shipping = explode(':', $co);
 			$last = isset($shipping[1]) ? $shipping[1] : '';

 			if((float)$shipping[0] >= (float) $value) {
 				return $shipping [1];
 			}
 		}

 		return $last;
	 }



	 
	  private function getShippingAndTax($tax, $price, $country) {
	  	if($tax == '0' || $tax == '') {
	  		return $price;
	  	}

	  	$tax_rate = Db::getInstance()->ExecuteS("SELECT t.`rate`
	  											 FROM `" ._DB_PREFIX_. "tax` t,
	  											 	  `" ._DB_PREFIX_. "tax_rule` tr
	  											 WHERE t.`id_tax` = tr.`id_tax` AND
	  											 	   tr.`id_country` = " . $this->id_country[$country] . " AND
	  											 	   tr.`id_tax_rules_group` = " . $tax . ";");

	  	$tax_rate = $tax_rate[0]['rate'];

		if($tax_rate != '') {
			$price = $price + ($price * $tax_rate / 100);
		}
	  	return $price;
	 }


 	
 	 private function checkRange($id_range, $value, $type) {
 	 	$range = Db::getInstance()->ExecuteS("SELECT `delimiter1`, `delimiter2` FROM `" ._DB_PREFIX_. "range_" . $type . "` WHERE `id_range_" . $type . "` = " . $id_range . ";");
 	 	if($value >= (float) $range[0]['delimiter1'] && $value <= (float)$range[0]['delimiter2']) {
 	 		return true;
 	 	}else{
 	 		return false;
 	 	}
 	 }

	 
	  public function cleanText($text, $lenght) {
		$spaceToReplace = array("<br>", "<br />", "\n", "\r", "\t", "\v", "|", chr(13));
		$commaToReplace = array("'");
		$quoteToReplace = array("&quot;", "&qout,");
		$regex = '/<.*>/';
		$replace = ' ';

		$text = strip_tags($text);
		$text = str_replace($spaceToReplace," ",$text);
		$text = str_replace($commaToReplace,", ",$text);
		$text = str_replace($quoteToReplace,'"',$text);

		$text = preg_replace($regex, $replace, $text);

		$text = substr($text, 0, $lenght);

		return $text;
	  }


	
	public function getArticleNumbers() {
		$article = Db::getInstance()->ExecuteS("SELECT `id_product` FROM `" ._DB_PREFIX_. "product` " .
											   "WHERE `active` = 1 AND `available_for_order` = 1 AND `out_of_stock` != 0");
		return $article;

	}

	
	 public function getCatText($cat)
	 {
	 	if(count($cat)==0) {
	 		return '';
	 	}

	 	if(count($cat)==1) {
	 		$keys = array_keys($cat);
	 		return $cat[$keys[0]]['name'];
	 	}

	 	$text = '';

	 	foreach($cat as $c) {
	 		if ( $c['id_category']!='1') {
	 			$catId = $c['id_category'];
	 			do{
	 				$categoryName = Db::getInstance()->ExecuteS("SELECT `name` FROM `" ._DB_PREFIX_. "category_lang` " .
											   "WHERE `id_category` = " . $catId . " AND `id_lang` = " . $this->id_lang . ";");

	 				$text .= $categoryName[0]['name'] . ' -> ';

	 				$parentId = Db::getInstance()->ExecuteS("SELECT `id_parent` FROM `" ._DB_PREFIX_. "category` " .
											   "WHERE `id_category` = " . $catId . ";");

	 				$parentId = $parentId[0]['id_parent'];

	 				$catId = $parentId;

	 			} while($parentId!='1');

	 			$text .= ' <-> ';
            }
	 	}

	 	$text = substr($text, 0, -9);
	 	return $text;
	 }


	
	 public function checkFilter($cat, $brand, $product_id) {
	 	$article = explode(';',$this->filter['article_number']['values']);

	 	if(count($article) > 0) {
	 		if($article[0] != '') {
		 		$bool = false;
			 	foreach($article as $a) {
			 		if($a == $product_id) {
			 			$bool = true;
			 			break;
			 		}
			 	}
			 	if($this->filter['article_number']['type'] == '1' && $bool === true) {
			 		return false;
			 	}
			 	if($this->filter['article_number']['type'] == '0' && $bool === false) {
			 		return false;
			 	}
	 		}

	 	}
	 	$brand_array = explode(';',$this->filter['brand']['values']);

	 	if($this->filter['brand']['type'] == '0' && $brand == '') {
			return false;
		}

	 	if(count($brand_array) > 0 && $brand != '') {
	 		if($brand_array[0] != '') {
			 	$bool = false;
			 	foreach($brand_array as $b) {
			 		if($b == $brand) {
			 			$bool = true;
			 			break;
			 		}
			 	}
				if($this->filter['brand']['type'] == '1' && $bool === true) {
					return false;
				}
			 	if($this->filter['brand']['type'] == '0' && $bool === false) {
			 		return false;
			 	}
	 		}
	 	}
	 	$category_filter = explode(';',$this->filter['category']['values']);

	 	if(count($category_filter) > 0 && count($cat) > 0) {
	 		if($category_filter[0] != '' && $cat != '') {
		 		$bool = false;
			 	foreach($category_filter as $ca_fil) {
		 			if(strpos($cat, $ca_fil) !== false) {
		 				$bool = true;
		 				break;
		 				break;
			 		}
			 	}
			 	if($this->filter['category']['type'] == '1' && $bool === true) {
			 		return false;
			 	}
			 	if($this->filter['category']['type'] == '0' && $bool === false) {
			 		return false;
			 	}
	 		}

	 	}
	 	return true;
	 }



	
	 public function getArticle($start, $limit) {
	 	$product = new Product();
	 	$procucts = $product->getProducts($this->id_lang, $start, $limit,'id_product','ASC');
	 	return $procucts;
	 }


	
	 public function getBrand($id)
	 {
   		$brand = Db::getInstance()->ExecuteS("SELECT `name` FROM `" ._DB_PREFIX_. "manufacturer` WHERE `id_manufacturer` = " . $id . ";");
   		if (isset($brand[0]['name'])) {
   			return $brand[0]['name'];
   		}else{
   			return '';
   		}
	 }

	 
	 private static function _sanitizeFileName($filename, $force_lowercase = false, $anal = false)
	 {
	     $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
	             "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
	             "â€”", "â€“", ",", "<", ">", "/", "?");
	     $clean = trim(str_replace($strip, "", strip_tags($filename)));
	     $clean = preg_replace('/\s+/', "-", $clean);
	     $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

	     return ($force_lowercase) ? (function_exists('mb_strtolower')) ?  mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
	 }
}