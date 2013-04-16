<?php
/**
 * @author		Pedro Augusto Mendes e Silva
 * @copyright	Copyright (C) 2013 Web Feroz.
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

//echo "<pre>"; print_r($_POST); echo "</pre>";

//$form = modWFContactHelper::createForm($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_wf_contact', $params->get('layout', 'default'));

if(!empty($_POST)) {
	//modWFContactHelper::sendEmail();
	//modWFContactHelper::insertDB();
}