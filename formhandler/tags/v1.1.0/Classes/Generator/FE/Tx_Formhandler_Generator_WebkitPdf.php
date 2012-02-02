<?php

class Tx_Formhandler_Generator_WebkitPdf extends Tx_Formhandler_AbstractGenerator {
	
	/**
	 * Renders the PDF.
	 *
	 * @return void
	 */
	public function process() {
		if (t3lib_extMgm::isLoaded('webkitpdf')) {
			$linkGP = array();
			if (strlen($this->globals->getFormValuesPrefix()) > 0) {
				$linkGP[$this->globals->getFormValuesPrefix()] = $this->gp;
			} else {
				$linkGP = $this->gp;
			}

			$url = $this->utilityFuncs->getHostname() . $this->cObj->getTypolink_URL($GLOBALS['TSFE']->id, $linkGP);
			if($this->url) {
				$url = $this->url;
			}
			$config = $this->readWebkitPdfConf();
			$config['fileOnly'] = 1;
			$config['urls']['1'] = $url;

			if (!class_exists('tx_webkitpdf_pi1')) {
				require_once(t3lib_extMgm::extPath('webkitpdf') . 'pi1/class.tx_webkitpdf_pi1.php');
			}
			$generator = t3lib_div::makeInstance('tx_webkitpdf_pi1');
			$generator->cObj = $this->globals->getCObj();

			return $generator->main('', $config);
		}
	}
	
	protected function readWebkitPdfConf() {
		$sysPageObj = t3lib_div::makeInstance('t3lib_pageSelect');

		if (!$GLOBALS['TSFE']->sys_page) {
			$GLOBALS['TSFE']->sys_page = $sysPageObj;
		}

		$rootLine = $sysPageObj->getRootLine($GLOBALS['TSFE']->id);
		$TSObj = t3lib_div::makeInstance('t3lib_tsparser_ext');
		$TSObj->tt_track = 0;
		$TSObj->init();
		$TSObj->runThroughTemplates($rootLine);
		$TSObj->generateConfig();

		$conf = array();
		if (isset($TSObj->setup['plugin.']['tx_webkitpdf_pi1.'])) {
			$conf = $TSObj->setup['plugin.']['tx_webkitpdf_pi1.'];
		}
		return $conf;
	}

	public function getLink($linkGP) {
		$params = $this->getDefaultLinkParams();
		$componentParams = $this->getComponentLinkParams($linkGP);
		if (is_array($componentParams)) {
			$params = t3lib_div::array_merge_recursive_overrule($params, $componentParams);
		}
		$text = $this->getLinkText();
		$this->url = $this->utilityFuncs->getHostname() . $this->cObj->getTypolink_URL($GLOBALS['TSFE']->id, $params);
		$params = array(
			'tx_webkitpdf_pi1' => array(
				'urls' => array(
					$this->url
				)
			),
			'no_cache' => 1
		);
		return $this->cObj->getTypolink($text, $this->settings['pid'], $params);
	}

	protected function getComponentLinkParams($linkGP) {
		$prefix = $this->globals->getFormValuesPrefix();
		$tempParams = array(
			'action' => 'show'
		);
		$params = array();
		if ($prefix) {
			$params[$prefix] = $tempParams;
		} else {
			$params = $tempParams;
		}
		return $params;
	}

	protected function getLinkText() {
		$config = $this->readWebkitPdfConf();
		$text = $this->utilityFuncs->getSingle($config, 'linkText');
		if (strlen($text) === 0) {
			$text = 'Save as PDF';
		}
		return $text;
	}
}

?>