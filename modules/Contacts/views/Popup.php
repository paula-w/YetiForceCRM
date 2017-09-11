<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * ********************************************************************************** */

class Contacts_Popup_View extends Vtiger_Popup_View
{
	/*
	 * Function to initialize the required data in smarty to display the List View Contents
	 * @param \App\Request $request
	 * @param Vtiger_Viewer $viewer
	 */

	public function initializeListViewContents(\App\Request $request, Vtiger_Viewer $viewer)
	{
		$moduleName = $this->getModule($request);
		$sourceModule = $request->getByType('src_module', 1);
		$sourceRecord = $request->get('src_record');
		$relParentModule = 'Accounts';
		//list of records is narrowed to contacts related to help desks account, only in Help Desk Contacts relation view
		if ($sourceRecord && $moduleName === 'Contacts' && $sourceModule === 'HelpDesk' && \App\Record::isExists($sourceRecord) && strpos($_SERVER['QUERY_STRING'], 'module=Contacts&src_module=HelpDesk') === 0) {
			$helpDeskRecord = Vtiger_Record_Model::getInstanceById($sourceRecord, 'HelpDesk');
			$relId = $helpDeskRecord->get('parent_id');
			if (\App\Record::getType($relId) === $relParentModule) {
				$request->set('related_parent_module', $relParentModule);
				$request->set('related_parent_id', $relId);
				$request->set('showSwitch', 1);
			}
		}
		if ($sourceRecord && $moduleName === 'Contacts' && $sourceModule === 'SSalesProcesses' && \App\Record::isExists($sourceRecord) && strpos($_SERVER['QUERY_STRING'], 'module=Contacts&src_module=SSalesProcesses') === 0) {
			$moduleRecord = Vtiger_Record_Model::getInstanceById($sourceRecord, 'SSalesProcesses');
			$relId = $moduleRecord->get('related_to');
			if (\App\Record::getType($relId) === $relParentModule) {
				$request->set('related_parent_module', $relParentModule);
				$request->set('related_parent_id', $relId);
				$request->set('showSwitch', 1);
			}
		}
		if ($sourceRecord && $moduleName === 'Contacts' && $sourceModule === 'Project' && \App\Record::isExists($sourceRecord) && strpos($_SERVER['QUERY_STRING'], 'module=Contacts&src_module=Project') === 0) {
			$moduleRecord = Vtiger_Record_Model::getInstanceById($sourceRecord, 'Project');
			$relId = $moduleRecord->get('linktoaccountscontacts');
			if (\App\Record::getType($relId) === $relParentModule) {
				$request->set('related_parent_module', $relParentModule);
				$request->set('related_parent_id', $relId);
				$request->set('showSwitch', 1);
			}
		}
		parent::initializeListViewContents($request, $viewer);
	}
}
