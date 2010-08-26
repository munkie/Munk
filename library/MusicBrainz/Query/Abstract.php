<?php
/**
 * 
 * @author munkie
 * 
 * @property integer $limit
 */
abstract class Munk_MusicBrainz_Query_Abstract extends Munk_Util_DataObject_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_exceptionClass = 'Munk_MusicBrainz_Search_Exception';
    
    /**
     * 
     * @var integer
     */
    protected $_limit = 25;
    
    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->_limit;
    }
    
    /**
     * 
     * @param $limit
     * @return Munk_MusicBrainz_Query_Abstract
     */
    public function setLimit($limit)
    {
        $limit = (int) $limit;
        if ($limit < 1 || $limit > 100) {
            $this->_fault("Invalid limit value. Must be integer beetween 1 and 100");
        }
        
        $this->_limit = $limit;
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function issetLimit()
    {
        return isset($this->_limit);
    }
    
    /**
     * @return Munk_MusicBrainz_Query_Abstract
     */
    public function unsetLimit()
    {
        $this->_limit = null;
        return $this;
    }
    
    /**
     * 
     * @param string $numericPrefix
     * @param string $argSeparator
     * 
     * @return string
     */
    public function toHttpQuery($numericPrefix = null, $argSeparator = null)
    {
        return http_build_query($this->toArray(), $numericPrefix, $argSeparator);
    }
}