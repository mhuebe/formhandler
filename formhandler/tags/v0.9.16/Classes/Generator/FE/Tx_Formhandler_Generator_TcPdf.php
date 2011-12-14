<?php

class Tx_Formhandler_Generator_TcPdf extends Tx_Formhandler_AbstractGenerator {

	/**
	 * Renders the CSV.
	 *
	 * @return void
	 */
	public function process() {

		$this->pdf = $this->componentManager->getComponent('Tx_Formhandler_Template_TCPDF');

		$this->pdf->setHeaderText($this->utilityFuncs->getSingle($this->settings, 'headerText'));
		$this->pdf->setFooterText($this->utilityFuncs->getSingle($this->settings, 'footerText'));

		$this->pdf->AddPage();
		$this->pdf->SetFont('Helvetica', '', 12);
		$view = $this->componentManager->getComponent('Tx_Formhandler_View_PDF');
		$this->filename = FALSE;
		if (intval($this->settings['storeInTempFile']) === 1) {
			$this->outputPath = $this->utilityFuncs->getDocumentRoot();
			if ($this->settings['customTempOutputPath']) {
				$this->outputPath .= $this->utilityFuncs->sanitizePath($this->settings['customTempOutputPath']);
			} else {
				$this->outputPath .= '/typo3temp/';
			}
			$this->filename = $this->outputPath . $this->settings['filePrefix'] . $this->utilityFuncs->generateHash() . '.pdf';

			$this->filenameOnly = $this->utilityFuncs->getSingle($this->settings, 'staticFileName');
			if(strlen($this->filenameOnly) === 0) {
				$this->filenameOnly = basename($this->filename);
			}
		}

		$this->formhandlerSettings = $this->globals->getSettings();
		$suffix = $this->formhandlerSettings['templateSuffix'];
		$this->templateCode = $this->utilityFuncs->readTemplateFile(FALSE, $this->formhandlerSettings);
		if ($suffix) {
			$view->setTemplate($this->templateCode, 'PDF' . $suffix);
		}
		if (!$view->hasTemplate()) {
			$view->setTemplate($this->templateCode, 'PDF');
		}
		if (!$view->hasTemplate()) {
			$this->utilityFuncs->throwException('no_pdf_template');
		}

		$view->setComponentSettings($this->settings);
		$content = $view->render($this->gp, array());

		$this->pdf->writeHTML($content);
		$returns = $this->settings['returnFileName'];

		if ($this->filename !== FALSE) {
			$this->pdf->Output($this->filename, 'F');

			$downloadpath = $this->filename;
			if ($returns) {
				return $downloadpath;
			}
			$downloadpath = str_replace($this->utilityFuncs->getDocumentRoot(), '', $downloadpath);
			header('Location: ' . $downloadpath);
			exit;
		} else {
			$this->pdf->Output('formhandler.pdf','D');
			exit;
		}
	}

	protected function getComponentLinkParams($linkGP) {
		$prefix = $this->globals->getFormValuesPrefix();
		$tempParams = array(
			'action' => 'pdf'
		);
		$params = array();
		if ($prefix) {
			$params[$prefix] = $tempParams;
		} else {
			$params = $tempParams;
		}
		return $params;
	}
}

?>