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
*                                                                        */
/**
 * A logger to store submission information in DevLog
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 */
class Tx_Formhandler_Logger_DevLog extends Tx_Formhandler_AbstractLogger {

	/**
	 * Logs the given values.
	 *
	 * @return void
	 */
	public function process() {
		$message = 'Form on page ' . $GLOBALS['TSFE']->id . ' was submitted!';
		$severity = 1;
		if (intval($this->settings['markAsSpam']) === 1) {
			$message = 'Caught possible spamming on page ' . $GLOBALS['TSFE']->id . '!';
			$severity = 2;
		}
		$logParams = $this->gp;
		if($this->settings['excludeFields']) {
			$excludeFields = $this->utilityFuncs->getSingle($this->settings, 'excludeFields');
			$excludeFields = t3lib_div::trimExplode(',', $excludeFields);
			foreach($excludeFields as $excludeField) {
				unset($logParams[$excludeField]);
			}
		}
		t3lib_div::devLog($message, 'formhandler', $severity, $logParams);

		return $this->gp;
	}
}

?>