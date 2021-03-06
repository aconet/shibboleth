<?php
namespace TrustCnct\Shibboleth\Controller;

/***
 *
 * This file is part of the "TrustCnct.Shibboleth" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * LoginLinkController
 */
class LoginLinkController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \TrustCnct\Shibboleth\Service\LoginUrlService
     * @inject
     */
    protected $loginUrlService;

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $this->view->assign('loginLinkUrl', $this->loginUrlService->createUrl());
    }
}
