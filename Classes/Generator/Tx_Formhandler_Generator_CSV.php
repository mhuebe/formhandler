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
 * Class to generate CSV files in Backend and Frontend
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Generator
 * @uses export2CSV in csv.lib.php
 */
class Tx_Formhandler_Generator_CSV {

	/**
	 * The internal CSV object
	 *
	 * @access protected
	 * @var export2CSV
	 */
	protected $csv;

	/**
	 * The GimmeFive component manager
	 *
	 * @access protected
	 * @var Tx_GimmeFive_Component_Manager
	 */
	protected $componentManager;

	/**
	 * Default Constructor
	 *
	 * @param Tx_GimmeFive_Component_Manager $componentManager The component manager of GimmeFive
	 * @return void
	 */
	public function __construct(Tx_GimmeFive_Component_Manager $componentManager) {
		$this->componentManager = $componentManager;

	}

	/**
	 * Function to generate a CSV file from submitted form values. This function is called by Tx_Formhandler_Controller_Backend
	 *
	 * @param array $records The records to export to CSV
	 * @param array $exportParams A list of fields to export. If not set all fields are exported
	 * @see Tx_Formhandler_Controller_Backend::generateCSV()
	 * @return void
	 */
	public function generateModuleCSV($records, $exportParams = array()) {

		require_once(t3lib_extMgm::extPath('formhandler') . 'Resources/PHP/parsecsv.lib.php');
		$data = array();
		$dataSorted = array();

		//build data array
		foreach($records as $record) {
			if(!is_array($record['params'])) {
				$record['params'] = array();
			}
			foreach($record['params'] as &$param) {
				if(is_array($param)) {
					$param = implode(';', $param);
				}
			}
			$data[] = $record['params'];
		}
		if(count($exportParams) > 0) {
			foreach($data as &$params) {
				
				// fill missing fields with empty value
				foreach($exportParams as $key => $param) {
					if(!array_key_exists($param, $params)) {
						$params[$param] = '';
					}
				}
				
				// remove unwanted fields
				foreach($params as $key => $value) {
					if(!in_array($key, $exportParams)) {
						unset($params[$key]);
					}
				}
			}
		}
		
		// sort data
		$dataSorted = array();
		foreach($data as $array) {
			$dataSorted[] = $this->sortArrayByArray($array, $exportParams);
		}
		$data = $dataSorted;

		// create new parseCSV object.
		$csv = new parseCSV();
		$csv->output('formhandler.csv', $data, $exportParams);
		die();
	}

	/**
	 * Function to generate a CSV file from submitted form values. This function is called by Tx_Formhandler_Finisher_SubmittedOK
	 *
	 * @param array $params The values to export to CSV
	 * @param array $exportParams A list of fields to export. If not set all fields are exported
	 * @see Tx_Formhandler_Finisher_SubmittedOK::process()
	 * @return void
	 */
	public function generateFrontendCSV($params, $exportParams = array()) {
		require_once(t3lib_extMgm::extPath('formhandler') . 'Resources/PHP/parsecsv.lib.php');

		//build data
		foreach($params as $key => &$value) {
			if(is_array($value)) {
				$value = implode(',', $value);
			}
			if(count($exportParams) > 0 && !in_array($key, $exportParams)) {
				unset($params[$key]);
			}
			$value = str_replace('"', '""', $value);
		}

		// create new parseCSV object.
		$csv = new parseCSV();
		$csv->output('formhandler.csv', $data, $exportParams);
		die();
	}
	
	private function sortArrayByArray($array, $orderArray) {
		$ordered = array();
		foreach($orderArray as $key) {
			if(array_key_exists($key, $array)) {
					$ordered[$key] = $array[$key];
					unset($array[$key]);
			}
		}
		return $ordered + $array;
	}
}
?>
