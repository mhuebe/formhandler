<?php
/**
 * ext tables config file for ext: "formhandler"
 *
 * @author Reinhard Führicht <rf@typoheads.at>

 * @package	Tx_Formhandler
 */
 
 /**
	\mainpage 	
	
	 @version V1.0.0 Beta

	Released under the terms of the GNU General Public License version 2 as published by
	the Free Software Foundation.
	
	The swiss army knife for all kinds of mailforms, completely new written using the MVC concept. 
	Result: Flexibility, Flexibility, Flexibility. Formhandler is a total redesign of the getting-old
	MailformPlus (aka th_mailformplus). Formhandler has now a new core, new architecture, new features.

	Beside the reach set of features provided by Formhandler, you may like the flexibility in the sense
	of possible different configuration. Projects have all their own specificities. One customer want this 
	component while the other one want to have this other one. I think it is very challenging to come up 
	with an extension that is features reach without overloading the code basis.
	
	Formhandler solves the problem by having a very modular approach. The extension is piloted 
	mainly by some nice TypoScript where is is possible to define exactly what to implement. You may
	want to play with some interceptor, finisher, logger, validators etc... For more information,
	you should have a look into the folder "Examples" of the extension which refers many interesting samples.
		
	Latest development version on
	http://forge.typo3.org/repositories/show/extension-formhandler
	  
 */

if (!defined ('TYPO3_MODE')) die ('Access denied.');

if (TYPO3_MODE == 'BE')   {

	# dynamic flexform
	include_once(t3lib_extMgm::extPath($_EXTKEY) . '/Resources/PHP/class.tx_dynaflex.php');
	
	t3lib_div::loadTCA('tt_content');
	
	// Add flexform field to plugin options
	$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
	
	if(!is_object($GLOBALS['BE_USER']) || !$GLOBALS['BE_USER']->checkCLIuser()) {
		$GLOBALS['BE_USER'] = t3lib_div::makeInstance('t3lib_beUserAuth');
		
		// New backend user object
		$GLOBALS['BE_USER']->start(); // Object is initialized
		$GLOBALS['BE_USER']->checkCLIuser();
		$GLOBALS['BE_USER']->backendCheckLogin(); 
		$GLOBALS['BE_USER']->fetchGroupData();
		
		// set proper be configuration
 		$GLOBALS['BE_USER']->warningEmail = $TYPO3_CONF_VARS['BE']['warning_email_addr'];
 		$GLOBALS['BE_USER']->lockIP = $TYPO3_CONF_VARS['BE']['lockIP'];
 		$GLOBALS['BE_USER']->auth_timeout_field = intval($TYPO3_CONF_VARS['BE']['sessionTimeout']);
 		$GLOBALS['BE_USER']->OS = TYPO3_OS;
	}
	
	$file = 'FILE:EXT:' . $_EXTKEY . '/Resources/XML/flexform_ds.xml';

	$tsConfig = t3lib_BEfunc::getModTSconfig(0, 'plugin.Tx_Formhandler');
	$tsConfig = $tsConfig['properties'];
	if($tsConfig['flexformFile']) {
		$file = $tsConfig['flexformFile'];
	}
	
	// Add flexform DataStructure
	t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', $file);

	t3lib_extMgm::addModule('web', 'txformhandlermoduleM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Controller/Module/');
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_formhandler_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'Resources/PHP/class.tx_formhandler_wizicon.php';
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/Settings/', 'Example Configuration');
t3lib_extMgm::addPlugin(array('Formhandler', $_EXTKEY . '_pi1'), 'list_type');
t3lib_extMgm::addPlugin(array('Formhandler Listing', $_EXTKEY . '_pi2'), 'list_type');


$TCA['tx_formhandler_log'] = array (
    'ctrl' => array (
		'title' => 'LLL:EXT:formhandler/Resources/Language/locallang_db.xml:tx_formhandler_log',
		'label' => 'uid',
		'default_sortby' => 'ORDER BY crdate DESC',
		'crdate' => 'crdate',
		'tstamp' => 'tstamp',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php'
	)
);

?>