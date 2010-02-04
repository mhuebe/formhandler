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
 * Default controller for Formhandler
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Controller
 */
class Tx_Formhandler_Controller_Form extends Tx_Formhandler_AbstractController {

	/**
	 * The GimmeFive component manager
	 *
	 * @access protected
	 * @var Tx_GimmeFive_Component_Manager
	 */
	protected $componentManager;
	
	/**
	 * The current GET/POST parameters of the form
	 *
	 * @access protected
	 * @var array
	 */
	protected $gp;
	
	/**
	 * Contains all errors occurred while validation
	 *
	 * @access protected
	 * @var array
	 */
	protected $errors;
	
	/**
	 * Holds the prefix value of all parameters of this form.
	 *
	 * @access protected
	 * @var string
	 */
	protected $formValuesPrefix;

	/**
	 * The global Formhandler configuration
	 *
	 * @access protected
	 * @var Tx_Formhandler_Configuration
	 */
	protected $configuration;

	/**
	 * The template file to be used. Only if template file was defined via plugin record
	 *
	 * @access protected
	 * @var string
	 */
	protected $templateFile;

	/**
	 * The cObj
	 *
	 * @access protected
	 * @var tslib_cObj
	 */
	protected $cObj;
	
	/**
	 * Flag indicating if the form got submitted
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $submitted;
	
	/**
	 * Flag indicating if the form was already submitted in last step.
	 * If TRUE no loggers, saveInterceptors or finishers will be called except Finisher_Confirmation
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $submittedOK;
	
	/**
	 * The settings array
	 *
	 * @access protected
	 * @var array
	 */
	protected $settings;
	
	/**
	 * Flag indicating if debug mode is on
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $debugMode;
	
	/**
	 * The view object
	 *
	 * @access protected
	 * @var misc
	 */
	protected $view;
	
	/**
	 * The current step of the form
	 *
	 * @access protected
	 * @var integer
	 */
	protected $currentStep;
	
	/**
	 * The last step of the form
	 *
	 * @access protected
	 * @var integer
	 */
	protected $lastStep;
	
	/**
	 * Total steps of the form
	 *
	 * @access protected
	 * @var integer
	 */
	protected $totalSteps;
	
	/**
	 * Flag indicating if form is finished (no more steps)
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $finished;

	//not used
	protected $piVars;

	/**
	 * The constructor for a finisher setting the component manager and the configuration.
	 *
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 * @param Tx_GimmeFive_Component_Manager $componentManager
	 * @param Tx_Formhandler_Configuration $configuration
	 * @return void
	 */
	public function __construct(Tx_GimmeFive_Component_Manager $componentManager, Tx_Formhandler_Configuration $configuration) {
		$this->componentManager = $componentManager;
		$this->configuration = $configuration;
		$this->initializeController();
		$this->cObj = Tx_Formhandler_Globals::$cObj;
	}

