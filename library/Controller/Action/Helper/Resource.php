<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Controller_Action_Helper_Resource extends Zend_Controller_Action_Helper_Abstract
{   
    /**
     * 
     * @var Zend_Application_Bootstrap_BootstrapAbstract
     */
    protected $_bootstrap;
    
    /**
     * 
     * @param string $resourceName
     * 
     * @return mixed
     */
    public function __get($resourceName)
    {
        return $this->getResource($resourceName);
    }
    
    /**
     * @return Zend_Application_Bootstrap_BootstrapAbstract
     */
    protected function _getBootstrap()
    {
        if (null === $this->_bootstrap) {
            $this->_bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
            if (null === $this->_bootstrap) {
                throw new Zend_Controller_Action_Exception('Bootstrap not found in front controller');
            }
            if (!$this->_bootstrap instanceof Zend_Application_Bootstrap_BootstrapAbstract) {
                throw new Zend_Controller_Action_Exception('Invlalid bootstrap. Must extend Zend_Application_Bootstrap_BootstrapAbstract');
            }
        }
        return $this->_bootstrap;
    }
    
    /**
     * 
     * @param string $resourceName
     * 
     * @return mixed
     */
    public function direct($resourceName)
    {
        return $this->getResource($resourceName);
    }
    
    /**
     * 
     * @param string $resourceName
     * 
     * @return mixed
     */
    public function getResource($resourceName)
    {
        return $this->_getBootstrap()->getResource($resourceName);
    }
}