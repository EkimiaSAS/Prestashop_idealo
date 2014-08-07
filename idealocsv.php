<?php

/*
	Idealo, Export-Modul

	(c) Idealo 2013,
	
	Please note that this extension is provided as is and without any warranty. It is recommended to always backup your installation prior to use. Use at your own risk.
	
	Extended by
	
	Christoph Zurek (Idealo Internet GmbH, http://www.idealo.de)
*/






define('IDEALO_TEXT_CSV_MODIFIED', false);

define('IDEALO_MODULE_VERSION', '1.7.1');
define('IDEALO_MODULE_DATE',    '21.01.2014');


include_once(_PS_MODULE_DIR_ . 'idealocsv/idealo_tools.php');
include_once(_PS_MODULE_DIR_ . 'idealocsv/idealo.php');

class idealocsv extends Module {

	public $shipping = array();

	public $carriers = array();

	public $shipping_type = array();

	public $payment = array();

	public $filter = array();
	public $filename = '';
	public $fieldseparator = '';
	public $quoting = '';
	public $comment = '';
	public $campaign;

	public $new_idealo_version_text = '';
	public $minOrderPrice = '';
	public $minOrder = '';
	public $idealoMinorderBorder = '';

	private $_postErrors = array();

	function __construct()
	{
		$this->name    = 'idealocsv';
		$this->tab     = 'market_place';
		$this->author  = 'idealo internet GmbH';
		$this->version = IDEALO_MODULE_VERSION;

		$this->_checkNewVersion();

		parent::__construct();

		$this->displayName = $this->l('idealo CSV export');
		$this->description = $this->l('idealo CSV settings');
	}


   public function _checkNewVersion()
   {
	$version_location_idealo = 'http://ftp.idealo.de/software/modules/version.xml';

	$new_idealo_version_text = sprintf($this->l('idealo - CSV export-modul V %s for PrestaShop from %s'), IDEALO_MODULE_VERSION, IDEALO_MODULE_DATE);


	if( @file_get_contents ( $version_location_idealo ) !== false ) {
    	$xml_idealo = simplexml_load_file ( $version_location_idealo );
        $version_idealo = ( string ) $xml_idealo->csv_export->prestashop;

    	$idealo_module_download = ( string )$xml_idealo->download->url;

    	$old_version_idealo = explode ( '.', IDEALO_MODULE_VERSION );
    	$new_version_idealo = explode ( '.', $version_idealo );

		$idealo_version_text_no_modified = '<blink> ' .$this->l('The version') . ' ' . $version_idealo . ' ' .$this->l('of the module is available at idealo.') . ' </blink>';
		$idealo_version_text_modified = '<blink> ' . $this->l('The version') . $version_idealo . ' ' . $this->l('of the module is available at idealo.') . ' <br>' . $this->l('Since the installed module for your shop system has been modified, please contact idealo for the corresponding update.') . '</a>'. ' </blink>';
		if ( count ( $old_version_idealo ) == count ( $new_version_idealo ) ){

			if (
					( $old_version_idealo [0] < $new_version_idealo [0] )
					or
					(
							$old_version_idealo [0] == $new_version_idealo [0]
							and
							$old_version_idealo[1] < $new_version_idealo [1]
					)
					or
					(
							$old_version_idealo [0] == $new_version_idealo [0]
							and
							$old_version_idealo [1] == $new_version_idealo [1]
							and
							$old_version_idealo [2] < $new_version_idealo [2]

					)
				){
					if ( IDEALO_TEXT_CSV_MODIFIED === false ){
						$new_idealo_version_text = $idealo_version_text_no_modified;
					}else{
						$new_idealo_version_text = $idealo_version_text_modified;
					}
				}
			}
		}

 	    $this->new_idealo_version_text = '<br>' . $new_idealo_version_text;
   }