	/**
	 * Main method of the form handler.
	 *
	 * @return rendered view
	 */
	public function process() {
		
		$this->init();
		
		
		
		//not submitted
		if(!$this->submitted) {
			$this->loadSettingsForStep($this->currentStep);
			$this->parseConditions();
			$this->view->setLangFiles($this->langFiles);
			$this->view->setSettings($this->settings);
			$this->setViewSubpart($this->currentStep);

			//run preProcessors
			$output = $this->runClasses($this->settings['preProcessors.']);
			if(strlen($output) > 0) {
				return $output;
			}
			
			//run init interceptors
			$this->addFormhandlerClass($this->settings['initInterceptors.'], 'Interceptor_Filtreatment');
			$output = $this->runClasses($this->settings['initInterceptors.']);
			if(strlen($output) > 0) {
				return $output;
			}
			
			//display form
			$content = $this->view->render($this->gp, $this->errors);
			return $content;

			//submitted
		} else {
			if($this->submittedOK) {
				
				$this->loadSettingsForStep($this->currentStep);
				$this->parseConditions();
				$this->view->setLangFiles($this->langFiles);
				$this->view->setSettings($this->settings);
				$this->setViewSubpart($this->currentStep);

				//run finishers
				if(isset($this->settings['finishers.']) && is_array($this->settings['finishers.']) && intval($this->settings['finishers.']['disable']) !== 1) {

					foreach($this->settings['finishers.'] as $tsConfig) {
						if(isset($tsConfig['class']) && intval($tsConfig['disable']) !== 1) {
							$className = Tx_Formhandler_StaticFuncs::prepareClassName($tsConfig['class']);
							$finisher = $this->componentManager->getComponent($className);
							if($finisher instanceof Tx_Formhandler_Finisher_Confirmation) {
								$className = Tx_Formhandler_StaticFuncs::prepareClassName($tsConfig['class']);
								Tx_Formhandler_StaticFuncs::debugBeginSection('calling_finisher', $className);
								$finisher = $this->componentManager->getComponent($className);
								$tsConfig['config.'] = $this->addDefaultComponentConfig($tsConfig['config.']);
								$finisher->init($this->gp, $tsConfig['config.']);
								Tx_Formhandler_StaticFuncs::debugEndSection();
								return $finisher->process();
							}
						}
					}
				}

			} else {
		
				/*
				 * Step may have been set to the next step already.
				 * Set the settings back to the one of the previous step 
				 * to run the right interceptors and validators.
				 */
				if($this->currentStep > $this->lastStep) {
					
					$this->loadSettingsForStep($this->lastStep);
					$this->parseConditions();
				} else {
					$this->loadSettingsForStep($this->currentStep);
					$this->parseConditions();
					
				}
				
				//run init interceptors
				$this->addFormhandlerClass($this->settings['initInterceptors.'], 'Interceptor_Filtreatment');
				$output = $this->runClasses($this->settings['initInterceptors.']);
				if(strlen($output) > 0) {
					return $output;
				}

				//run validation
				$this->errors = array();
				$valid = array(true);
				if(	isset($this->settings['validators.']) && 
					is_array($this->settings['validators.']) && 
					intval($this->settings['validators.']['disable']) !== 1) {
						
					foreach($this->settings['validators.'] as $tsConfig) {
						if($tsConfig['class'] && intval($tsConfig['disable']) !== 1) {
							$className = Tx_Formhandler_StaticFuncs::prepareClassName($tsConfig['class']);
							Tx_Formhandler_StaticFuncs::debugBeginSection('calling_validator',  $className);
							$validator = $this->componentManager->getComponent($className);
							if($this->currentStep == $this->lastStep) {
								$userSetting = t3lib_div::trimExplode(',', $tsConfig['config.']['restrictErrorChecks']);
								$autoSetting = array('fileAllowedTypes','fileRequired','fileMaxCount','fileMinCount','fileMaxSize','fileMinSize');
								$merged = array_merge($userSetting,$autoSetting);
								$tsConfig['config.']['restrictErrorChecks'] = implode(',', $merged);
							}
							$tsConfig['config.'] = $this->addDefaultComponentConfig($tsConfig['config.']);
							$validator->init($this->gp,$tsConfig['config.']);
							$res = $validator->validate($this->errors);
							array_push($valid,$res);
							Tx_Formhandler_StaticFuncs::debugEndSection();
						}
					}
				}

				//process files
				$this->processFiles();
				
				//now set the settings to the current step again
				if($this->currentStep > $this->lastStep) {
					$this->loadSettingsForStep($this->currentStep);
					$this->parseConditions();
					$this->view->setLangFiles($this->langFiles);
					$this->view->setSettings($this->settings);
					$this->setViewSubpart($this->currentStep);
				} else {
					$this->view->setLangFiles($this->langFiles);
					$this->view->setSettings($this->settings);
					$this->setViewSubpart($this->currentStep);
				}

				//if form is valid
				if($this->isValid($valid)) {
					
					//if no more steps
					if($this->finished) {
						
						Tx_Formhandler_StaticFuncs::debugBeginSection('form_finished');
						Tx_Formhandler_StaticFuncs::debugEndSection();
						
						if(!$this->submittedOK) {
							Tx_Formhandler_StaticFuncs::debugBeginSection('store_gp');
							$this->storeGPinSession();
							$this->mergeGPWithSession();
							Tx_Formhandler_StaticFuncs::debugEndSection();
						}
						
						//run save interceptors
						if(!$this->submittedOK) {
							$output = $this->runClasses($this->settings['saveInterceptors.']);
							if(strlen($output) > 0) {
								return $output;
							}
						}
						
						//run loggers
						$this->addFormhandlerClass($this->settings['loggers.'], 'Logger_DB');
						$output = $this->runClasses($this->settings['loggers.']);
						if(strlen($output) > 0) {
							return $output;
						}
							
						//run finishers
						if(isset($this->settings['finishers.']) && is_array($this->settings['finishers.']) && intval($this->settings['finishers.']['disable']) !== 1) {

							ksort($this->settings['finishers.']);

							//if storeGP is set include Finisher_storeGP, stores GET / POST in the session
							if(!$this->submittedOK && ($this->submittedOK == 1 || Tx_Formhandler_StaticFuncs::pi_getFFvalue($this->cObj->data['pi_flexform'], 'store_gp', 'sMISC'))){
								$this->addFinisherStoreGP();
							}

							foreach($this->settings['finishers.'] as $tsConfig) {
								if(isset($tsConfig['class']) && intval($tsConfig['disable']) !== 1) {
									$className = Tx_Formhandler_StaticFuncs::prepareClassName($tsConfig['class']);
									$finisher = $this->componentManager->getComponent($className);
									
									Tx_Formhandler_StaticFuncs::debugBeginSection('calling_finisher', $className);
									
									$tsConfig['config.'] = $this->addDefaultComponentConfig($tsConfig['config.']);
									
									//check if the form was finished before. This flag is set by the Finisher_Confirmation
									if(!$this->submittedOK) {
	
										$finisher->init($this->gp,$tsConfig['config.']);
	
										//if the finisher returns HTML (e.g. Tx_Formhandler_Finisher_Confirmation)
										if($tsConfig['config.']['returns']) {
											Tx_Formhandler_StaticFuncs::debugEndSection();
											return $finisher->process();
										} else {
												
											$this->gp = $finisher->process();
											Tx_Formhandler_StaticFuncs::debugEndSection();
										}
										
									
									//if the form was finished before, only show the output of the Tx_Formhandler_Finisher_Confirmation
									} elseif($finisher instanceof Tx_Formhandler_Finisher_Confirmation) {
									
										$finisher->init($this->gp, $tsConfig['config.']);
										Tx_Formhandler_StaticFuncs::debugEndSection();
										return $finisher->process();
									}
								}
							}
							$_SESSION['submitted_ok'] = 1;
						}
					} else {

						//if user clicked "submit"
						if($this->currentStep >= $this->lastStep) {
							Tx_Formhandler_StaticFuncs::debugBeginSection('store_gp');
							$this->storeGPinSession();
							$this->mergeGPWithSession(FALSE, $this->currentStep);
							Tx_Formhandler_StaticFuncs::debugEndSection();
						}
						
						

						//display form
						return $this->view->render($this->gp, $this->errors);

					}
				} else {

					//stay on current step
					if($this->lastStep < $_SESSION['formhandlerSettings']['currentStep']) {
						$_SESSION['formhandlerSettings']['currentStep'] = $this->lastStep;
						$this->currentStep = $this->lastStep;
					}
					
					

					//load settings from last step again because an error occurred
					$this->loadSettingsForStep($this->currentStep);
					$_SESSION['formhandlerSettings']['settings'] = $this->settings;

					//reset the template because step had probably been decreased
					$this->setViewSubpart($this->currentStep);
					
					//display form
					return $this->view->render($this->gp, $this->errors);
				}
			}
		}

	}
	
