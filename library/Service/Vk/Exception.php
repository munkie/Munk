<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Service_Vk_Exception extends Munk_Service_Exception
{
    /**
     * 
     * @var array
     */
    protected $_vkErrorCodes = array(1, 2, 3, 4, 5, 8, 150);
    
    /**
     * Tells whether it was VK request error
     * if false then it was internal error
     * @return boolean
     */
    public function isVkError()
    {
        if (in_array($this->code, $this->_vkErrorCodes)) {
            return true;
        } else {
            return false;
        }
    }
}