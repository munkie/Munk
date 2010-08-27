<?php

abstract class Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_map = array();
    
    /**
     * 
     * @var string
     */
    protected $_resultXPath;
    
    /**
     * 
     * @var string
     */
    protected $_resultSetXPath;
    
    /**
     * 
     * @var string
     */
    protected $_type;
    
    /**
     * 
     * @var SimpleXMLElement
     */
    protected $_sxml;
    
    /**
     * 
     * @param SimpleXMLElement $sxml
     */
    public function __construct(SimpleXMLElement $sxml = null)
    {
        if (null !== $sxml) {
            $this->setSxml($sxml);
        }
    }
    
    /**
     * 
     * @param SimpleXMLElement $sxml
     */
    public function setSxml(SimpleXMLElement $sxml)
    {
        $this->_sxml = $sxml;
    }
    
    /**
     * @return SimpleXMLElement|null
     */
    public function getSxml()
    {
        return $this->_sxml;
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * @return string
     */
    public function getResultTag()
    {
        return $this->_resultTag;
    }
    
    /**
     * @return string
     */
    public function getResultSetTag()
    {
        return $this->_resultSetTag;
    }
    
    /**
     * @return Munk_MusicBrainz_Result_Abstract
     */
    public function getResult(SimpleXMLElement $item = null)
    {
        if (null === $item) {
            $items = $this->_sxml->xpath($this->_resultXPath);
            if (is_array($items) && count($items) > 0) {
                $item = $items[0];
            }
        }
        if (null !== $item) {
            return $this->_getResult($item);
        }
    }
    
    /**
     * @return Munk_MusicBrainz_ResultSet_Abstract
     */
    public function getResultSet(array $items = null)
    {
        $resultSet = Munk_MusicBrainz_ResultSet_Abstract::factory($this->_type);
        
        if (null === $items) {
           $items = $this->_sxml->xpath($this->_resultSetXPath);
        }

        if (is_array($items) && count($items) > 0) {
            foreach ($items as $position => $item) {
                $resultSet->addResult($this->_getResult($item));
            }
            $root = $item->xpath('parent::*[@count and @offset]');
            if (isset($root[0]['count'], $root[0]['offset'])) {
                $resultSet->setCount((string) $root[0]['count']);
                $resultSet->setOffset((string) $root[0]['offset']);
            }
        }
        
        return $resultSet;
    }
    
    /**
     * @return Munk_MusicBrainz_Result_Abstract
     */
    protected function _getResult(SimpleXMLElement $sxml)
    {
        $result = Munk_MusicBrainz_Result_Abstract::factory($this->_type);
        foreach ($this->_map as $field => $params) {
            if (is_string($params)) {
                $params = array('xpath' => $params);
            }
            $xpath = '.' . $params['xpath'];
            $values = $sxml->xpath($xpath);
            if (isset($values[0])) {
                $value = $values[0];
                // a workaround to parse attr cause xpath always return element not attr
                if (preg_match('/\/@([a-zA-Z0-9\-_]+)$/', $params['xpath'], $matches)) {
                    $value = $value[$matches[1]];
                }
                if (isset($params['relResult'])) {
                    $value = $this->_getRelResult($params['relResult'], $value);
                } else if (isset($params['relResultSet'])) {
                    $value = $this->_getRelResultSet($params['relResultSet'], $values);
                } else if (isset($params['callback'])) {
                    $value = call_user_func(array($this, $params['callback']), $value);
                } else {
                    $type = (isset($params['type'])) ? $params['type'] : 'string';
                    settype($value, $type);
                }
                $result->$field = $value;
            }
        }
        return $result;
    }
    
    /**
     * 
     * @param string $type
     * @param SimpleXMLElement $item
     * 
     * @return Munk_MusicBrainz_Result_Abstract
     */
    protected function _getRelResult($type, SimpleXMLElement $item)
    {
        $mapper = self::factory($type);
        return $mapper->getResult($item);
    }
    
    /**
     * 
     * @param string $type
     * @param array $items
     * 
     * @return Munk_MusicBrainz_ResultSet_Abstract
     */
    protected function _getRelResultSet($type, array $items)
    {
        $mapper = self::factory($type);
        return $mapper->getResultSet($items);        
    }
    
    /**
     * 
     * @param string $type
     * @param SimpleXMLElement $sxml
     * 
     * @return Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
     */
    static public function factory($type, SimpleXMLElement $sxml = null)
    {
        $class = 'Munk_MusicBrainz_Adapter_Rest_Mapper_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Adapter_Rest_Exception("Mapper not found. Class $class does not exist");
        }
        return new $class($sxml);
    }
}