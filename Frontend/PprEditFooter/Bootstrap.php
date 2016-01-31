<?php
/**
 * @category   Shopware
 * @package    Shopware_Plugins_Frontend_PprEditFooter
 * @version    $Id$
 * @author     Patrick Prädikow
 */

class Shopware_Plugins_Frontend_PprEditFooter_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

 
    public function getCapabilities()
    {
        return array(
            'install' => true,
            'enable' => true,
            'update' => true
        );
    }
 
    public function getLabel()
    {
        return 'Shop-Footer aus dem Backend bearbeiten';
    }

    public function getVersion()
    {
        return "1.0.0";
    }
 
    public function getInfo() {
        return array(
			'author' => 'Patrick Prädikow',
            'version' => $this->getVersion(),
            'copyright' => 'Copyright (c) 2015, Patrick Prädikow',
            'label' => $this->getLabel(),
            'description' => file_get_contents($this->Path() . 'info.txt'),
            'support' => 'http://forum.shopware.de',
            'link' => 'http://shopware.pradikow.de',
			'source' => 'Community',
            'changes' => array(
                '1.0.0'=>array('releasedate'=>'2015-11-02', 'lines' => array(
                    'Erstes Release'
                ))
            ),
            //'revision' => '2'
        );
    }

    public function update($version)
    {
        return true;
    }
	public function createForm()
	{
		$form = $this->Form();
		
		for($i = 1; $i < 5; $i++) {

			$form->setElement('boolean', "pprContentShow$i", 
				array(
					'label' => "Spalte $i überschreiben", 
					'value' => NULL,
					'scope' => Shopware\Models\Config\Element::SCOPE_SHOP
				)
			);
			$form->setElement('html', "pprContentColumn$i", 
				array(
					'label' => "Spalte $i", 
					'value' => NULL,
					'scope' => Shopware\Models\Config\Element::SCOPE_SHOP
				)
			);
		}
	}
 
    public function install()
    {
        $this->subscribeEvents();
		$this->createForm();	

		$cacheManager = Shopware()->Container()->get('shopware.cache_manager');
		$cacheManager->clearHttpCache();
		$cacheManager->clearTemplateCache();
		
        return true;
    }
 
    public function uninstall()
    {
		$cacheManager = Shopware()->Container()->get('shopware.cache_manager');
		$cacheManager->clearHttpCache();
		$cacheManager->clearTemplateCache();
		$this->secureUninstall();
        return true;
    }
	
    public function secureUninstall()
    {
        return true;
    }
	
	/**
	 * Registers all necessary events and hooks.
	 */
	private function subscribeEvents()
	{
		// Subscribe the needed event for less merge and compression
 
		$this->subscribeEvent(
					'Enlight_Controller_Action_PostDispatch',
					'onPostDispatchFrontend'
		);
 
	}

	public function onPostDispatchFrontend(Enlight_Event_EventArgs $arguments)
	{
 
        /**@var $controller Shopware_Controllers_Frontend_Index*/
        $controller = $arguments->getSubject();
 
        /**
         * @var $request Zend_Controller_Request_Http
         */
        $request = $controller->Request();
 
        /**
         * @var $response Zend_Controller_Response_Http
         */
        $response = $controller->Response();
 
        /**
         * @var $view Enlight_View_Default
         */
        $view = $controller->View();
 
        //Check if there is a template and if an exception has occured
		if(!$request->isDispatched()
					|| $response->isException() 
					|| $request->getModuleName() != 'frontend' 
					|| !$arguments->getSubject()->View()->hasTemplate()
					) {
					return;
				}
 
        //Add our plugin template directory to load our slogan extension.
        $view->addTemplateDir($this->Path() . 'Views/');
 
        $view->extendsTemplate('frontend/index/footer-navigation.tpl');

		for($i = 1; $i < 5; $i++) {
			$contentShow = "pprContentShow$i";
			$contentColumn = "pprContentColumn$i";
			$view->assign("show$i", $this->Config()->$contentShow);
			$view->assign("column$i", $this->Config()->$contentColumn);
		}

	}
}


