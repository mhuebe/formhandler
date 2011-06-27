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
 * $Id$
 *                                                                        */

/**
 * A logger to store submission information in TYPO3 database
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Logger
 */
class Tx_Formhandler_Logger_DB extends Tx_Formhandler_AbstractLogger {

	/**
	 * Logs the given values.
	 *
	 * @return void
	 */
	public function process() {

		//set params
		$table = 'tx_formhandler_log';

		if (!isset($this->settings['disableIPlog']) || intval($this->settings['disableIPlog']) !== 1) {
			$fields['ip'] = t3lib_div::getIndpEnv('REMOTE_ADDR');
		}
		$fields['tstamp'] = time();
		$fields['crdate'] = time();
		$fields['pid'] = $this->utilityFuncs->getSingle($this->settings, 'pid');
		if (!$fields['pid']) {
			$fields['pid'] = $GLOBALS['TSFE']->id;
		}
		ksort($this->gp);
		$keys = array_keys($this->gp);
		$serialized = serialize($this->gp);
		$hash = md5(serialize($keys));
		$fields['params'] = $serialized;
		$fields['key_hash'] = $hash;

		if (intval($this->settings['markAsSpam']) == 1) {
			$fields['is_spam'] = 1;
		}

		//query the database
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields);
		$insertedUID = $GLOBALS['TYPO3_DB']->sql_insert_id();
		$sessionValues = array (
			'inserted_uid' => $insertedUID,
			'inserted_tstamp' => $fields['tstamp'],
			'key_hash' => $hash
		);
		$this->globals->getSession()->setMultiple($sessionValues);
		if (!$this->settings['nodebug']) {
			$this->utilityFuncs->debugMessage('logging', array($table, implode(',', $fields)));
			if (strlen($GLOBALS['TYPO3_DB']->sql_error()) > 0) {
				$this->utilityFuncs->debugMessage('error', array($GLOBALS['TYPO3_DB']->sql_error()), 3);
			}
		}
	}

}
?>