	protected function addDefaultComponentConfig($conf) {
		if(!$conf['templateFile']) {
			$conf['templateFile'] = $this->templateFile;
		}
		if(!$conf['langFiles']) {
			$conf['langFiles'] = $this->langFiles;
		}
		$conf['formValuesPrefix'] = $this->settings['formValuesPrefix'];
		$conf['templateSuffix'] = $this->settings['templateSuffix'];
		return $conf;
	}

	/**
	 * Adds the Finisher_StoreGP
	 *
	 * @return void
	 */
	protected function addFinisherStoreGP(){
		//add Finisher_StoreGP to the end of Finisher array
		$this->settings['finishers.'][] = array('class' => 'Tx_Formhandler_Finisher_StoreGP');

		//search for Finisher_Confirmation (finishers with config.returns), put them at the very end
		foreach($this->settings['finishers.'] as $key => $tsConfig) {

			$className = Tx_Formhandler_StaticFuncs::prepareClassName($tsConfig['class']);
			$finisher = $this->componentManager->getComponent($className);

			if($tsConfig['config.']['returns'] || ($finisher instanceof Tx_Formhandler_Finisher_Redirect)){

				//push it to the end
				$this->settings['finishers.'][] = $this->settings['finishers.'][$key];

				//unset on the previous position
				unset($this->settings['finishers.'][$key]);
			}
		}
	}
	
