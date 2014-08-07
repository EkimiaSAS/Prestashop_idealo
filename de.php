<?php

/*
	Idealo, Export-Modul

	(c) Idealo 2013,
	
	Please note that this extension is provided as is and without any warranty. It is recommended to always backup your installation prior to use. Use at your own risk.
	
	Extended by
	
	Christoph Zurek (Idealo Internet GmbH, http://www.idealo.de)
*/



global $_MODULE;
$_MODULE = array();
$_MODULE['<{idealocsv}prestashop>idealocsv_127d678669f0b2d657b2b66297ca2acc'] = 'idealo CSV Export Modul';
$_MODULE['<{idealocsv}prestashop>idealocsv_06216849e7b3300d8c63e69f13ba5ccf'] = 'Erstellen Sie eine für idealo optimierte CSV-Datei.';
$_MODULE['<{idealocsv}prestashop>idealocsv_a11a43b85bdd09aeb0a95d09208dcdbc'] = 'idealo - csv Exportmodul V  %s für PrestaShop vom %s';
$_MODULE['<{idealocsv}prestashop>idealocsv_05963dbc0fad3dc9e5053725674968f8'] = 'Die Version ';
$_MODULE['<{idealocsv}prestashop>idealocsv_73cde6b8b3aadf5923f0ba39c4f8d4a7'] = ' des Moduls ist auf idealo verfügbar.';
$_MODULE['<{idealocsv}prestashop>idealocsv_55c788cb07a961ecc3afc988948854ca'] = 'Da das installierte Modul für Ihr Shopsystem modifiziert wurde, wenden Sie sich für ein Update bitte an csv@idealo.de.';
$_MODULE['<{idealocsv}prestashop>idealocsv_96613e4efeaf39287aeb262940c96ac9'] = '* Bei dem Dateinamen bitte einen Wert eintragen!';
$_MODULE['<{idealocsv}prestashop>idealocsv_0cd07d09958dc8206398ae08c2b4ac53'] = '* geben Sie bitte einen Spaltentrenner an!';
$_MODULE['<{idealocsv}prestashop>idealocsv_259962592b46d0acd198a30798e8abd5'] = '* min. eine Zahlungsart muss aktiviert werden!';
$_MODULE['<{idealocsv}prestashop>idealocsv_ea045721eb7ef65d2b8ac542814a3e53'] = '* Versandkosten für min. ein Land aktivieren!';
$_MODULE['<{idealocsv}prestashop>idealocsv_45a219003057c4aa4424e073320da4ce'] = 'http://www.idealo.de';
$_MODULE['<{idealocsv}prestashop>idealocsv_0b27918290ff5323bea1e3b78a9cf04e'] = 'Datei';
$_MODULE['<{idealocsv}prestashop>idealocsv_a4d80b6aeee3fce14fdf942aeb3f2327'] = 'Versandkosten';
$_MODULE['<{idealocsv}prestashop>idealocsv_259ba66d3fde4b4eab93d3cb54cd4908'] = 'Kosten für Zahlungsarten';
$_MODULE['<{idealocsv}prestashop>idealocsv_4e9fc737846e69326c7c2e89205f5917'] = 'Versandkommentar';
$_MODULE['<{idealocsv}prestashop>idealocsv_d7778d0c64b6ba21494c97f77a66885a'] = 'Filter';
$_MODULE['<{idealocsv}prestashop>idealocsv_504894b22ecc743eb94d05d5c70e4f80'] = 'Kampagnen';
$_MODULE['<{idealocsv}prestashop>idealocsv_84311657be7570a479cc7be41bbef0b9'] = 'Mindestbestellmenge';
$_MODULE['<{idealocsv}prestashop>idealocsv_5f75441b3f2ee6911c742a0a05303165'] = 'Mindermengenzuschlag';
$_MODULE['<{idealocsv}prestashop>idealocsv_72f82f383b04f2d0293a2c6659d3f44d'] = 'Eistellungen speichern und Produkte in die CSV-Datei exportieren';
$_MODULE['<{idealocsv}prestashop>idealocsv_c1a8ae9a885ba4a47b55fc8ef755f0bc'] = 'idealo übernimmt keine Haftung für den einwandfreien Betrieb, die Funktionalität des Moduls, der Sicherheit der übertragenen Daten und Haftung für etwaige Schäden. idealo kann den Service der Module jederzeit einstellen. Mit der Nutzung der Module stimmt der Kooperationspartner dem vorgenannten Haftungsausschluss von idealo zu.';
$_MODULE['<{idealocsv}prestashop>idealocsv_2fc2beade0f449b7e75352a72011ac82'] = 'Tragen Sie Ihren Mindestbestellwert ein. Verwenden Sie als Dezimaltrenner das Punktzeichen, z.B. 5.00. Die betreffenden Angebote erhalten automatisch einen entsprechenden Versandkommentar.';
$_MODULE['<{idealocsv}prestashop>idealocsv_e77afe9cf1a0431a78840f1fe98ab926'] = 'Tragen Sie die Höhe des Zuschlages ein. Verwenden Sie als Dezimaltrenner das Punktzeichen, z.B. 2.99. ';
$_MODULE['<{idealocsv}prestashop>idealocsv_c65385840dab13adf9884c667ea1eb0f'] = 'Mindermengengrenze';
$_MODULE['<{idealocsv}prestashop>idealocsv_3f8650ec83c79f9a9210d91bb6efaf2e'] = 'Tragen Sie den Betrag ein, ab welchem der Mindermengenzuschlag nicht mehr anfällt. Verwenden Sie als Dezimaltrenner das Punktzeichen, z.B. 49.95';
$_MODULE['<{idealocsv}prestashop>idealocsv_e4089e22364748f114e526b00b9ee625'] = 'Filter nach';
$_MODULE['<{idealocsv}prestashop>idealocsv_054b4f3ea543c990f6b125f41af6ebf7'] = 'Einstellung';
$_MODULE['<{idealocsv}prestashop>idealocsv_b2507468f95156358fa490fd543ad2f0'] = 'exportieren';
$_MODULE['<{idealocsv}prestashop>idealocsv_809a9a3a08f35cefaef1bd043c007ce9'] = 'Wählen Sie aus, ob die %s  gefiltert, oder \"nur diese\" exportiert werden sollen.';
$_MODULE['<{idealocsv}prestashop>idealocsv_c82a6100dace2b41087ba6cf99a5976a'] = 'Werte';
$_MODULE['<{idealocsv}prestashop>idealocsv_3507eac127575d44ff9db919468af48d'] = 'Geben Sie hier die %s ein. Trennen Sie die mit einem Semikolon \";\".';
$_MODULE['<{idealocsv}prestashop>idealocsv_2e2cae30ac138d317ded2ddfd3709e55'] = 'Es ist ausreichend, um eine Sub-Pfad für die Kategorien bieten. Sollte ein Artikel innerhalb der Sub-Pfad gefunden werden, wird es herausgefiltert werden. Beispiel \"TV\": alle Kategorien mit \"TV\" in der Sub-Pfad';
$_MODULE['<{idealocsv}prestashop>idealocsv_76348cf9ddb92acc65440418b185db2d'] = 'Dateiname';
$_MODULE['<{idealocsv}prestashop>idealocsv_084c237f59059c4d1949eefa5905a29a'] = 'Geben Sie einen Dateinamen ein, unter welchem diese auf dem Server gespeichert werden soll. (Verzeichnis export/)';
$_MODULE['<{idealocsv}prestashop>idealocsv_d58aae3ea8fffb883cfab4e1aadd7c49'] = 'Spaltentrenner';
$_MODULE['<{idealocsv}prestashop>idealocsv_b90ce0e7046ec0bd69eaeef207aa0ede'] = 'Beispiel: ; (Semikolon) , (Komma) | (Pipe)';
$_MODULE['<{idealocsv}prestashop>idealocsv_5cc4b8e0afd0c5f1304f16b88793ea4a'] = 'Quoting (optional)';
$_MODULE['<{idealocsv}prestashop>idealocsv_b93a8a2028f433d7262b42509b70694b'] = 'Beispiel: \" (Anführungszeichen) \' (Hochkomma) # (Raute)';
$_MODULE['<{idealocsv}prestashop>idealocsv_9071da9fbccaf4b7a99fdb6f469fd943'] = 'Der Versandkommentar wird bei idealo bei Ihren Artikeln mit angezeigt. Max. 100 Zeichen';
$_MODULE['<{idealocsv}prestashop>idealocsv_ec53a8c4f07baed5d8825072c89799be'] = 'Status';
$_MODULE['<{idealocsv}prestashop>idealocsv_f2a1c243d8ba5f6756c96c15135de1eb'] = 'keine Kampagne';
$_MODULE['<{idealocsv}prestashop>idealocsv_fcf7c2942b96dc8d0a2a137171679a8b'] = 'idealo';
$_MODULE['<{idealocsv}prestashop>idealocsv_22a1baced231bbed008088691a907493'] = 'Ein zusätzlicher Parameter wird an die Produktlinks in der Exportdatei angehangen. Dieser Parameter kann mit einem Trackingtool ausgewertet werden.';
$_MODULE['<{idealocsv}prestashop>idealocsv_ed2b5c0139cec8ad2873829dc1117d50'] = 'aktive';
$_MODULE['<{idealocsv}prestashop>idealocsv_3262d48df5d75e3452f0f16b313b7808'] = 'nicht aktive';
$_MODULE['<{idealocsv}prestashop>idealocsv_48d9ec97165468afaa9aa26335fb34af'] = 'Es werden nur aktive Zahlungsarten exportiert.';
$_MODULE['<{idealocsv}prestashop>idealocsv_ca4b4edb4c2ef9cad09814aaa3631dcd'] = 'Aufschlag in %';
$_MODULE['<{idealocsv}prestashop>idealocsv_77a9d8a3c2128322b344dbe24d5a885e'] = 'Zusatzkosten werden prozentual berechnet. (Bsp.: 3.5 oder 1 ...)';
$_MODULE['<{idealocsv}prestashop>idealocsv_a3bd2795f206ee1a91f2f5ea49336951'] = 'Fixe Zusatzkosten';
$_MODULE['<{idealocsv}prestashop>idealocsv_208b193fe93c8b8fb0a9edf003279e70'] = 'Fixe Zusatzkosten. Die Zusatzkosten werden zu den Versandkosten hinzugerechnet. (Bsp.: 2.5 oder 2 ...)';
$_MODULE['<{idealocsv}prestashop>idealocsv_906f60e7df76f2005f44f5d7b09415a6'] = 'Versandkosten beachten?';
$_MODULE['<{idealocsv}prestashop>idealocsv_284946687fcc763dc51777d3c922cb8f'] = 'inkl. Versandkosten';
$_MODULE['<{idealocsv}prestashop>idealocsv_5d3e5a920f776a2752d7020d9b920d45'] = 'exkl. Versandkosten';
$_MODULE['<{idealocsv}prestashop>idealocsv_8f717379e323fd56886a7b177f247d82'] = 'Berechnung der Zahlungskosten unter Beachtung der Versandkosten?';
$_MODULE['<{idealocsv}prestashop>idealocsv_7248887b843be8f769b453dbb6837090'] = 'Versand nach';
$_MODULE['<{idealocsv}prestashop>idealocsv_861613cae86ad44ac88d8f35c1495f37'] = 'Wählen Sie die Versandart';
$_MODULE['<{idealocsv}prestashop>idealocsv_15cd003e195bf9cf45e2b86a663139b6'] = 'Bei aktiven Status werden Versandkosten für dieses Land exportiert.';
$_MODULE['<{idealocsv}prestashop>idealocsv_7dcc1208fa03381346955c6732d9ea85'] = 'Typ wählen';
$_MODULE['<{idealocsv}prestashop>idealocsv_b9adb4f12f514803e778415fe4c88b26'] = 'Wählen Sie den Typ der Versandkosten.';
$_MODULE['<{idealocsv}prestashop>idealocsv_8d035e3e6046de5cbf5006382a1193df'] = 'Feste Versandkosten';
$_MODULE['<{idealocsv}prestashop>idealocsv_0e007b3eedc37435a617ce51341631f8'] = 'Fügen Sie bitte Ihre Pauschalen Versandkosten ein';
$_MODULE['<{idealocsv}prestashop>idealocsv_e268cede04562e8808056adec47ace55'] = 'Versandkosten frei ab';
$_MODULE['<{idealocsv}prestashop>idealocsv_3d2d1205ea61ebb2143358f443477bb2'] = 'Geben Sie bitte ein, ab welchem Betrag Sie versandkostenfrei versenden. z.B. 50';
$_MODULE['<{idealocsv}prestashop>idealo_b80bb7740288fda1f201890375a60c8f'] = 'Artikel ID';
$_MODULE['<{idealocsv}prestashop>idealo_8c4d3a946a1fcde2ded7e17651fd0ed7'] = 'Hersteller';
$_MODULE['<{idealocsv}prestashop>idealo_d5d3db1765287eef77d7927cc956f50a'] = 'Bezeihnung';
$_MODULE['<{idealocsv}prestashop>idealo_3adbdb3ac060038aa0e6e6c138ef9873'] = 'Kategorie';
$_MODULE['<{idealocsv}prestashop>idealo_36e3402e4ddef43e92b99aef016c057e'] = 'Beschreibung kurz';
$_MODULE['<{idealocsv}prestashop>idealo_67daf92c833c41c95db874e18fcb2786'] = 'Beschreibung lang';
$_MODULE['<{idealocsv}prestashop>idealo_960c0e7e450d30197e94cd2f5f5603d4'] = 'Bildlink';
$_MODULE['<{idealocsv}prestashop>idealo_2a304a1348456ccd2234cd71a81bd338'] = 'Artikellink';
$_MODULE['<{idealocsv}prestashop>idealo_78a5eb43deef9a7b5b9ce157b9d52ac4'] = 'Preis';
$_MODULE['<{idealocsv}prestashop>idealo_f24431ce9f1b8885678b1ed611c4c214'] = 'Lagerstatus';
$_MODULE['<{idealocsv}prestashop>idealo_31211b6813083b13df997b9e3abbbd2b'] = 'Lieferzeit';
$_MODULE['<{idealocsv}prestashop>idealo_07b4b2c49b5013b1baf361d941b058a2'] = 'Gewicht';
$_MODULE['<{idealocsv}prestashop>idealo_4a3faa1c0c986f216fbe72d9148ea146'] = 'Grundpreis';
$_MODULE['<{idealocsv}prestashop>idealo_1a5cfa5d07a7c36cc9d95215a81fcc59'] = 'ean';
$_MODULE['<{idealocsv}prestashop>idealo_3f9178c25b78ed8bed19091bcb62e266'] = 'Zustand';
$_MODULE['<{idealocsv}prestashop>idealo_5f75441b3f2ee6911c742a0a05303165'] = 'Mindermengenzuschlag';
$_MODULE['<{idealocsv}prestashop>idealo_9c11224d7c7d19f88b06c9459a23bf3e'] = 'Datei zuletzt erstellt am %s Uhr';
$_MODULE['<{idealocsv}prestashop>idealo_a11a43b85bdd09aeb0a95d09208dcdbc'] = 'idealo - csv Exportmodul V  %s für PrestaShop vom %s';
$_MODULE['<{idealocsv}prestashop>idealo_109635183c4d04e543d9936869bdbcaf'] = 'Zum Kauf verfügbar';
$_MODULE['<{idealocsv}prestashop>idealo_67c19e107de33cab7ea9a9db8bc9ccd2'] = 'Nicht verfügbar';
$_MODULE['<{idealocsv}prestashop>idealo_1fc30ba4f3bff01ebc732db47a56da02'] = 'Minimum order value:';
$_MODULE['<{idealocsv}prestashop>idealo_80a243a927634a53d6c5fca043fad4a4'] = 'EUR Minimum order surcharge under';
$_MODULE['<{idealocsv}prestashop>idealo_f644e53ad2526d146e8de89e99834dec'] = 'EUR product value';
$_MODULE['<{idealocsv}prestashop>idealo_c19de945e54b248627b8afb86df0d341'] = 'Der eingestellte Spaltentrenner \"%s\" kommt in Ihren Texten %s mal vor!';
$_MODULE['<{idealocsv}prestashop>idealo_3af7bf9ccfbe9887bdffe032b7d546d5'] = 'Dies kann zur Spaltenverschiebungen in Ihrer Datei fuehren.';
$_MODULE['<{idealocsv}prestashop>idealo_32248063db1e67001f75077d5d199fd6'] = 'Alternativ sollten Sie einen der folgenden Spaltentrenner verwenden:';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_052613bc841421db4100c0471e9e6ad5'] = 'http://cdn.idealo.com/ipc/1/-WmNoOZsF/pics/logos/logo_blue_big.png';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_c17afb87854af054a7ff4863c48240d7'] = 'Ihre Artikel wurden erfolgreich exportiert.';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_86e09c154bf19b3f79a4a0cc035b62ec'] = 'Sie können die datei hier herunterladen:';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_b92cbb78aae691ad8f7a9758c5b1c7bc'] = 'Link zu der CSV Datei:';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_dd5a2803668470f5865599b1d54711d3'] = 'Schicken Sie diesen Link bitte an csv@idealo.de';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_d877d78aff1d58797f3189f35b73b40d'] = 'Zurück zu den Einstellungen';
$_MODULE['<{idealocsv}prestashop>idealo_export_folder_error_fdacefb9b06b9ab60906e35969d0aa82'] = 'Der Ordner \"export\" kann nicht beschrieben werden!';
$_MODULE['<{idealocsv}prestashop>idealo_export_folder_error_fb1b38fcb5c2cd6cfed368955400f85f'] = 'Überprüfen Sie bitte ob der Ordner \"export\" in den Hauptverzeichniss Ihres Shops existiert und beschreibar ist!';
