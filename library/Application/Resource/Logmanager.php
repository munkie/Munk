<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Application_Resource_Logmanager extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * 
     * @var Munk_Log_Manager
     */
    protected $_manager;
    
    /**
     * @return Munk_Log_Manager
     */
    public function init() {
    	if (null === $this->_manager) {
    	    $this->_manager = $this->getManager();
    	}
    	return $this->_manager;
    }
    
    /**
     * @return Munk_Log_Manager
     */   
    public function getManager()
    {
        $manager = Munk_Log_Manager::getInstance();
        foreach ($this->getOptions() as $name => $options) {
            $manager->set($name, $options);
        }
        return $manager;
    }
}