<?php

class Munk_Service_Geocaching_Parser
{   
    /**
     * 
     * @var string
     */
    protected $_filepath;
    
    /**
     * 
     * @var integer
     */
    protected $_limit = 20;
    
    /**
     * 
     * @var integer
     */
    protected $_offset = 0;
    
    /**
     * 
     * @param string $filename
     */
    public function __construct($filepath = null)
    {
        if (null !== $filepath) {
            $this->setFilepath($filepath);
        }
    }
    
    /**
     * 
     * @param string $filepath
     * 
     * @return Service_XmlParser
     */
    public function setFilepath($filepath)
    {
        $filepath = realpath($filepath);
        
        if (!is_readable($filepath)) {
            throw new Munk_Service_Geocaching_Exception("Can't read file $filepath");
        }
        
        $this->_filepath = $filepath;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFilepath()
    {
        if (null === $this->_filepath) {
            throw new Munk_Service_Geocaching_Exception('Filename is not set');
        }
        return $this->_filepath;
    }

    /**
     * 
     * @param integer $limit
     * 
     * @return Munk_Service_Geocaching_Parser
     */
    public function setLimit($limit)
    {
        $this->_limit = (int) $limit;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->_limit;
    }
    
    /**
     * 
     * @param integer $offset
     * 
     * @return Munk_Service_Geocaching_Parser
     */
    public function setOffset($offset)
    {
        $this->_offset = (int) $offset;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getOffset()
    {
        return $this->_offset;
    }
    
    /**
     * 
     * @param $tag
     * @param $limit
     * @param $offset
     * 
     * @return array|false
     */
    public function parse($tag = 'Placemark', $limit = null, $offset = null)
    {
        if (null === $limit) {
            $limit = $this->getLimit();
        }
        if (null === $offset) {
            $offset = $this->getOffset();
        }
        
        $reader = new XMLReader();
        $reader->open($this->getFilepath());
        
        $counter = 0;
        $break = false;
        $items = array();
        
        while ($reader->read()) {
            ++$counter;
            if ($counter > $offset) {
                // offer element
                if ($reader->nodeType == XMLReader::ELEMENT && $tag == $reader->localName) {
                    $sxe = $this->_saxToSxe($reader);
                    $items[] = new Munk_Service_Geocaching_Placement($sxe);
                    if (null !== $limit && count($items) == $limit) {
                        $break = true;
                        break;
                    }
                }
            }
        }
        // update offset
        $this->setOffset($counter);
        
        $reader->close();
        
        if ($break) {
            return $items;
        // we have parsed all file
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param XMLReader $reader
     * 
     * @return SimpleXMLElement|string
     */
    protected function _saxToSxe(XMLReader $reader)
    {
        $node = $reader->expand();
        try {
            $dom = new DomDocument();
            $n = $dom->importNode($node, TRUE);
            $dom->appendChild($n);
            return simplexml_import_dom($n);
        } catch (Exception $e) {
            return $reader->readInnerXml();
        }
    }
}