	/**
	 * Adds the Logger_DB
	 *
	 * @return void
	 */
	protected function addFormhandlerClass(&$classesArray, $className){
		
		if(!isset($classesArray) && !is_array($classesArray)) {

			//add class to the end of the array
			$classesArray[] = array('class' => $className);
			
		} else {
			
			foreach($classesArray as $classOptions) {
				$found = FALSE;
				if(strpos($className, $classOptions['class']) !== FALSE) {
					$found = TRUE;
				}
				
			}
			if(!$found) {
				//add class to the end of the array
				$classesArray[] = array('class' => $className);
			}
		}
	}

	/**
	 * Processes uploaded files, moves them to a temporary upload folder, renames them if they already exist and
	 * stores the information in $_SESSION['formhandlerFiles']
	 *
	 *
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function processFiles() {
		session_start();

		//if files were uploaded
		if(isset($_FILES) && is_array($_FILES) && !empty($_FILES)) {

			//get upload folder
			$uploadFolder = Tx_Formhandler_StaticFuncs::getTempUploadFolder();

			//build absolute path to upload folder
			$uploadPath = Tx_Formhandler_StaticFuncs::getTYPO3Root() . $uploadFolder;

			if(!file_exists($uploadPath)) {
				Tx_Formhandler_StaticFuncs::debugMessage('folder_doesnt_exist', $uploadPath);
				return;
			}

			//for all file properties
			/*
			* $_FILES looks like this:
			*
			* Array (
			*	[formhandler] => Array (
			*		[name] => Array (
			*      	[picture] =>
			*      	[picture2] => Wasserlilien.jpg
			*   	)
			*		[type] => Array (
			*      	[picture] =>
			*      	[picture2] => image/jpeg
			*   	)
			*		[tmp_name] => Array (
			*      	[picture] =>
			*      	[picture2] => /cluster/ispman/temp/phpbqqUEg
			*  	)
			*		[error] => Array (
			*      	[picture] => 4
			*      	[picture2] => 0
			*   	)
			*		[size] => Array (
			*      	[picture] => 0
			*      	[picture2] => 83794
			*   	)
			*	 )
			*)
			*/
			foreach($_FILES as $sthg => &$files) {

				//if a file was uploaded
				if(isset($files['name']) && is_array($files['name'])) {

					//for all file names
					foreach($files['name'] as $field => $name) {
						if(!isset($this->errors[$field])) {
							$exists = false;
							if(is_array($_SESSION['formhandlerFiles'][$field])) {
								foreach($_SESSION['formhandlerFiles'][$field] as $fileOptions) {

									if($fileOptions['name'] == $name) {
										$exists = true;
									}
								}
							}
							if(!$exists) {
								$filename = substr($name, 0, strpos($name, '.'));
								if(strlen($filename) > 0) {
									$ext = substr($name, strpos($name, '.'));
									$suffix = 1;

									$filename = str_replace(' ', '_', $filename);
									
									//build file name
									$uploadedFileName = $filename . $ext;

									//rename if exists
									while(file_exists($uploadPath . $uploadedFileName)) {
										$uploadedFileName = $filename . '_' . $suffix . $ext;
										$suffix++;

									}
									$files['name'][$field] = $uploadedFileName;

									//move from temp folder to temp upload folder
									move_uploaded_file($files['tmp_name'][$field], $uploadPath . $uploadedFileName);
									$files['uploaded_name'][$field] = $uploadedFileName;

									//set values for $_SESSION
									$tmp['name'] = $name;
									$tmp['uploaded_name'] = $uploadedFileName;
									$tmp['uploaded_path'] = $uploadPath;
									$tmp['uploaded_folder'] = $uploadFolder;
									$uploadedUrl = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $uploadFolder . $uploadedFileName;
									$uploadedUrl = str_replace('//', '/', $uploadedUrl);
									$tmp['uploaded_url'] = $uploadedUrl;
									$tmp['size'] = $files['size'][$field];
									$tmp['type'] = $files['type'][$field];
									if(!is_array($_SESSION['formhandlerFiles'][$field]) && strlen($field)) {
										$_SESSION['formhandlerFiles'][$field] = array();
									}
									array_push($_SESSION['formhandlerFiles'][$field], $tmp);
									if(!is_array($this->gp[$field])) {
										$this->gp[$field] = array();
									}
									array_push($this->gp[$field], $uploadedFileName);
								}
							}
						}
					}
				}
			}
		}
		
		Tx_Formhandler_StaticFuncs::debugBeginSection('current_files');
		Tx_Formhandler_StaticFuncs::debugArray($_SESSION['formhandlerFiles']);
		Tx_Formhandler_StaticFuncs::debugEndSection();
	}


	/**
	 * Stores the current GET/POST parameters in SESSION
	 *
	 * @param array &$settings Reference to the settings array to get information about checkboxes and radiobuttons.
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function storeGPinSession() {
		session_start();

		//merge GET/POST again to get a third version of submitted values.
		//the values in $this->gp are not reliable because they got merged with $_SESSION in initPreProcessor
		$newGP = array_merge(t3lib_div::_GET(), t3lib_div::_POST());
		if($_SESSION['formhandlerSettings']['settings']['formValuesPrefix']) {
			$newGP = $newGP[$_SESSION['formhandlerSettings']['settings']['formValuesPrefix']];
		}

		//set the variables in session
		if($this->lastStep !== $this->currentStep) {
			foreach($newGP as $key => $value) {
				if(!strstr($key, 'step-') && !strstr($key, 'submitted')) {
					$_SESSION['formhandlerValues'][$this->lastStep][$key] = $value;
				}
			}
		}

		//check for checkbox and radiobutton fields using the values in $newGP
		if($this->settings['checkBoxFields']) {
			$fields = t3lib_div::trimExplode(',', $this->settings['checkBoxFields']);
			foreach($fields as $field) {
				if(!isset($newGP[$field]) && isset($this->gp[$field])) {
					$_SESSION['formhandlerValues'][($this->lastStep)][$field] = array();
				}
			}
		}
		if($this->settings['radioButtonFields']) {
			$fields = t3lib_div::trimExplode(',', $this->settings['radioButtonFields']);
			foreach($fields as $field) {
				if(!isset($newGP[$field]) && isset($this->gp[$field])) {
					$_SESSION['formhandlerValues'][($this->lastStep)][$field] = array();
				}
			}
		}
	}

	protected function reset() {
		session_start();
		unset($_SESSION['formhandlerValues']);
		unset($_SESSION['formhandlerFiles']);
		unset($_SESSION['formhandlerSettings']['lastStep']);
		unset($_SESSION['submitted_ok']);
		unset($_SESSION['formhandlerSettings']['usedSuffix']);
		unset($_SESSION['formhandlerSettings']['usedSettings']);
		unset($_SESSION['startblock']);
		unset($_SESSION['endblock']);
		$this->gp = array();
		Tx_Formhandler_StaticFuncs::debugMessage('cleared_session');
	}

	/**
	 * Searches for current step and sets $this->currentStep according
	 *
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function findCurrentStep() {
		if(isset($this->gp) && is_array($this->gp)) {
			$highest = 0;
			foreach (array_keys($this->gp) as $pname) {

				if (strstr($pname,'step-')) {
					
					preg_match_all('/step-([0-9]+)/', $pname, $matches);
					
					if(isset($matches[1][0])) {
						$mpPage = $matches[1][0];
					}

					if(intVal($mpPage) > $highest) {
						$highest = intVal($mpPage);
					}
				} // if end
			} // foreach end
			$this->currentStep = $highest;
		}
		if(!$this->currentStep) {
			$this->currentStep = 1;
		}
		
		Tx_Formhandler_StaticFuncs::debugMessage('current_step', $this->currentStep);
	}

	public function validateConfig() {

		$options = array(
		array('to_email', 'sEMAILADMIN', 'finishers', 'Tx_Formhandler_Finisher_Mail'),
		array('to_email', 'sEMAILUSER', 'finishers', 'Tx_Formhandler_Finisher_Mail'),
		array('redirect_page', 'sMISC', 'finishers', 'Tx_Formhandler_Finisher_Redirect'),
		array('required_fields', 'sMISC', 'validators', 'Tx_Formhandler_Validator_Default'),
		);

		foreach ($options as $option) {
			$fieldName = $option[0];
			$flexformSection = $option[1];
			$component = $option[2];
			$componentName = $option[3];

			$value = Tx_Formhandler_StaticFuncs::pi_getFFvalue($this->cObj->data['pi_flexform'], $fieldName, $flexformSection);

			// Check if a Mail Finisher can be found in the config
			$isConfigOk = FALSE;
			if (is_array($this->settings[$component . '.'])) {
				foreach ($this->settings[$component . '.'] as $finisher) {
					if ($finisher['class'] == $componentName) {
						$isConfigOk = TRUE;
						break;
					} elseif ($finisher['class'] == (str_replace('Tx_Formhandler_', '', $componentName))) {
						$isConfigOk = TRUE;
						break;
					}
				}
			}

			// Throws an Exception if a problem occurs
			if ($value != '' && !$isConfigOk) {
				Tx_Formhandler_StaticFuncs::throwException('missing_component', $component, $value, $componentName);
			}
		}
	}
	
	protected function parseConditions() {
		//$this->mergeGPWithSession(FALSE, FALSE);
		//print_r($this->settings['validators.']);
		if(is_array($this->settings['if.'])) {
			$finalResult = FALSE;
			foreach($this->settings['if.'] as $conditionSettings) {
				$conditions = $conditionSettings['conditions.'];
				$condition = '';
				$orConditions = array();
				foreach($conditions as $andConditions) {
					$results = array();
					foreach($andConditions as $andCondition) {
						if(strstr($andCondition, '=')) {
							list($field,$value) = t3lib_div::trimExplode('=', $andCondition);
							$result = $this->gp[$field] == $value;
						} elseif(strstr($andCondition, '>')) {
							list($field,$value) = t3lib_div::trimExplode('>', $andCondition);
							$result = $this->gp[$field] > $value;
						} elseif(strstr($andCondition, '<')) {
							list($field,$value) = t3lib_div::trimExplode('<', $andCondition);
							$result = $this->gp[$field] < $value;
						}
						$results[] = ($result?'TRUE':'FALSE');
					}
					$orConditions[] = '(' . implode(' && ', $results) . ')';
				}
				$finalCondition = '(' . implode(' || ', $orConditions) . ')';
				
				eval('$evaluation = ' . $finalCondition . ';');
				
				if($evaluation) {
					$newSettings = $conditionSettings['isTrue.'];
					if(is_array($newSettings)) {
						
						$this->settings = t3lib_div::array_merge_recursive_overrule($this->settings, $newSettings);
					}
				} else {
					$newSettings = $conditionSettings['else.'];
					if(is_array($newSettings)) {
						
						$this->settings = t3lib_div::array_merge_recursive_overrule($this->settings, $newSettings);
					}
				}
				
			}
			
		}
		
		
	}

	protected function init() {
		session_start();
		
		$this->settings = $this->getSettings();
		
		Tx_Formhandler_Globals::$formValuesPrefix = $this->settings['formValuesPrefix'];
		if($this->settings['formValuesPrefix']) {
			$this->formValuesPrefix = $this->settings['formValuesPrefix'];
		}

		//set debug mode
		$this->debugMode = ($this->settings['debug'] == '1') ? TRUE : FALSE;
		$_SESSION['formhandlerSettings']['debugMode'] = $this->debugMode;
		Tx_Formhandler_StaticFuncs::debugBeginSection('init_values');
		$this->loadGP();
		if($this->currentStep >= $this->lastStep) {
			$this->mergeGPWithSession(FALSE, $this->currentStep);
		}
		//read template file
		$this->templateFile = Tx_Formhandler_StaticFuncs::readTemplateFile($this->templateFile, $this->settings);
		
		$this->getStepInformation();
		//$this->loadSettingsForStep($this->currentStep);
		$this->parseConditions();
		//$this->getStepInformation();
		//$this->loadSettingsForStep($this->currentStep);
		//read template file
		$this->templateFile = Tx_Formhandler_StaticFuncs::readTemplateFile($this->templateFile, $this->settings);
		Tx_Formhandler_Globals::$templateCode = $this->templateFile;
		$this->langFiles = Tx_Formhandler_StaticFuncs::readLanguageFiles($this->langFiles, $this->settings);
		Tx_Formhandler_Globals::$langFiles = $this->langFiles;
		
		
		//print_r($this->settings);
		
		$this->validateConfig();
		Tx_Formhandler_Globals::$settings = $this->settings;

		//set debug mode again cause it may have changed in specific step settings
		$this->debugMode = ($this->settings['debug'] == '1') ? TRUE : FALSE;
		$_SESSION['formhandlerSettings']['debugMode'] = $this->debugMode;
		
		Tx_Formhandler_StaticFuncs::debugMessage('using_prefix', $this->formValuesPrefix);
		
		//init view
		$viewClass = $this->settings['view'];
		if(!$viewClass) {
			$viewClass = 'Tx_Formhandler_View_Form';
		}

		Tx_Formhandler_StaticFuncs::debugMessage('using_view', $viewClass);
		
		Tx_Formhandler_StaticFuncs::debugEndSection();
		Tx_Formhandler_StaticFuncs::debugBeginSection('current_gp');
		Tx_Formhandler_StaticFuncs::debugArray($this->gp);
		Tx_Formhandler_StaticFuncs::debugEndSection();
		$this->storeSettingsInSession();
		
		//if($this->currentStep <= $this->lastStep) {
			$this->mergeGPWithSession(FALSE, $this->currentStep);
		//}
		
		$this->submittedOK = $_SESSION['submitted_ok'];
		
		if(!$this->submittedOK) {
			$this->submittedOK = t3lib_div::_GP('submitted_ok');
		}
		
		//set submitted
		$this->submitted = $this->isFormSubmitted();
		
		
		//not submitted
		$dontReset = t3lib_div::_GP('dontReset');
		if(!$this->submitted && intval($dontReset) !== 1) {
			$this->reset();
		}

		// set stylesheet file
		$this->setStyleSheet();
		
		Tx_Formhandler_StaticFuncs::debugBeginSection('current_session_params');
		Tx_Formhandler_StaticFuncs::debugArray($_SESSION['formhandlerValues']);
		Tx_Formhandler_StaticFuncs::debugEndSection();

		
		$viewClass = Tx_Formhandler_StaticFuncs::prepareClassName($viewClass);
		$this->view = $this->componentManager->getComponent($viewClass);
		$this->view->setLangFiles($this->langFiles);
		$this->view->setSettings($this->settings);
		$this->setViewSubpart($this->currentStep);
	}

	protected function loadGP() {
		$this->gp = array_merge(t3lib_div::_GET(), t3lib_div::_POST());

		if($this->formValuesPrefix) {
			$this->gp = $this->gp[$this->formValuesPrefix];
		}
	}
	
	protected function isFormSubmitted() {
		$submitted = $this->gp['submitted'];
		if($submitted && !$this->submittedOK) {
			$found = FALSE;
			foreach($this->gp as $key=>$value) {
				if(substr($key, 0, 5) === 'step-') {
					$found = TRUE;
				}
			}
			if(!$found) {
				$submitted = FALSE;
			}
		}
		
		return $submitted;
	}


	/**
	 * Sets the template of the view.
	 *
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function setViewSubpart($step) {
		$this->finished = 0;

		//search for ###TEMPLATE_FORM[step][suffix]###
		if(strstr($this->templateFile, ('###TEMPLATE_FORM' . $step . $this->settings['templateSuffix'] . '###'))) {
			Tx_Formhandler_StaticFuncs::debugMessage('using_subpart', ('###TEMPLATE_FORM' . $step . $this->settings['templateSuffix'] . '###'));
			$this->view->setTemplate($this->templateFile, ('FORM' . $step . $this->settings['templateSuffix']));

		//search for ###TEMPLATE_FORM[step]###
		} elseif(strstr($this->templateFile, ('###TEMPLATE_FORM' . $step . '###'))) {
			Tx_Formhandler_StaticFuncs::debugMessage('using_subpart', ('###TEMPLATE_FORM' . $step . '###'));
			$this->view->setTemplate($this->templateFile, ('FORM' . $step));

		//search for ###TEMPLATE_FORM###
		} elseif(strstr($this->templateFile, '###TEMPLATE_FORM###')) {
			Tx_Formhandler_StaticFuncs::debugMessage('using_subpart', '###TEMPLATE_FORM###');
			$this->view->setTemplate($this->templateFile, 'FORM');

		//mark form as finished
		} else {
			$this->finished = 1;
		}
	}

	protected function storeSettingsInSession() {
		$_SESSION['formhandlerSettings']['formValuesPrefix'] = $this->formValuesPrefix;
		$_SESSION['formhandlerSettings']['settings'] = $this->settings;
		$_SESSION['formhandlerSettings']['currentStep'] = $this->currentStep;
		$_SESSION['formhandlerSettings']['totalSteps'] = $this->totalSteps;
		$_SESSION['formhandlerSettings']['lastStep'] = $this->lastStep;
		$_SESSION['formhandlerSettings']['debugMode'] = $this->debugMode;
		$_SESSION['formhandlerSettings']['templateSuffix'] = $this->settings['templateSuffix'];
	}

	protected function loadSettingsForStep($step) {

		//read global settings
		//$this->settings = $this->getSettings();

		//merge settings with specific settings for current step
		if(isset($this->settings[$step . '.']) && is_array($this->settings[$step . '.'])) {
			$this->settings = array_merge($this->settings, $this->settings[$step . '.']);
		}
		
		session_start();
		$_SESSION['formhandlerSettings']['settings'] = $this->settings;
	}

	protected function getStepInformation() {

		//find current step
		$this->findCurrentStep();

		//set last step
		$this->lastStep = $_SESSION['formhandlerSettings']['currentStep'];
		if(!$this->lastStep) {
			$this->lastStep = 1;
		}

		//total steps
		preg_match_all('/(###TEMPLATE_FORM)([0-9]+)(_.*)?(###)/', $this->templateFile, $subparts);
		
		//get step numbers
		$subparts = array_unique($subparts[2]);
		sort($subparts);
		$countSubparts = count($subparts);
		
		$this->totalSteps = $subparts[$countSubparts - 1];

		if ($this->totalSteps > $countSubparts) {
			Tx_Formhandler_StaticFuncs::debugMessage('subparts_missing', implode(', ', $subparts));
		} else {
			Tx_Formhandler_StaticFuncs::debugMessage('total_steps', $this->totalSteps);
		}
	}

	/**
	 * Merges the current GET/POST parameters with the stored ones in SESSION
	 *
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function mergeGPWithSession($overruleGP = TRUE, $maxStep = 0) {
		session_start();
		if(!is_array($this->gp)) {
			$this->gp = array();
		}
		if(!is_array($_SESSION['formhandlerValues'])) {
			$_SESSION['formhandlerValues'] = array();
		}

		foreach($_SESSION['formhandlerValues'] as $step => &$params) {
			if(is_array($params) && (!$maxStep || $step <= $maxStep)) {
				unset($params['submitted']);
				foreach($params as $key => $value) {
					if($overruleGP || !isset($this->gp[$key])) {
						$this->gp[$key] = $value;
					}
				}
			}
		}
	}
	

	/**
	 * Runs the class by calling process() method.
	 *
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 * @param array $classesArray: the configuration array
	 * @return void
	 */
	protected function runClasses($classesArray) {
		$output = '';
		if(isset($classesArray) && is_array($classesArray) && intval($classesArray['disable']) !== 1) {
			foreach($classesArray as $tsConfig) {
				if(isset($tsConfig['class']) && intval($tsConfig['disable']) !== 1) {
					$className = Tx_Formhandler_StaticFuncs::prepareClassName($tsConfig['class']);
					Tx_Formhandler_StaticFuncs::debugBeginSection('calling_class', $className);
	
					$obj = $this->componentManager->getComponent($className);
					$tsConfig['config.'] = $this->addDefaultComponentConfig($tsConfig['config.']);
					$obj->init($this->gp, $tsConfig['config.']);
					$return = $obj->process();
					Tx_Formhandler_StaticFuncs::debugEndSection();
					if(is_array($return)) {
						
						//return value is an array. Treat it as the probably modified get/post parameters
						$this->gp = $return;
					} else {
						
						//return value is no array. treat this return value as output.
						return $return;
					}
				}
			}
		}
		
	}

	/**
	 * Read stylesheet file set in TypoScript. If set add to header data
	 *
	 * @param $settings The formhandler settings
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function setStyleSheet() {
		$stylesheetFile = $this->settings['stylesheetFile'];
		if (strlen($stylesheetFile) > 0) {

			// set stylesheet
			$GLOBALS['TSFE']->additionalHeaderData[$this->configuration->getPackageKeyLowercase()] .=
				'<link rel="stylesheet" href="' . Tx_Formhandler_StaticFuncs::resolveRelPathFromSiteRoot($stylesheetFile) . '" type="text/css" media="screen" />';
		}
	}

	/**
	 * Find out if submitted form was valid. If one of the values in the given array $valid is false the submission was not valid.
	 *
	 * @param $validArr Array with the return values of each validator
	 * @return boolean
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function isValid($validArr) {
		
		$valid = TRUE;
		if(is_array($validArr)) {
			foreach($validArr as $item) {
				if(!$item) {
					$valid = false;
				}
			}
		}
		return $valid;
	}

	/**
	 * Possibly unnecessary
	 *
	 * @return void
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 */
	protected function initializeController($value = '') {
		//$this->piVars = t3lib_div::GParrayMerged($this->configuration->getPrefixedPackageKey());
	}

}
?>