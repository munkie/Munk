<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Validate_IndexedArray extends Zend_Validate_Abstract
{
    const INVALID     = 'indexedInvalid';
    const NOT_INDEXED = 'notIndexed';
    
    /**
     * 
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID     => "Invalid type given, value should be an array",
        self::NOT_INDEXED => "Array is not indexed",
    );
    
    /**
     * 
     * @param array $value
     * @return boolean
     */
    public function isValid($value) {
        if (!is_array($value)) {
            $this->_error(self::INVALID);
            return false;
        }
        
        if (array_values($value) !== $value) {
            $this->_error(self::NOT_INDEXED);
            return false;            
        }
        
        return true;
    }
}