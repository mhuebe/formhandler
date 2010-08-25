<?php
/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *
 * $Id: Tx_Formhandler_Finisher_ClearCache.php 22614 2009-07-21 20:43:47Z fabien_u $
 *                                                                        */

/**
 * This finisher generates a unique code for a database entry.
 * This can be used for FE user registration or newsletter registration.
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Finisher
 */
class Tx_Formhandler_Finisher_GenerateAuthCode extends Tx_Formhandler_AbstractFinisher {

	/**
	 * The main method called by the controller
	 *
	 * @return array The probably modified GET/POST parameters
	 */
	public function process() {
		$firstInsertInfo = array();
		if(is_array($this->gp['saveDB'])) {
			if(isset($this->settings['table'])) {
				foreach($this->gp['saveDB'] as $insertInfo) {
					if($insertInfo['table'] == $this->settings['table']) {
						$firstInsertInfo = $insertInfo;
						break;
					}
				}
			}
			if(empty($firstInsertInfo)) {
				reset($this->gp['saveDB']);
				$firstInsertInfo = current($this->gp['saveDB']);
			}
 		}
		$table = $firstInsertInfo['table'];
		$uid = $firstInsertInfo['uid'];
		$uidField = $firstInsertInfo['uidField'];
		if($table && $uid && $uidField) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $table, $uidField . '=' . $uid);
		
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $table, 'uid=' . $uid);
			if($res) {
				$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				$authCode = md5(serialize($row));
				$this->gp['generated_authCode'] = $authCode;
				
				// looking for the page, which should be used for the authCode Link
				// first look for TS-setting 'authCodePage', second look for redirect_page-setting, third use actual page
				$authCodePage = ''; 
				if(isset($this->settings['authCodePage'])) {
					$authCodePage = $this->settings['authCodePage'];
				} else {
					$authCodePage = Tx_Formhandler_StaticFuncs::pi_getFFvalue($this->cObj->data['pi_flexform'], 'redirect_page', 'sMISC');
				}
				if(!$authCodePage) {
					$authCodePage = $GLOBALS['TSFE']->id;
				}
			
				//create the parameter-array for the authCode Link
				$paramsArray = array_merge($firstInsertInfo, array('authCode' => $authCode, 'submitted' => 1, 'step-2' => 1));
				
				// If we have set a formValuesPrefix, add it to the parameter-array
				if(!empty(Tx_Formhandler_Globals::$formValuesPrefix)) {
					$paramsArray = array(Tx_Formhandler_Globals::$formValuesPrefix => $paramsArray);
				}
				
				// create the link, using typolink function, use baseUrl if set, else use t3lib_div::getIndpEnv('TYPO3_SITE_URL')
				$this->gp['authCodeUrl'] = '';
				if(isset($GLOBALS['TSFE']->baseUrl)) {
					$this->gp['authCodeUrl'] = $GLOBALS['TSFE']->baseUrl . $this->cObj->getTypoLink_URL($authCodePage, $paramsArray);
				} else {
					$this->gp['authCodeUrl'] = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $this->cObj->getTypoLink_URL($authCodePage, $paramsArray);
				}
			}
		}
		return $this->gp;
	}
}
?>
