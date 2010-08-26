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
     * @return Munk_MusicBrainz_Result_Abstract
     */
    public function getResult()
    {
        $results = $this->_sxml->xpath($this->_resultXPath);
        if (is_array($results) && count($results) > 0) {
            return $this->_getResult($results[0], $this->_resultXPath, 0);
        }
    }
    
    /**
     * @return Munk_MusicBrainz_ResultSet_Abstract
     */
    public function getResultSet()
    {
        $items = $this->_sxml->xpath($this->_resultSetXPath);
        $data = array();
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $position => $item) {
                $data[] = $this->_getResult($item, $this->_resultSetXPath, $position);
            }
        }
        $resultSet = Munk_MusicBrainz_ResultSet_Abstract::factory($this->_type, $data);
        $root = $this->_sxml->xpath('/*/*[@count and @offset]');
        if (isset($root[0]['count'], $root[0]['offset'])) {
            $resultSet->setCount((string) $root[0]['count']);
            $resultSet->setOffset((string) $root[0]['offset']);
        }
        return $resultSet;
    }
    
    /**
     * @return Munk_MusicBrainz_Result_Abstract
     */
    protected function _getResult(SimpleXMLElement $sxml, $preXpath, $position)
    {
        $result = Munk_MusicBrainz_Result_Abstract::factory($this->_type);
        $preXpath.= "[position() = $position]"; 
        foreach ($this->_map as $field => $params) {
            if (is_string($params)) {
                $params = array('xpath' => $params);
            }
            $xpath = $preXpath . $params['xpath'];
            $value = $sxml->xpath($xpath);
            if (isset($value[0])) {
                $value = $value[0];
                // a workaround to parse attr cause xpath always return element not attr
                if (preg_match('/\/@([a-zA-Z0-9\-]+)$/', $params['xpath'], $matches)) {
                    $value = $value[$matches[1]];
                }
                if (isset($params['callback'])) {
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
}