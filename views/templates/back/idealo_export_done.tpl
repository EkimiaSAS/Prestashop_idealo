{if $fieldSeparatorCounter > 0}
    <script>alert('{$fieldSeparatorCounterAlertTxt}');</script>
{/if}

<form style="width: 100%; text-align: center; font-weight:bold;" action="{$smarty.server.REQUEST_URI|escape:'htmlall'}" method="post"> 
    <div id="logo">
        <img src="{l s='http://www.idealo.co.uk/pics/common/logo.gif' mod='idealocsv'}" alt="Price Comparison" class="logo noborder"/>
    </div>
    <br><br>
    <p>{l s='The File has been successfully exported.' mod='idealocsv'}</p>
    <p>{l s='You may download the file here:' mod='idealocsv'}</p>
    
    <a href="../export/{$cleanFileName}">
        <img src="../modules/idealocsv/img/idealo_csv_file.gif" alt="{l s='You may download the file here:' mod='idealocsv'}" />
    </a>
    
    <p>{l s='Link to the CSV File:' mod='idealocsv'}</p>
    <p>
        <a style="color: #FF8C00;" href="../export/{$cleanFileName}" >
            {$base_url}export/{$cleanFileName}
        </a> 
    </p>
    <p>{l s='please send this link to csv@idealo.de' mod='idealocsv'}</p>
   
    <input type="submit" name="idealo_export_back" value="{l s='Back to the settings page' mod='idealocsv'}" />
</form>