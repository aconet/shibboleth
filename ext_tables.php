<?php

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

/**
 * Dies soll das TCA erweitern für die Anzeige der Datensätze im BE
 *
$tempColumns = array (
	'tx_shibboleth_shibbolethsessionid' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:shibboleth/locallang_db.xml:fe_users.tx_shibboleth_shibbolethsessionid',
		'config' => array (
			'type' => 'none',
		)
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users','tx_shibboleth_shibbolethsessionid;;;;1-1-1');

$tempColumns = array (
	'tx_shibboleth_shibbolethsessionid' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:shibboleth/locallang_db.xml:be_users.tx_shibboleth_shibbolethsessionid',
		'config' => array (
			'type' => 'none',
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('be_users',$tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('be_users','tx_shibboleth_shibbolethsessionid;;;;1-1-1');
*/



call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'TrustCnct.Shibboleth',
            'LoginLink',
            'Shibboleth Login Link'
        );

        // Try moving this to Configuration/TCA/overrides/sys_template.php
//        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('shibboleth', 'Configuration/TypoScript', 'Shibboleth');

    }
);
