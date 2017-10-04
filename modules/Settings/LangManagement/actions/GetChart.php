<?php

/**
 * GetChart Action Class for LangManagement Settings
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_LangManagement_GetChart_Action extends Settings_Vtiger_Basic_Action
{

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$qualifiedModuleName = $request->getModule(false);
		$langBase = $request->getByType('langBase', 1);
		$modules = [];
		$data = [];
		if (!$request->isEmpty('langs') && ($langs = $request->getByType('langs', 1)) !== $langBase) {

			$moduleModel = Settings_LangManagement_Module_Model::getInstance($qualifiedModuleName);
			$modules = $moduleModel->getModFromLang($langBase);
			$data = $moduleModel->getStatsData($langBase, $langs);
		}
		$response = new Vtiger_Response();
		$response->setResult([
			'success' => true,
			'data' => $data,
			'modules' => $modules
		]);
		$response->emit();
	}
}