   	public function allNeeded()
   	{
   		global $cookie;

		$this->id_lang = $cookie->id_lang ;
   		$tools = new idealo_tools($this->id_lang);

		$tools->getFromDb();

		$tools->getShippingModules();
		$tools->getZonesAndCoutries();

		$this->shipping = $tools->shipping;
		$this->payment = $tools->payment;
		$this->shipping_type = $tools->shipping_type;
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

    
	public function install()
	{
		if (!parent::install()) {
		    return false;
		}

		global $cookie;

		$this->id_lang = $cookie->id_lang ;
   		$tools = new idealo_tools($this->id_lang);
        Db::getInstance()->Execute("CREATE TABLE `idealo_csv` (FIELDNAME VARCHAR (100) NOT NULL PRIMARY KEY, SETTING VARCHAR (100))" );
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('MODULE_IDEALO_FILE_TITLE','idealo.csv');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('FIELDSEPARATOR','|');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('QUOTING','');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('SHIPPINGCOMMENT','');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('IDEALO_CAMPAIGN','" . IDEALO_COMPAIGN . "');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('IDEALO_MINORDERPRICE','');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('IDEALO_MINORDER','');");
		Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('IDEALO_MINORDERBORDER','');");

		$idealo_shipping = new idealo_csv_shipping();
 		$this->shipping = $idealo_shipping->shipping;

		foreach( $this->shipping as $ship ){
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $ship [ 'country' ] . "_active','0');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $ship [ 'country' ] . "_costs','');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $ship [ 'country' ] . "_free','');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $ship [ 'country' ] . "_type','');");
		}

		$idealo_payment = new idealo_csv_payment();
 		$this->payment = $idealo_payment->payment;

