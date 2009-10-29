<?php

########################################################################
# Extension Manager/Repository config file for ext: "formhandler"
#
# Auto generated 01-09-2009 16:05
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Formhandler',
	'description' => 'The swiss army knife for all kinds of mailforms, completely new written using the MVC concept. Result: Flexibility, Flexibility, Flexibility  :-).',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.9.3',
	'state' => 'beta',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Dev-Team Typoheads',
	'author_email' => 'dev@typoheads.at',
	'author_company' => 'Typoheads GmbH',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.2.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:329:{s:12:"ext_icon.gif";s:4:"1b05";s:14:"ext_tables.php";s:4:"aa76";s:14:"ext_tables.sql";s:4:"b79b";s:41:"Classes/Utils/Tx_Formhandler_Messages.php";s:4:"733e";s:44:"Classes/Utils/Tx_Formhandler_StaticFuncs.php";s:4:"4881";s:45:"Classes/Utils/Tx_Formhandler_Template_PDF.php";s:4:"7d25";s:47:"Classes/Utils/Tx_Formhandler_Template_TCPDF.php";s:4:"4c74";s:48:"Classes/Logger/Tx_Formhandler_AbstractLogger.php";s:4:"2a95";s:43:"Classes/Logger/Tx_Formhandler_Logger_DB.php";s:4:"2983";s:58:"Classes/Interceptor/Tx_Formhandler_AbstractInterceptor.php";s:4:"3e83";s:67:"Classes/Interceptor/Tx_Formhandler_Interceptor_AntiSpamFormTime.php";s:4:"1972";s:58:"Classes/Interceptor/Tx_Formhandler_Interceptor_Default.php";s:4:"d4df";s:63:"Classes/Interceptor/Tx_Formhandler_Interceptor_Filtreatment.php";s:4:"871e";s:61:"Classes/Interceptor/Tx_Formhandler_Interceptor_IPBlocking.php";s:4:"7d4d";s:62:"Classes/Interceptor/Tx_Formhandler_Interceptor_ParseValues.php";s:4:"0ab0";s:60:"Classes/Interceptor/Tx_Formhandler_Interceptor_RemoveXSS.php";s:4:"50ea";s:55:"Classes/Interceptor/Tx_Formhandler_Interceptor_Save.php";s:4:"ec10";s:56:"Classes/Controller/Tx_Formhandler_AbstractController.php";s:4:"aeb2";s:51:"Classes/Controller/Tx_Formhandler_Configuration.php";s:4:"d5ea";s:45:"Classes/Controller/Tx_Formhandler_Content.php";s:4:"4ec1";s:57:"Classes/Controller/Tx_Formhandler_ControllerInterface.php";s:4:"d843";s:53:"Classes/Controller/Tx_Formhandler_Controller_Form.php";s:4:"042d";s:56:"Classes/Controller/Tx_Formhandler_Controller_Listing.php";s:4:"7a85";s:48:"Classes/Controller/tx_Formhandler_Dispatcher.php";s:4:"6394";s:63:"Classes/Controller/Module/Tx_Formhandler_Controller_Backend.php";s:4:"10da";s:72:"Classes/Controller/Module/Tx_Formhandler_Controller_BackendClearLogs.php";s:4:"8edc";s:35:"Classes/Controller/Module/clear.gif";s:4:"cc11";s:34:"Classes/Controller/Module/conf.php";s:4:"4d81";s:35:"Classes/Controller/Module/index.php";s:4:"3350";s:40:"Classes/Controller/Module/moduleicon.gif";s:4:"1b05";s:52:"Classes/Component/Tx_GimmeFive_Component_Manager.php";s:4:"536c";s:54:"Classes/Validator/Tx_Formhandler_AbstractValidator.php";s:4:"fbf6";s:54:"Classes/Validator/Tx_Formhandler_Validator_Default.php";s:4:"2c1f";s:67:"Classes/Validator/ErrorChecks/Tx_Formhandler_AbstractErrorCheck.php";s:4:"5ba8";s:72:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_BetweenItems.php";s:4:"3703";s:73:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_BetweenLength.php";s:4:"2e18";s:72:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_BetweenValue.php";s:4:"db7e";s:78:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_CalculatingCaptcha.php";s:4:"18d6";s:67:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Captcha.php";s:4:"e2f4";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_ContainsAll.php";s:4:"fae0";s:72:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_ContainsNone.php";s:4:"81dd";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_ContainsOne.php";s:4:"b355";s:64:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Date.php";s:4:"3f56";s:69:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_DateRange.php";s:4:"3d1c";s:65:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Email.php";s:4:"04b4";s:66:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Equals.php";s:4:"f0fd";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_EqualsField.php";s:4:"5e69";s:64:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Ereg.php";s:4:"6fbd";s:65:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Eregi.php";s:4:"cb10";s:76:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_FileAllowedTypes.php";s:4:"1562";s:72:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_FileMaxCount.php";s:4:"58fa";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_FileMaxSize.php";s:4:"a324";s:72:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_FileMinCount.php";s:4:"f913";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_FileMinSize.php";s:4:"2f24";s:72:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_FileRequired.php";s:4:"0a56";s:65:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Float.php";s:4:"3954";s:67:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Integer.php";s:4:"d885";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_IsInDBTable.php";s:4:"b9c2";s:74:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_IsNotInDBTable.php";s:4:"56c2";s:71:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_JmRecaptcha.php";s:4:"e67b";s:69:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MathGuard.php";s:4:"9e39";s:68:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MaxItems.php";s:4:"6370";s:69:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MaxLength.php";s:4:"cf48";s:68:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MaxValue.php";s:4:"fe91";s:68:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MinItems.php";s:4:"0047";s:69:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MinLength.php";s:4:"97b4";s:68:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_MinValue.php";s:4:"8464";s:75:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_NotDefaultValue.php";s:4:"2dae";s:74:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_NotEqualsField.php";s:4:"7431";s:69:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_PregMatch.php";s:4:"4c30";s:68:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Required.php";s:4:"6a06";s:73:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_SimpleCaptcha.php";s:4:"b76b";s:69:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_SrFreecap.php";s:4:"29c7";s:64:"Classes/Validator/ErrorChecks/Tx_Formhandler_ErrorCheck_Time.php";s:4:"6de4";s:44:"Classes/View/Tx_Formhandler_AbstractView.php";s:4:"cea9";s:45:"Classes/View/Tx_Formhandler_View_AntiSpam.php";s:4:"fc10";s:49:"Classes/View/Tx_Formhandler_View_Confirmation.php";s:4:"1af9";s:41:"Classes/View/Tx_Formhandler_View_Form.php";s:4:"6db8";s:44:"Classes/View/Tx_Formhandler_View_Listing.php";s:4:"e413";s:41:"Classes/View/Tx_Formhandler_View_Mail.php";s:4:"b879";s:40:"Classes/View/Tx_Formhandler_View_PDF.php";s:4:"0b85";s:60:"Classes/PreProcessor/Tx_Formhandler_AbstractPreProcessor.php";s:4:"cf71";s:67:"Classes/PreProcessor/Tx_Formhandler_PreProcessor_ClearTempFiles.php";s:4:"6722";s:60:"Classes/PreProcessor/Tx_Formhandler_PreProcessor_Default.php";s:4:"6ca9";s:70:"Classes/PreProcessor/Tx_Formhandler_PreProcessor_LoadDefaultValues.php";s:4:"7e31";s:52:"Classes/Finisher/Tx_Formhandler_AbstractFinisher.php";s:4:"05d5";s:55:"Classes/Finisher/Tx_Formhandler_Finisher_ClearCache.php";s:4:"494f";s:57:"Classes/Finisher/Tx_Formhandler_Finisher_Confirmation.php";s:4:"2409";s:47:"Classes/Finisher/Tx_Formhandler_Finisher_DB.php";s:4:"60b9";s:56:"Classes/Finisher/Tx_Formhandler_Finisher_DifferentDB.php";s:4:"b690";s:61:"Classes/Finisher/Tx_Formhandler_Finisher_GenerateAuthCode.php";s:4:"e7cd";s:49:"Classes/Finisher/Tx_Formhandler_Finisher_Mail.php";s:4:"30e0";s:53:"Classes/Finisher/Tx_Formhandler_Finisher_Redirect.php";s:4:"f1dc";s:52:"Classes/Finisher/Tx_Formhandler_Finisher_StoreGP.php";s:4:"4d07";s:63:"Classes/Finisher/Tx_Formhandler_Finisher_StoreUploadedFiles.php";s:4:"028e";s:50:"Classes/Generator/Tx_Formhandler_Generator_CSV.php";s:4:"a790";s:50:"Classes/Generator/Tx_Formhandler_Generator_PDF.php";s:4:"1f07";s:52:"Classes/Generator/Tx_Formhandler_Generator_TCPDF.php";s:4:"df9c";s:32:"Configuration/Settings/setup.txt";s:4:"1305";s:35:"Documentation/en/Administration.xml";s:4:"9332";s:34:"Documentation/en/Configuration.xml";s:4:"bce2";s:26:"Documentation/en/Index.xml";s:4:"be8f";s:33:"Documentation/en/Introduction.xml";s:4:"ed8f";s:29:"Documentation/en/Tutorial.xml";s:4:"e408";s:31:"Documentation/en/UserManual.xml";s:4:"6f71";s:25:"Examples/full_ts_setup.ts";s:4:"eba3";s:29:"Examples/SingleStep/howto.txt";s:4:"ec1f";s:28:"Examples/SingleStep/lang.xml";s:4:"d932";s:30:"Examples/SingleStep/styles.css";s:4:"3f0a";s:33:"Examples/SingleStep/template.html";s:4:"4284";s:40:"Examples/SingleStep/typoscript_setup.txt";s:4:"b8d0";s:34:"Examples/FrontendListing/howto.txt";s:4:"735d";s:38:"Examples/FrontendListing/template.html";s:4:"1b18";s:45:"Examples/FrontendListing/typoscript_setup.txt";s:4:"abc3";s:26:"Examples/Captcha/howto.txt";s:4:"8bcf";s:25:"Examples/Captcha/lang.xml";s:4:"1095";s:27:"Examples/Captcha/styles.css";s:4:"3f0a";s:30:"Examples/Captcha/template.html";s:4:"0d24";s:37:"Examples/Captcha/typoscript_setup.txt";s:4:"4e61";s:26:"Examples/Default/howto.txt";s:4:"c561";s:25:"Examples/Default/lang.xml";s:4:"80a6";s:30:"Examples/Default/template.html";s:4:"f583";s:37:"Examples/Default/typoscript_setup.txt";s:4:"63a6";s:28:"Examples/MultiStep/howto.txt";s:4:"ddbd";s:27:"Examples/MultiStep/lang.xml";s:4:"dbff";s:29:"Examples/MultiStep/styles.css";s:4:"3f0a";s:32:"Examples/MultiStep/template.html";s:4:"351a";s:39:"Examples/MultiStep/typoscript_setup.txt";s:4:"6357";s:38:"Examples/MultiStepConditions/howto.txt";s:4:"a6d2";s:37:"Examples/MultiStepConditions/lang.xml";s:4:"d8e1";s:39:"Examples/MultiStepConditions/styles.css";s:4:"3f0a";s:42:"Examples/MultiStepConditions/template.html";s:4:"b060";s:49:"Examples/MultiStepConditions/typoscript_setup.txt";s:4:"8663";s:14:"doc/index.html";s:4:"4367";s:14:"doc/manual.pdf";s:4:"301c";s:14:"doc/manual.sxw";s:4:"45f2";s:57:"tests/Tx_Formhandler_Interceptor_ParseValues_testcase.php";s:4:"435e";s:43:"tests/Tx_Formhandler_Logger_DB_testcase.php";s:4:"af87";s:45:"tests/Tx_Formhandler_StaticFuncs_testcase.php";s:4:"502d";s:51:"tests/Tx_Formhandler_Validator_Default_testcase.php";s:4:"fe4c";s:19:"tests/locallang.xml";s:4:"b30b";s:16:"Meta/Package.xml";s:4:"90ce";s:29:"Resources/XML/flexform_ds.xml";s:4:"340e";s:33:"Resources/XML/flexform_editor.xml";s:4:"b68c";s:38:"Resources/JS/addFields_predefinedJS.js";s:4:"799e";s:37:"Resources/JS/jscalendar-1.0/ChangeLog";s:4:"5628";s:34:"Resources/JS/jscalendar-1.0/README";s:4:"fd96";s:55:"Resources/JS/jscalendar-1.0/bugtest-hidden-selects.html";s:4:"2510";s:45:"Resources/JS/jscalendar-1.0/calendar-blue.css";s:4:"b8bb";s:46:"Resources/JS/jscalendar-1.0/calendar-blue2.css";s:4:"654d";s:46:"Resources/JS/jscalendar-1.0/calendar-brown.css";s:4:"f326";s:46:"Resources/JS/jscalendar-1.0/calendar-green.css";s:4:"b44e";s:45:"Resources/JS/jscalendar-1.0/calendar-setup.js";s:4:"827f";s:54:"Resources/JS/jscalendar-1.0/calendar-setup_stripped.js";s:4:"1bd1";s:47:"Resources/JS/jscalendar-1.0/calendar-system.css";s:4:"9b44";s:44:"Resources/JS/jscalendar-1.0/calendar-tas.css";s:4:"fa3b";s:48:"Resources/JS/jscalendar-1.0/calendar-win2k-1.css";s:4:"e3c6";s:48:"Resources/JS/jscalendar-1.0/calendar-win2k-2.css";s:4:"332d";s:53:"Resources/JS/jscalendar-1.0/calendar-win2k-cold-1.css";s:4:"b081";s:53:"Resources/JS/jscalendar-1.0/calendar-win2k-cold-2.css";s:4:"3487";s:39:"Resources/JS/jscalendar-1.0/calendar.js";s:4:"4479";s:40:"Resources/JS/jscalendar-1.0/calendar.php";s:4:"8f8b";s:48:"Resources/JS/jscalendar-1.0/calendar_stripped.js";s:4:"4be3";s:40:"Resources/JS/jscalendar-1.0/dayinfo.html";s:4:"9f1c";s:35:"Resources/JS/jscalendar-1.0/img.gif";s:4:"c1e5";s:38:"Resources/JS/jscalendar-1.0/index.html";s:4:"5ae1";s:41:"Resources/JS/jscalendar-1.0/menuarrow.gif";s:4:"b5a9";s:42:"Resources/JS/jscalendar-1.0/menuarrow2.gif";s:4:"1f8c";s:47:"Resources/JS/jscalendar-1.0/multiple-dates.html";s:4:"eba2";s:46:"Resources/JS/jscalendar-1.0/release-notes.html";s:4:"cb86";s:41:"Resources/JS/jscalendar-1.0/simple-1.html";s:4:"026a";s:41:"Resources/JS/jscalendar-1.0/simple-2.html";s:4:"afee";s:41:"Resources/JS/jscalendar-1.0/simple-3.html";s:4:"1980";s:46:"Resources/JS/jscalendar-1.0/test-position.html";s:4:"8db2";s:36:"Resources/JS/jscalendar-1.0/test.php";s:4:"94fb";s:52:"Resources/JS/jscalendar-1.0/skins/aqua/active-bg.gif";s:4:"f8fb";s:50:"Resources/JS/jscalendar-1.0/skins/aqua/dark-bg.gif";s:4:"949f";s:51:"Resources/JS/jscalendar-1.0/skins/aqua/hover-bg.gif";s:4:"803a";s:52:"Resources/JS/jscalendar-1.0/skins/aqua/menuarrow.gif";s:4:"1f8c";s:52:"Resources/JS/jscalendar-1.0/skins/aqua/normal-bg.gif";s:4:"8511";s:54:"Resources/JS/jscalendar-1.0/skins/aqua/rowhover-bg.gif";s:4:"c097";s:52:"Resources/JS/jscalendar-1.0/skins/aqua/status-bg.gif";s:4:"1238";s:48:"Resources/JS/jscalendar-1.0/skins/aqua/theme.css";s:4:"ec69";s:51:"Resources/JS/jscalendar-1.0/skins/aqua/title-bg.gif";s:4:"8d65";s:51:"Resources/JS/jscalendar-1.0/skins/aqua/today-bg.gif";s:4:"9bef";s:45:"Resources/JS/jscalendar-1.0/doc/reference.pdf";s:4:"8d15";s:53:"Resources/JS/jscalendar-1.0/doc/html/field-button.jpg";s:4:"3b80";s:54:"Resources/JS/jscalendar-1.0/doc/html/reference-Z-S.css";s:4:"5fa8";s:50:"Resources/JS/jscalendar-1.0/doc/html/reference.css";s:4:"ab36";s:51:"Resources/JS/jscalendar-1.0/doc/html/reference.html";s:4:"da77";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-af.js";s:4:"65fc";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-al.js";s:4:"262a";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-bg.js";s:4:"4eea";s:54:"Resources/JS/jscalendar-1.0/lang/calendar-big5-utf8.js";s:4:"4b1a";s:49:"Resources/JS/jscalendar-1.0/lang/calendar-big5.js";s:4:"8b21";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-br.js";s:4:"d8a9";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-ca.js";s:4:"7feb";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-cs-utf8.js";s:4:"aae7";s:51:"Resources/JS/jscalendar-1.0/lang/calendar-cs-win.js";s:4:"1ac7";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-da.js";s:4:"47c7";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-de.js";s:4:"b625";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-du.js";s:4:"82ab";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-el.js";s:4:"5e3c";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-en.js";s:4:"4681";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-es.js";s:4:"22e6";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-fi.js";s:4:"f201";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-fr.js";s:4:"4277";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-he-utf8.js";s:4:"7ace";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-hr-utf8.js";s:4:"05f1";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-hr.js";s:4:"48e3";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-hu.js";s:4:"4b5e";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-it.js";s:4:"70d1";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-jp.js";s:4:"b47d";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-ko-utf8.js";s:4:"9411";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-ko.js";s:4:"882d";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-lt-utf8.js";s:4:"0a5f";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-lt.js";s:4:"a0cf";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-lv.js";s:4:"030a";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-nl.js";s:4:"f0e8";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-no.js";s:4:"d834";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-pl-utf8.js";s:4:"4247";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-pl.js";s:4:"2510";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-pt.js";s:4:"4265";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-ro.js";s:4:"6011";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-ru.js";s:4:"3402";s:52:"Resources/JS/jscalendar-1.0/lang/calendar-ru_win_.js";s:4:"eafc";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-si.js";s:4:"bb1e";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-sk.js";s:4:"6e55";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-sp.js";s:4:"e6e4";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-sv.js";s:4:"d9f1";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-tr.js";s:4:"52df";s:47:"Resources/JS/jscalendar-1.0/lang/calendar-zh.js";s:4:"4e19";s:43:"Resources/JS/jscalendar-1.0/lang/cn_utf8.js";s:4:"7ae3";s:27:"Resources/PHP/RemoveXSS.php";s:4:"28d0";s:44:"Resources/PHP/class.formhandler_htmlmail.php";s:4:"f133";s:35:"Resources/PHP/class.tx_dynaflex.php";s:4:"7132";s:46:"Resources/PHP/class.tx_formhandler_wizicon.php";s:4:"6bcb";s:25:"Resources/PHP/csv.lib.php";s:4:"d2b1";s:43:"Resources/PHP/filtreatment/Filtreatment.php";s:4:"ad42";s:27:"Resources/PHP/fpdf/fpdf.css";s:4:"3c8c";s:27:"Resources/PHP/fpdf/fpdf.php";s:4:"cd91";s:35:"Resources/PHP/fpdf/font/courier.php";s:4:"b8f6";s:35:"Resources/PHP/fpdf/font/desktop.ini";s:4:"c859";s:37:"Resources/PHP/fpdf/font/helvetica.php";s:4:"d5cb";s:38:"Resources/PHP/fpdf/font/helveticab.php";s:4:"1630";s:39:"Resources/PHP/fpdf/font/helveticabi.php";s:4:"63c0";s:38:"Resources/PHP/fpdf/font/helveticai.php";s:4:"f504";s:34:"Resources/PHP/fpdf/font/symbol.php";s:4:"e3c4";s:33:"Resources/PHP/fpdf/font/times.php";s:4:"6fac";s:34:"Resources/PHP/fpdf/font/timesb.php";s:4:"8c8d";s:35:"Resources/PHP/fpdf/font/timesbi.php";s:4:"0c5d";s:34:"Resources/PHP/fpdf/font/timesi.php";s:4:"c245";s:40:"Resources/PHP/fpdf/font/zapfdingbats.php";s:4:"0c28";s:43:"Resources/PHP/fpdf/font/makefont/cp1250.map";s:4:"8a02";s:43:"Resources/PHP/fpdf/font/makefont/cp1251.map";s:4:"ee2f";s:43:"Resources/PHP/fpdf/font/makefont/cp1252.map";s:4:"8d73";s:43:"Resources/PHP/fpdf/font/makefont/cp1253.map";s:4:"9073";s:43:"Resources/PHP/fpdf/font/makefont/cp1254.map";s:4:"46e4";s:43:"Resources/PHP/fpdf/font/makefont/cp1255.map";s:4:"c469";s:43:"Resources/PHP/fpdf/font/makefont/cp1257.map";s:4:"fe87";s:43:"Resources/PHP/fpdf/font/makefont/cp1258.map";s:4:"86a4";s:42:"Resources/PHP/fpdf/font/makefont/cp874.map";s:4:"4fba";s:47:"Resources/PHP/fpdf/font/makefont/iso-8859-1.map";s:4:"53bf";s:48:"Resources/PHP/fpdf/font/makefont/iso-8859-11.map";s:4:"83ec";s:48:"Resources/PHP/fpdf/font/makefont/iso-8859-15.map";s:4:"3d09";s:48:"Resources/PHP/fpdf/font/makefont/iso-8859-16.map";s:4:"b56b";s:47:"Resources/PHP/fpdf/font/makefont/iso-8859-2.map";s:4:"4750";s:47:"Resources/PHP/fpdf/font/makefont/iso-8859-4.map";s:4:"0355";s:47:"Resources/PHP/fpdf/font/makefont/iso-8859-5.map";s:4:"82a2";s:47:"Resources/PHP/fpdf/font/makefont/iso-8859-7.map";s:4:"d071";s:47:"Resources/PHP/fpdf/font/makefont/iso-8859-9.map";s:4:"8647";s:43:"Resources/PHP/fpdf/font/makefont/koi8-r.map";s:4:"04f5";s:43:"Resources/PHP/fpdf/font/makefont/koi8-u.map";s:4:"9046";s:45:"Resources/PHP/fpdf/font/makefont/makefont.php";s:4:"341f";s:42:"Resources/PHP/mathguard/ClassMathGuard.php";s:4:"1da3";s:33:"Resources/PHP/tcpdf/CHANGELOG.TXT";s:4:"787e";s:31:"Resources/PHP/tcpdf/LICENSE.TXT";s:4:"7fbc";s:30:"Resources/PHP/tcpdf/README.TXT";s:4:"1335";s:32:"Resources/PHP/tcpdf/barcodes.php";s:4:"8e1a";s:34:"Resources/PHP/tcpdf/htmlcolors.php";s:4:"5eee";s:29:"Resources/PHP/tcpdf/tcpdf.php";s:4:"a810";s:36:"Resources/PHP/tcpdf/unicode_data.php";s:4:"bc29";s:36:"Resources/PHP/tcpdf/fonts/README.TXT";s:4:"ff43";s:40:"Resources/PHP/tcpdf/fonts/freesans.ctg.z";s:4:"543a";s:38:"Resources/PHP/tcpdf/fonts/freesans.php";s:4:"f455";s:36:"Resources/PHP/tcpdf/fonts/freesans.z";s:4:"6532";s:41:"Resources/PHP/tcpdf/fonts/freesansb.ctg.z";s:4:"5c10";s:39:"Resources/PHP/tcpdf/fonts/freesansb.php";s:4:"45f0";s:37:"Resources/PHP/tcpdf/fonts/freesansb.z";s:4:"42f4";s:42:"Resources/PHP/tcpdf/fonts/freesansbi.ctg.z";s:4:"192f";s:40:"Resources/PHP/tcpdf/fonts/freesansbi.php";s:4:"e013";s:38:"Resources/PHP/tcpdf/fonts/freesansbi.z";s:4:"e650";s:41:"Resources/PHP/tcpdf/fonts/freesansi.ctg.z";s:4:"c190";s:39:"Resources/PHP/tcpdf/fonts/freesansi.php";s:4:"f30c";s:37:"Resources/PHP/tcpdf/fonts/freesansi.z";s:4:"bbb7";s:39:"Resources/PHP/tcpdf/fonts/helvetica.php";s:4:"74b5";s:40:"Resources/PHP/tcpdf/fonts/helveticab.php";s:4:"d9ae";s:41:"Resources/PHP/tcpdf/fonts/helveticabi.php";s:4:"d9ae";s:40:"Resources/PHP/tcpdf/fonts/helveticai.php";s:4:"74b5";s:43:"Resources/PHP/tcpdf/config/tcpdf_config.php";s:4:"2010";s:47:"Resources/PHP/tcpdf/config/tcpdf_config_alt.php";s:4:"a39d";s:39:"Resources/PHP/tcpdf/config/lang/eng.php";s:4:"a064";s:39:"Resources/PHP/tcpdf/config/lang/ita.php";s:4:"6c0a";s:44:"Resources/PHP/tcpdf/cache/chapter_demo_1.txt";s:4:"f118";s:44:"Resources/PHP/tcpdf/cache/chapter_demo_2.txt";s:4:"7b9a";s:45:"Resources/PHP/tcpdf/cache/table_data_demo.txt";s:4:"2fa9";s:38:"Resources/PHP/tcpdf/cache/utf8test.txt";s:4:"f9fe";s:37:"Resources/PHP/tcpdf/images/_blank.png";s:4:"9bbf";s:36:"Resources/PHP/tcpdf/images/alpha.png";s:4:"f6d1";s:34:"Resources/PHP/tcpdf/images/bug.eps";s:4:"870d";s:41:"Resources/PHP/tcpdf/images/image_demo.jpg";s:4:"9ec6";s:47:"Resources/PHP/tcpdf/images/image_with_alpha.png";s:4:"9cee";s:34:"Resources/PHP/tcpdf/images/img.png";s:4:"24c2";s:43:"Resources/PHP/tcpdf/images/logo_example.gif";s:4:"f3d9";s:43:"Resources/PHP/tcpdf/images/logo_example.jpg";s:4:"a3ee";s:43:"Resources/PHP/tcpdf/images/logo_example.png";s:4:"5f26";s:37:"Resources/PHP/tcpdf/images/pelican.ai";s:4:"fd97";s:41:"Resources/PHP/tcpdf/images/tcpdf_logo.jpg";s:4:"d519";s:35:"Resources/PHP/tcpdf/images/tiger.ai";s:4:"3c4c";s:31:"Resources/Images/ce_wiz_pi1.png";s:4:"fad0";s:31:"Resources/Images/ce_wiz_pi2.png";s:4:"f04b";s:36:"Resources/HTML/backend/template.html";s:4:"bb49";s:32:"Resources/Language/locallang.xml";s:4:"76fc";s:35:"Resources/Language/locallang_db.xml";s:4:"a821";s:38:"Resources/Language/locallang_debug.xml";s:4:"b476";s:43:"Resources/Language/locallang_exceptions.xml";s:4:"b05b";s:36:"Resources/Language/locallang_mod.xml";s:4:"fccd";s:36:"Resources/Language/locallang_tca.xml";s:4:"9730";s:32:"Resources/CSS/backend/styles.css";s:4:"e72e";}',
	'suggests' => array(
	),
);

?>