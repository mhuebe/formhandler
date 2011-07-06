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
 * A view for Finisher_SubmittedOK used by Formhandler
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	View
 */
class Tx_Formhandler_View_SubmittedOK extends Tx_Formhandler_View_Form {

	/**
	 * This function fills the default markers:
	 *
	 * ###PRINT_LINK###
	 * ###PDF_LINK###
	 * ###CSV_LINK###
	 *
	 * @return string Template with replaced markers
	 */
	protected function fillDefaultMarkers() {
		parent::fillDefaultMarkers();
		$params = array (
			$this->globals->getFormValuesPrefix() => array (
				'tstamp' => $this->globals->getSession()->get('inserted_tstamp'),
				'hash' => $this->globals->getSession()->get('unique_hash'),
				'action' => 'show'
			),
			'type' => 98
		);
		$label = $this->utilityFuncs->getTranslatedMessage($this->langFiles, 'print');
		if (strlen($label) == 0) {
			$label = 'print';
		}
		$markers['###PRINT_LINK###'] = $this->cObj->getTypolink($label, $GLOBALS['TSFE']->id, $params);
		$params = array();
		if ($this->globals->getFormValuesPrefix()) {
			$params[$this->globals->getFormValuesPrefix()] = $this->gp;
		} else {
			$params = $this->gp;
		}
		if ($this->componentSettings['actions.']) {
			foreach ($this->componentSettings['actions.'] as $action=>$options) {
				$sanitizedAction = str_replace('.', '', $action);
				$class = $options['class'];
				if ($class) {
					$class = $this->utilityFuncs->prepareClassName($class);
					$generator = $this->componentManager->getComponent($class);
					$generator->init($this->gp, $options['config.']);
					$markers['###' . strtoupper($sanitizedAction) . '_LINK###'] = $generator->getLink($params);
				}
			}
		}
		$this->fillFEUserMarkers($markers);
		$this->fillFileMarkers($markers);
		$this->template = $this->cObj->substituteMarkerArray($this->template, $markers);
	}
}
?>
