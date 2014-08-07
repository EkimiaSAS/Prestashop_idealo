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
$_MODULE['<{idealocsv}prestashop>idealocsv_127d678669f0b2d657b2b66297ca2acc'] = 'Module export CSV idealo';
$_MODULE['<{idealocsv}prestashop>idealocsv_06216849e7b3300d8c63e69f13ba5ccf'] = 'Elaborer un fichier CSV optimisé pour idealo';
$_MODULE['<{idealocsv}prestashop>idealocsv_a11a43b85bdd09aeb0a95d09208dcdbc'] = 'idealo - CSV export-module V %s pour PrestaShop depuis %s';
$_MODULE['<{idealocsv}prestashop>idealocsv_05963dbc0fad3dc9e5053725674968f8'] = 'La version ';
$_MODULE['<{idealocsv}prestashop>idealocsv_73cde6b8b3aadf5923f0ba39c4f8d4a7'] = ' du module est disponible sur idealo.';
$_MODULE['<{idealocsv}prestashop>idealocsv_55c788cb07a961ecc3afc988948854ca'] = 'Le système du module ayant été modifié, veuillez contacter shopsfr@idealo.fr pour une mise à jour.';
$_MODULE['<{idealocsv}prestashop>idealocsv_96613e4efeaf39287aeb262940c96ac9'] = '* Veuillez entrer un nom pour le fichier !';
$_MODULE['<{idealocsv}prestashop>idealocsv_0cd07d09958dc8206398ae08c2b4ac53'] = '* Veuillez entrer un séparateur de colonnes !';
$_MODULE['<{idealocsv}prestashop>idealocsv_259962592b46d0acd198a30798e8abd5'] = '* Veuillez activer au moins un moyen de paiement !';
$_MODULE['<{idealocsv}prestashop>idealocsv_ea045721eb7ef65d2b8ac542814a3e53'] = '* Veuillez activer les frais de port pour au moins un pays !';
$_MODULE['<{idealocsv}prestashop>idealocsv_45a219003057c4aa4424e073320da4ce'] = 'http://www.idealo.fr';
$_MODULE['<{idealocsv}prestashop>idealocsv_0b27918290ff5323bea1e3b78a9cf04e'] = 'Fichier';
$_MODULE['<{idealocsv}prestashop>idealocsv_a4d80b6aeee3fce14fdf942aeb3f2327'] = 'Frais de port';
$_MODULE['<{idealocsv}prestashop>idealocsv_259ba66d3fde4b4eab93d3cb54cd4908'] = 'Frais de port par moyen de paiement';
$_MODULE['<{idealocsv}prestashop>idealocsv_4e9fc737846e69326c7c2e89205f5917'] = 'Indication sur la livraison';
$_MODULE['<{idealocsv}prestashop>idealocsv_d7778d0c64b6ba21494c97f77a66885a'] = 'Filtres';
$_MODULE['<{idealocsv}prestashop>idealocsv_504894b22ecc743eb94d05d5c70e4f80'] = 'Campagnes';
$_MODULE['<{idealocsv}prestashop>idealocsv_84311657be7570a479cc7be41bbef0b9'] = 'Commande minimum';
$_MODULE['<{idealocsv}prestashop>idealocsv_5f75441b3f2ee6911c742a0a05303165'] = 'Frais supplémentaire pour petite quantité';
$_MODULE['<{idealocsv}prestashop>idealocsv_72f82f383b04f2d0293a2c6659d3f44d'] = 'Enregistrer les paramètres et exporter des articles vers un fichier CSV.';
$_MODULE['<{idealocsv}prestashop>idealocsv_c1a8ae9a885ba4a47b55fc8ef755f0bc'] = 'idealo décline toute responsabilité quant au bon fonctionnement, aux fonctionnalités du module, à la sécurité des données transmises et ne peut être tenu responsable en cas d’éventuels préjudices. idealo se réserve le droit de mettre en place ou retirer le module. En utilisant le module, le partenaire approuve la clause de non-responsabilité mentionnée ci-dessus.';
$_MODULE['<{idealocsv}prestashop>idealocsv_2fc2beade0f449b7e75352a72011ac82'] = 'Indiquez un montant minimun. Utilisez le point comme séparateur de décimales, ex. 5.00. Les offres concernées se verront ajouter un commentaire automatique.';
$_MODULE['<{idealocsv}prestashop>idealocsv_e77afe9cf1a0431a78840f1fe98ab926'] = 'Entrez le montant du supplément. Utilisez le point comme séparateur de décimales, ex. 2.99';
$_MODULE['<{idealocsv}prestashop>idealocsv_c65385840dab13adf9884c667ea1eb0f'] = 'Jusqu\'à quel montant est appliqué le supplément';
$_MODULE['<{idealocsv}prestashop>idealocsv_3f8650ec83c79f9a9210d91bb6efaf2e'] = 'Indiquez le montant à partir duquel les frais supplémentaires ne sont plus appliquables. Utilisez le point comme séparateur de décimales, ex. 49.95';
$_MODULE['<{idealocsv}prestashop>idealocsv_e4089e22364748f114e526b00b9ee625'] = 'Filtrer';
$_MODULE['<{idealocsv}prestashop>idealocsv_054b4f3ea543c990f6b125f41af6ebf7'] = 'Paramètre';
$_MODULE['<{idealocsv}prestashop>idealocsv_b2507468f95156358fa490fd543ad2f0'] = 'exporter';
$_MODULE['<{idealocsv}prestashop>idealocsv_c82a6100dace2b41087ba6cf99a5976a'] = 'Valeurs';
$_MODULE['<{idealocsv}prestashop>idealocsv_76348cf9ddb92acc65440418b185db2d'] = 'Nom du fichier';
$_MODULE['<{idealocsv}prestashop>idealocsv_084c237f59059c4d1949eefa5905a29a'] = 'Indiquez un nom de fichier au cas où le fichier export devrait être enregistré sur le serveur. (export de listes)';
$_MODULE['<{idealocsv}prestashop>idealocsv_d58aae3ea8fffb883cfab4e1aadd7c49'] = 'Séparateur de colonne';
$_MODULE['<{idealocsv}prestashop>idealocsv_b90ce0e7046ec0bd69eaeef207aa0ede'] = 'Exemple: ; (point-virgule) , (virgule) | (séparateur vertical)';
$_MODULE['<{idealocsv}prestashop>idealocsv_5cc4b8e0afd0c5f1304f16b88793ea4a'] = 'Citation (optionnel)';
$_MODULE['<{idealocsv}prestashop>idealocsv_b93a8a2028f433d7262b42509b70694b'] = 'Exemple: \" (guillemets) \' (apostrophe) # (dièse)';
$_MODULE['<{idealocsv}prestashop>idealocsv_9071da9fbccaf4b7a99fdb6f469fd943'] = 'Le commentaire sur la livraison est affiché sur votre offre sur idealo. Max. 100 caractères';
$_MODULE['<{idealocsv}prestashop>idealocsv_ec53a8c4f07baed5d8825072c89799be'] = 'Statut';
$_MODULE['<{idealocsv}prestashop>idealocsv_f2a1c243d8ba5f6756c96c15135de1eb'] = 'Aucune campagne';
$_MODULE['<{idealocsv}prestashop>idealocsv_fcf7c2942b96dc8d0a2a137171679a8b'] = 'idealo';
$_MODULE['<{idealocsv}prestashop>idealocsv_22a1baced231bbed008088691a907493'] = 'Un tag spécifique sera collé aux URL produits dans le fichier export.';
$_MODULE['<{idealocsv}prestashop>idealocsv_ed2b5c0139cec8ad2873829dc1117d50'] = 'actif';
$_MODULE['<{idealocsv}prestashop>idealocsv_3262d48df5d75e3452f0f16b313b7808'] = 'non actif';
$_MODULE['<{idealocsv}prestashop>idealocsv_48d9ec97165468afaa9aa26335fb34af'] = 'Seuls les moyens de paiement actifs seront exportés.';
$_MODULE['<{idealocsv}prestashop>idealocsv_ca4b4edb4c2ef9cad09814aaa3631dcd'] = 'Frais supplémentaires en %';
$_MODULE['<{idealocsv}prestashop>idealocsv_77a9d8a3c2128322b344dbe24d5a885e'] = 'Les frais supplémentaires sont facturés en pourcentage. (Ex. : 3.5 ou 1 ...)';
$_MODULE['<{idealocsv}prestashop>idealocsv_a3bd2795f206ee1a91f2f5ea49336951'] = 'Frais supplémentaires fixes';
$_MODULE['<{idealocsv}prestashop>idealocsv_208b193fe93c8b8fb0a9edf003279e70'] = 'Frais supplémentaires fixes. Les frais supplémentaires fixes sont pris en compte dans les frais de port. (Ex. : 2.5 ou 2 ...)';
$_MODULE['<{idealocsv}prestashop>idealocsv_906f60e7df76f2005f44f5d7b09415a6'] = 'Prise en compte dans les frais de livraison ?';
$_MODULE['<{idealocsv}prestashop>idealocsv_284946687fcc763dc51777d3c922cb8f'] = 'Frais de port inclus';
$_MODULE['<{idealocsv}prestashop>idealocsv_5d3e5a920f776a2752d7020d9b920d45'] = 'Frais de port exclus';
$_MODULE['<{idealocsv}prestashop>idealocsv_8f717379e323fd56886a7b177f247d82'] = 'Inclure les frais de paiement dans les frais de port ?';
$_MODULE['<{idealocsv}prestashop>idealocsv_7248887b843be8f769b453dbb6837090'] = 'Livraison en';
$_MODULE['<{idealocsv}prestashop>idealocsv_15cd003e195bf9cf45e2b86a663139b6'] = 'S\'ils sont activés, les frais de port pour ce pays seront exportés.';
$_MODULE['<{idealocsv}prestashop>idealocsv_7dcc1208fa03381346955c6732d9ea85'] = 'Choisissez le type';
$_MODULE['<{idealocsv}prestashop>idealocsv_b9adb4f12f514803e778415fe4c88b26'] = 'Choisir le type de frais d\'expédition.';
$_MODULE['<{idealocsv}prestashop>idealocsv_8d035e3e6046de5cbf5006382a1193df'] = 'Frais de port fixe';
$_MODULE['<{idealocsv}prestashop>idealocsv_0e007b3eedc37435a617ce51341631f8'] = 'Veuillez indiquer vos frais de port forfétaires';
$_MODULE['<{idealocsv}prestashop>idealocsv_e268cede04562e8808056adec47ace55'] = 'Livraison gratuite à partir de';
$_MODULE['<{idealocsv}prestashop>idealocsv_3d2d1205ea61ebb2143358f443477bb2'] = 'Veuillez indiquer à partir de quel montant la livraison est gratuite. 50, par exemple';
$_MODULE['<{idealocsv}prestashop>idealo_b80bb7740288fda1f201890375a60c8f'] = 'ID produit';
$_MODULE['<{idealocsv}prestashop>idealo_8c4d3a946a1fcde2ded7e17651fd0ed7'] = 'Fabricant';
$_MODULE['<{idealocsv}prestashop>idealo_d5d3db1765287eef77d7927cc956f50a'] = 'Description';
$_MODULE['<{idealocsv}prestashop>idealo_3adbdb3ac060038aa0e6e6c138ef9873'] = 'Catégorie';
$_MODULE['<{idealocsv}prestashop>idealo_36e3402e4ddef43e92b99aef016c057e'] = 'Description courte';
$_MODULE['<{idealocsv}prestashop>idealo_67daf92c833c41c95db874e18fcb2786'] = 'Description longue';
$_MODULE['<{idealocsv}prestashop>idealo_960c0e7e450d30197e94cd2f5f5603d4'] = 'URL photo';
$_MODULE['<{idealocsv}prestashop>idealo_2a304a1348456ccd2234cd71a81bd338'] = 'URL produit';
$_MODULE['<{idealocsv}prestashop>idealo_78a5eb43deef9a7b5b9ce157b9d52ac4'] = 'Prix';
$_MODULE['<{idealocsv}prestashop>idealo_f24431ce9f1b8885678b1ed611c4c214'] = 'Disponibilité';
$_MODULE['<{idealocsv}prestashop>idealo_31211b6813083b13df997b9e3abbbd2b'] = 'Délai de livraison';
$_MODULE['<{idealocsv}prestashop>idealo_07b4b2c49b5013b1baf361d941b058a2'] = 'Poids';
$_MODULE['<{idealocsv}prestashop>idealo_4a3faa1c0c986f216fbe72d9148ea146'] = 'Prix de base en kg';
$_MODULE['<{idealocsv}prestashop>idealo_1a5cfa5d07a7c36cc9d95215a81fcc59'] = 'EAN';
$_MODULE['<{idealocsv}prestashop>idealo_3f9178c25b78ed8bed19091bcb62e266'] = 'Etat';
$_MODULE['<{idealocsv}prestashop>idealo_9c11224d7c7d19f88b06c9459a23bf3e'] = 'Dernier fichier créé sur %s heures';
$_MODULE['<{idealocsv}prestashop>idealo_a11a43b85bdd09aeb0a95d09208dcdbc'] = 'idealo - CSV export-module V %s pour PrestaShop depuis %s';
$_MODULE['<{idealocsv}prestashop>idealo_109635183c4d04e543d9936869bdbcaf'] = 'Disponible à la vente';
$_MODULE['<{idealocsv}prestashop>idealo_67c19e107de33cab7ea9a9db8bc9ccd2'] = 'Pas disponible';
$_MODULE['<{idealocsv}prestashop>idealo_1fc30ba4f3bff01ebc732db47a56da02'] = 'Commande minimum ';
$_MODULE['<{idealocsv}prestashop>idealo_80a243a927634a53d6c5fca043fad4a4'] = 'EUR de frais supplémentaire pour commande inférieure à';
$_MODULE['<{idealocsv}prestashop>idealo_f644e53ad2526d146e8de89e99834dec'] = ' EUR de valeur de marchandise';
$_MODULE['<{idealocsv}prestashop>idealo_c19de945e54b248627b8afb86df0d341'] = 'Le séparateur de colonnes \"%s\" que vous avez choisi revient %s fois dans votre texte.';
$_MODULE['<{idealocsv}prestashop>idealo_3af7bf9ccfbe9887bdffe032b7d546d5'] = 'Ceci peut causer des décalages de colonnes dans votre fichier.';
$_MODULE['<{idealocsv}prestashop>idealo_32248063db1e67001f75077d5d199fd6'] = 'Vous devriez utiliser un des séparateurs de colonnes suivant:';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_052613bc841421db4100c0471e9e6ad5'] = 'http://www.idealo.fr/pics/common/logo.gif';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_c17afb87854af054a7ff4863c48240d7'] = 'Le fichier a été exporté avec succès.';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_86e09c154bf19b3f79a4a0cc035b62ec'] = 'Vous pouvez télécharger le fichier ici:';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_b92cbb78aae691ad8f7a9758c5b1c7bc'] = 'Lien vers le fichier CSV:';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_dd5a2803668470f5865599b1d54711d3'] = 's\'il vous plaît envoyer ce lien à csv@idealo.de';
$_MODULE['<{idealocsv}prestashop>idealo_export_done_d877d78aff1d58797f3189f35b73b40d'] = 'Retour à la page des paramètres';
$_MODULE['<{idealocsv}prestashop>idealo_export_folder_error_fdacefb9b06b9ab60906e35969d0aa82'] = 'Le dossier \"export\" doit être inscriptible!';
$_MODULE['<{idealocsv}prestashop>idealo_export_folder_error_fb1b38fcb5c2cd6cfed368955400f85f'] = 'Veuillez vérifier si le dossier \"export\" existe dans le répertoire principal de votre magasin et si elle est accessible en écriture!';