		foreach( $this->payment as $pay ){
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $pay [ 'db' ] . "_active','0');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $pay [ 'db' ] . "_countries','');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $pay [ 'db' ] . "_fix','');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $pay [ 'db' ] . "_percent','');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('idealo_" . $pay [ 'db' ] . "_shipping','0');");
		}
		foreach($tools->filter as $filter){
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('" . $filter['db'] . "_TYPE','1');");
			Db::getInstance()->Execute("INSERT INTO `idealo_csv` VALUES ('" . $filter['db'] . "_VALUES','');");
		}

		return true;
	}

 	
 	public function uninstall()
 	{
 		if (!parent::uninstall())
 		    return false;

 		Db::getInstance()->Execute("DROP TABLE `idealo_csv`");

 		return true;
 	}

 	
	public function getContent()
	{
	    $html = '';

	    if (Tools::isSubmit('idealo_export_submit'))
	    {
	        $idealoObj = new idealo();
	        $this->_postValidation();

	        if (count($this->_postErrors)) {
	            $html .= '<div class="alert error">';
	            foreach ($this->_postErrors as $err)
	                $html .= $err . '<br>';
	            $html .= '</div>';

	            $idealoObj->saveSettings();
	        }
	        else {
	            return $idealoObj->runExport();
	        }
	    }

	    return $html . $this->_displayForm();
	}

	private function _postValidation()
	{
	    if(!Tools::getValue('filename'))
            $this->_postErrors[] = $this->l('* Enter a value for the file name!');
        if(!Tools::getValue('fieldseparator'))
            $this->_postErrors[] = $this->l('* Enter a column separator!');
        if($this->_checkPaymentSelectedExistInRequest() === false)
            $this->_postErrors[] = $this->l('* Activate at least one payment method!');
        if($this->_checkshippingSelectedExistInRequest() === false)
            $this->_postErrors[] = $this->l('* Activate shipping costs for at least one country!');
    }

    
    private function _checkPaymentSelectedExistInRequest()
    {
        $idealo_payment = new idealo_csv_payment();
        $payment = $idealo_payment->payment;

        foreach($payment as $pay) {
            if (Tools::getValue($pay['db']) == '1')
                return true;
        }

        return false;
    }

    
    private function _checkshippingSelectedExistInRequest()
    {
        $idealo_shipping = new idealo_csv_shipping();
        $shipping = $idealo_shipping->shipping;

        foreach( $shipping as $ship ) {
            if (Tools::getValue('shipping_'.$ship['country']) == '1' )
                if (Tools::getValue('fixed_shipping_'.$ship['country']))
                    return true;
        }

        return false;
    }


	
	private function _displayForm()
	{
		if ( $this->_checkFolderWriteable() === false )
		{
            global $smarty;
            return $smarty->fetch(_PS_MODULE_DIR_. 'idealocsv/views/templates/back/idealo_export_folder_error.tpl');
		}
		else
		{
			$this->allNeeded();

			$tools = new idealo_tools($this->id_lang);

			return '<font style="width: 100%" color="#000000">
								<center>
									<a href="' . $this->l('http://www.idealo.co.uk') . '" target="_blank">
									        <img src="'.$this->_path.'/img/idealo-logo.gif" alt="'.$this->displayName.'" title="'.$this->displayName.'"/>
									</a>
									<br>
									'. $this->new_idealo_version_text . '

							 <form name="export" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'"  method="post">
		    					<input id="id_lang" type="hidden" name="id_lang" value="' . $this->id_lang . '">
		    					<input id="version_nr" type="hidden" name="version_nr" value="' . IDEALO_MODULE_VERSION. '">
		    					<fieldset style="width:800px">
		    						<legend> ' . $this->l('File') . ' <sup class="required">*</sup></legend>' .
		    						$this->getFilesettings() . '
								</fieldset>
								<br>
		    					<fieldset style="width:800px">
		    						<legend> ' . $this->l('Delivery Rates') . ' <sup class="required">*</sup></legend>' .
		    						$this->getDeliveries() . '
								</fieldset>
								<br>
								<fieldset style="width:800px">
		    						<legend> ' . $this->l('Payment Costs') .  ' <sup class="required">*</sup></legend>' .
		    						$this->getPayments() . '
								</fieldset>
								<br>
								<fieldset style="width:800px">
		    						<legend> ' . $this->l('Delivery: Additional Comments') . ' </legend>
		    						 '.	$this->getPortoComment() . '
								</fieldset>
								<br>
								<fieldset style="width:800px">
		    						<legend> ' . $this->l('Filter') . ' </legend>
		    						 '.	$this->getFilter() .'
								</fieldset style="width:800px">
								<br>
								<fieldset style="width:800px">
		    						<legend> ' . $this->l('Campaigns') . ' </legend>
		    						 '.	$this->getCampaign() .'
								</fieldset>
								<br>
								<fieldset style="width:800px">
		    						<legend> ' . $this->l('Minimum order value') . ' </legend>
		    						 '.	$this->getMinimumOrderValue() .'
								</fieldset>
								<br>
								<fieldset style="width:800px">
		    						<legend> ' . $this->l('Small order value surcharge') . ' </legend>
		    						 '.	$this->getMinimumOrder() .'
								</fieldset>
								<label for="export"> </label><br>
								<input type="submit" name="idealo_export_submit" value="' . $this->l('Save settings and export articles to CSV file') . '" />' .
								'<font size=4><em><b>*</b></em></font><br><br> ' .
								'* <em>' . $this->l('idealo assumes no liability for the level of operational quality, the functionality of the module or the security of the transmitted data and disclaims any liability whatsoever for any loss or damage arising from its use. idealo may discontinue the service of the modules at any time. With the use of the modules, the cooperation partner agrees to the terms of the aforementioned disclaimer by idealo.') . '</em>' .
							'</form></font>';
		}
  	}




	
	 public function getMinimumOrderValue()
	 {
	 	return '<table>
					<tr>
						<td width="20%">
							<b> ' . $this->l('Minimum order value') . ' </b>
					 	</td>
			 			<td width="20%">
			 				<input id="minorder" type="text" name="minorder" size="10" value="' . $this->minOrder . '" />
			 			</td>
			 			<td>
							' . $this->l('Please enter your minimum order value. Please use a dot as the decimal symbol, e.g. 5.00. A corresponding shipping comment will automatically be added to the affected offers.') . '
					 	</td>
			 		</tr>
			 	</table>';
	 }


	
	 public function getMinimumOrder()
	 {
	 	return '<table>
					<tr>
						<td width="20%">
							<b> ' . $this->l('Small order value surcharge') . ' </b>
					 	</td>
			 			<td width="20%">
			 				<input id="small_order_value_surcharge" type="text" name="small_order_value_surcharge" size="10" value="' . $this->minOrderPrice . '" />
			 			</td>
			 			<td>
							' . $this->l('Please enter the surcharge amount. Please use a dot as the decimal symbol, e.g. 2.99.') . '
					 	</td>
			 		</tr>
			 		<tr>
						<td width="20%">
							<b> ' . $this->l('Upper limit for surcharge for small order value') . ' </b>
					 	</td>
			 			<td width="20%">
			 				<input id="upper_limit" type="text" name="upper_limit" size="10" value="' . $this->idealoMinorderBorder . '" />
			 			</td>
			 			<td>
							' . $this->l('Please enter the amount above which the minimum order surcharge no longer applies. Please use a dot as the decimal symbol, e.g. 49.95.') . '
					 	</td>
			 		</tr>
			 	</table>';

	 }


	
	 public function getFilter()
	 {
	 	$schema = '';
	 	foreach($this->filter as $f)
	 		$schema .= $this->getFilterDetails($f);

		 return $schema;
	 }


	
	 public function getFilterDetails($filter)
	 {
	   $schema = '<fieldset>
	    				<legend> ' . $this->l('Filter for')  . ' ' . $this->l($filter['display']) . ' </legend>
	    				<table>
							<tr>
								<td width="20%">
									<b> ' . $this->l('Option') . ' </b>
	   						 	</td>
					 			<td width="20%">
									<SELECT name = "' . $filter['name'] . '">';
		if($filter['type'] == '1'){
			$schema.= '<OPTION value="1" SELECTED>' . $this->l('Filter') . '</OPTION>
					   <OPTION value="0">' . $this->l('export') . '</OPTION>';
		}else{
			$schema.= '<OPTION value="1">' . $this->l('Filter') . '</OPTION>
					   <OPTION value="0" SELECTED>' . $this->l('export') . '</OPTION>';
		}

		$schema .= '				</SELECT>
								</td>
					 			<td>
									' .sprintf($this->l('Select whether the %s should be filtered, or whether "only this" should be exported.'), $this->l($filter['display'])) .
	   						 	'</td>
					 		</tr>
					 		<tr>
								<td width="20%">
									<b> ' . $this->l('Values') . ' </b>
	   						 	</td>
					 			<td width="20%">
					 				<input id="' . $filter['name'] . '_values" type="text" name="' . $filter['name'] . '_values" size="10" value="' . $filter['values'] . '" />
					 			</td>
					 			<td>
									' . sprintf($this->l('Please enter the %s here. Separate them with a semicolon ";".'), $this->l($filter['display']));
		if($filter['name'] == 'category'){
			$schema .= ' ' .	$this->l('It is sufficient to provide a sub-path for categories. Should an article be found within the sub-path, it will be filtered out. example "TV": all categories with "TV" in the sub-path') . ' ';
		}
	   	$schema .= 		 	'</td>
					 		</tr>
					 	</table>
					 </fieldset>
					 <br>';
		return $schema;
	 }

	
    public function getFilesettings()
    {
	 	return '<table>
    				<tr>
    					<td width="20%">
    						<b> ' . $this->l('File Name') . ' </b><sup class="required">*</sup>
    				 	</td>
    		 			<td width="20%">
    		 				<input id="filename" type="text" name="filename" size="10" value="' . $this->filename . '" />
    		 			</td>
    		 			<td>
    						' . $this->l('Enter a name for the file to be saved to the server. (Directory Export/)') . '
    				 	</td>
    		 		</tr>
    		 		<tr>
    					<td width="20%">
    						<b> ' . $this->l('Column Separator') . ' </b><sup class="required">*</sup>
    		 			</td>
    		 			<td width="20%">
    						<input id="fieldseparator" type="text" name="fieldseparator" size="10" maxlength="1" value="' . htmlentities($this->fieldseparator) . '" />
    					</td>
    					<td>
    						' . $this->l('Example: ; (Semicolon) , (Comma) | (Pipe)') . '
    				 	</td>
    		 		</tr>
    		 		<tr>
    					<td width="20%">
    						<b> ' . $this->l('Quotation Marks (optional)') . ' </b>
    		 			</td>
    		 			<td width="20%">
    						<input id="quoting" type="text" name="quoting" size="10" maxlength="1" value="' . htmlentities($this->quoting) . '" />
    					</td>
    					<td>
    						' . $this->l('Example: " (Quotation marks) \' (Apostrophe) # (Hash)') . '
    				 	</td>
    		 		</tr>
    		 	</table>';
    }

    
    public function getPortoComment(){
        $schema = '<table>
        				<tr>
        					<td width="20%">
        						<b> ' . $this->l('Delivery: Additional Comments') . ' </b>
        				 	</td>
        					<td  width="20%">
        			 			<input id="comment" type="text" name="comment" size="15" value="' . $this->comment . '" />

        					</td>
        					<td>
        						' . $this->l('The additional comments for delivery are displayed on idealo along with your offers.') .'
        					</td>
        				</tr>
        			</table>';

        return $schema;
    }


    
    public function getCampaign(){
	   	$schema = '<table>
						<tr>
							<td width="20%">
								<b> ' . $this->l('Status') . ' </b>
						 	</td>
							<td  width="20%">
					 			<SELECT name = "campaign">';

		if($this->campaign == '0'){
			$schema.= '<OPTION value="0" SELECTED>' . $this->l('no compaign') . '</OPTION>
				  	   <OPTION value="1">' . $this->l('idealo') . '</OPTION>';
		}else{
			$schema.= '<OPTION value="0">' . $this->l('no compaign') . '</OPTION>
				  	   <OPTION value="1" SELECTED>' . $this->l('idealo') . '</OPTION>';
		}



		$schema.= '				</SELECT>
							</td>
							<td>
								' . $this->l('An additional parameter is added to the exported CSV file that allows for tracking of traffic for your idealo campaigns.') .'
							</td>
						</tr>
					</table>';
		return $schema;
    }

    
    public function getPayments()
    {
	  	$schema = '';
		foreach($this->payment as $pay)
			$schema .= $this->getPaymentDetails($pay);

		return $schema;
    }

	
	 public function getPaymentDetails($pay){
	 	$schema = '<fieldset>
	    						<legend> ' .  $this->l($pay['title']) .' </legend>
					<table>
						<tr>
							<td width="20%">
								<b> ' . $this->l('Status') . ' </b>
						 	</td>
							<td  width="20%">
					 			<SELECT name = "' . $pay['db'] . '">';
		if($pay['active'] == '1'){
			$schema.= '<OPTION value="1" SELECTED>' . $this->l('on') . '</OPTION>
					   <OPTION value="0">' . $this->l('off') . '</OPTION>';
		}else{
			$schema.= '<OPTION value="1">' . $this->l('on') . '</OPTION>
					   <OPTION value="0" SELECTED>' . $this->l('off') . '</OPTION>';
		}
		$schema.= '				</SELECT>
							</td>
							<td>
								' . $this->l('Only activated payment methods are exported.') .'
							</td>
						</tr>
						<tr>
							<td width="20%">
								<b> ' . $this->l('Additional charges for payment as a percentile of order value') . ' </b>
						 	</td>
						 	<td width="20%">
	   							<input id="' . $pay['db'] . '_percent" type="text" name="' . $pay['db'] . '_percent" size="10" value="' . $pay['percent'] . '" />
	   						</td>
	   						<td>
	   							' . $this->l('Additional charge is calculated as a percentage of the order value. (example: 5.00 or 3 ...)') . '
	   						</td>
	   					</tr>
	   					<tr>
							<td width="20%">
								<b> ' . $this->l('Fixed additional charges for payment') . ' </b>
						 	</td>
						 	<td width="20%">
	   							<input id="' . $pay['db'] . '_fix" type="text" name="' . $pay['db'] . '_fix" size="10" value="' . $pay['fix'] . '" />
	   						</td>
	   						<td>
	   							' . $this->l('Fixed additional charge is calculated based on the order value. (example: 2.50 or 2 ...)') . '
	   						</td>
	   					</tr>
	   					<tr>
							<td width="20%">
								<b> ' . $this->l('incl. / excl. Shipping costs') . ' </b>
						 	</td>
						 	<td width="20%">
						 		<SELECT name = "shipping_' . $pay['db'] . '_inclusive">';
		if($pay['shipping'] == '1'){
				$schema.= '<OPTION value="1" SELECTED>' . $this->l('incl. Shipping costs') . '</OPTION>
						   <OPTION value="0">' . $this->l('excl. Shipping costs') . '</OPTION>';
			}else{
				$schema.= '<OPTION value="1">' . $this->l('incl. Shipping costs') . '</OPTION>
						   <OPTION value="0" SELECTED>' . $this->l('excl. Shipping costs') . '</OPTION>';
			}
	   	$schema .= '			</SELECT>
	   						</td>
	   						<td>
	   							' . $this->l('If incl. Shipping costs is set, the cost of delivery is taken into account in the calculation?') . '
	   						</td>
	   					</tr>
					</table>
				</fieldset>
				<br>';
		return $schema;
	 }

	
	 public function getDeliveries(){
	 	$schema = '';
	 	foreach($this->shipping as $ship){
     		$active = Db::getInstance()->ExecuteS("SELECT `active` FROM `" ._DB_PREFIX_. "country` WHERE `iso_code` LIKE '" . $ship['country'] . "' AND `active` = 1");

     		if($active) {
    			if($active[0]['active'] == '1'){
    	 			$schema .= $this->getShippingModul($ship['country']);
    			}
     		}
	 	}
	 	return $schema;
	 }

	
	public function getShippingModul( $country )
	{
		$schema = '<fieldset>
                    <legend> ' . $this->l('Shipping to') . ' ' . $country .' </legend>
					<table>
						<tr>
							<td width="20%">
								<b> ' . $this->l('Choose shipping type') . ' </b>
						 	</td>
							<td  width="20%">
					 		    <SELECT name = "shipping_' . $country . '">';

		if ( $this->shipping [ $country ] [ 'active' ] == '1' ){
			$schema .= '	        <OPTION value="1" SELECTED>' . $this->l('on') . '</OPTION>
								    <OPTION value="0">' . $this->l('off') . '</OPTION>';
		}else{
			$schema .= '	        <OPTION value="1">' . $this->l('on') . '</OPTION>
								    <OPTION value="0" SELECTED>' . $this->l('off') . '</OPTION>';
		}

        $schema .= 	'	        </SELECT>
							</td>
							<td>
					    		' . $this->l('If active, exports the shipping costs entered in the idealo export module for that country.') . '
							</td>
					 		</tr>
						<tr>
							<td width="20%">
								<b> ' . $this->l('Choose type') . ' </b>
						 	</td>
						<td  width="20%">
					 		<SELECT name = "shipping_' . $country . '_pay_type">';

		foreach ( $this->shipping_type as $type ){
			if ( $this->shipping [ $country ] [ 'type' ] == $type ){
				$schema .= '    <OPTION value="' . $type . '" SELECTED>' . $this->l ( $type ) . '</OPTION>';
			}else{

				$schema .= '    <OPTION value="' . $type . '">' . $this->l ( $type ) . '</OPTION>';
			}
		}

		$schema .= 	'    	</SELECT>
                        </td>
						<td>
							' . $this->l('Choose type of shipping costs.') . '
					 	</td>
			 		</tr>
			 		<tr>
						<td  width="20%">
							<b> ' . $this->l('Fixed shipping cost') . ' </b>
			 			</td>
			 			<td  width="20%">
							<input id="fixed_shipping_' . $country . '" type="text" name="fixed_shipping_' . $country . '" size="15" value="' . $this->shipping [ $country ] [ 'costs' ] . '" />
						</td>
						<td>
							' . $this->l('Please enter your flat delivery rate.') . '
					 	</td>
			 		</tr>
			 		<tr>
						<td  width="20%">
							<b> ' . $this->l('Free shipping from') . ' </b>
			 			</td>
			 			<td  width="20%">
							<input id="free_shipping_' . $country . '" type="text" name="free_shipping_' . $country . '" size="15" value="' . $this->shipping [ $country ] [ 'free' ] . '" />
						</td>
						<td>
							' . $this->l('Where delivery above a certain value is free of charge, please enter that value. E.g. 50') . '
					 	</td>
			 		</tr>
			 	</table>
			</fieldset>
            <br>';

		return $schema;
	}

	
	private function _checkFolderWriteable()
	{
	    $path = dirname( __FILE__ ) . '/../../export/';

	    if ( is_writable( $path ) === false )
            return false;

	    return true;
	}
}