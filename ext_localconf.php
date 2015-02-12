<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = '1';
$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['BE_fetchUserIfNoSession'] = '1'; 


// Configuration of authentication service.
$EXT_CONFIG = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['shibboleth']);

// see comment in ext_conf_template.txt
if ($EXT_CONFIG['enableAlwaysFetchUser']) {
	$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = '1'; // default
	$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['BE_alwaysFetchUser'] = '1'; // default
}

if ($EXT_CONFIG['FE_enable']) {
	$subtypesArray[] = 'getUserFE';
	$subtypesArray[] = 'authUserFE';
}

if ($EXT_CONFIG['BE_enable']) {
	$subtypesArray[] = 'getUserBE';
	$subtypesArray[] = 'authUserBE';
}

if (is_array($subtypesArray)) {
	$subtypesArray = array_unique($subtypesArray);
	$subtypes = implode(',',$subtypesArray);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService($_EXTKEY,  'auth' /* sv type */,  'tx_shibboleth_sv1' /* sv key */,
		array(

			'title' => 'Shibboleth Authentication',
			'description' => '',

			'subtype' => $subtypes,

			'available' => TRUE,
			'priority' => 80,       // tx_svauth_sv1 has 50, t3sec_saltedpw has 70, rsaauth has 60. This service must have higher priority!
			'quality' => 80,

			'os' => '',
			'exec' => '',

			'className' => 'TrustCnct\\Shibboleth\\tx_shibboleth_sv1',
		)
	);

// Hook for the link in the backendform
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['shibboleth']['originalLoginScriptHook'] = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/index.php']['loginScriptHook']['sv'];
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/index.php']['loginScriptHook']['sv'] = 'EXT:' . $_EXTKEY . '/hooks/class.tx_shibboleth_beform.php:tx_shibboleth_beform->addShibbolethJavaScript';

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['writeDevLog'] = FALSE;
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['writeDevLogFE'] = FALSE;
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['writeDevLogBE'] = FALSE;
$TYPO3_CONF_VARS['SC_OPTIONS']['shibboleth/lib/class.tx_shibboleth_userhandler.php']['writeMoreDevLog'] = FALSE;

if ($EXT_CONFIG['FE_devLog']) {
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['writeDevLogFE'] = TRUE;
}

if ($EXT_CONFIG['BE_devLog']) {
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['writeDevLogBE'] = TRUE;
}

if ($EXT_CONFIG['database_devLog']) {
	$TYPO3_CONF_VARS['SC_OPTIONS']['shibboleth/lib/class.tx_shibboleth_userhandler.php']['writeMoreDevLog'] = TRUE;
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY, 'pi1/class.tx_shibboleth_pi1.php', '_pi1', 'list_type', 0);
?>