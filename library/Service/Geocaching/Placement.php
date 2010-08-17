<?php

class Munk_Service_Geocaching_Placement
{
    /**
     * 
     * @var integer
     */
    protected $_cid;
    
    /**
     * 
     * @var string
     */
    protected $_url;
    
    /**
     * 
     * @var string
     */
    protected $_description;
    
    /**
     * 
     * @var array
     */
    protected $_thumbnails = array();
    
    /**
     * 
     * @var string
     */
    protected $_title;
    
    /**
     * 
     * @var float
     */
    protected $_lat;
    
    /**
     * 
     * @var float
     */
    protected $_lon;
    
    /**
     * 
     * @var string
     */
    protected $_type;
    
    /**
     * Constructor
     * 
     * @param SimpleXMLElement $data
     */
    public function __construct(SimpleXMLElement $data = null)
    {
        if (null !== $data) {
            $this->populate($data);
        }
    }
    
    /**
     * 
     * @param $data
     */
    public function populate(SimpleXMLElement $data)
    {
        $this->_title = trim((string) $data->name);
        $this->_parseCoordinates((string) $data->Point->coordinates);
        $this->_parseDescription((string) $data->description);
    }
    
    /**
     * 
     * @param string $data
     * @return void
     * @throws Munk_Service_Geocaching_Exception
     */
    protected function _parseCoordinates($data)
    {
        $coords = explode(',', (string) $data);
        if (count($coords) == 2) {
            $this->_lat = (float) $coords[0];
            $this->_lon = (float) $coords[1];
            return;
        }
        
        throw new Munk_Service_Geocaching_Exception("Failed to parse coordinates, given: $data");
    }
    
    /**
     * 
     * @param string $data
     * @return void
     */
    protected function _parseDescription($data)
    {
        $this->_parseCid($data);
        $this->_parseThumbnails($data);
        $this->_parseDesc($data);
    }
    
    protected function _parseDesc(&$data)
    {
        $data = preg_replace('#^<p></p>#', '', $data);
        $data = preg_replace('#^<(/?)br(/?)>#', '', $data);
        $data = preg_replace('#<(/?)br(/?)>\s*$#', '', $data);
        $this->_description = $data;
    }
    
    /**
     * 
     * @param string $data
     * @return string
     */
    protected function _parseCid(&$data)
    {
        $matches = array();
        $pattern = '#<a\s+href="([^"]*?cid=(\d+)\#)">.*?</a>\s*$#';
        if (preg_match($pattern, $data, $matches)) {
            $this->_cid = $matches[2];
            $this->_url = $matches[1];
            $data = preg_replace($pattern, '', $data);
        }    
    }
    
    /**
     * 
     * @param string $data
     */
    protected function _parseThumbnails(&$data)
    {
        $data = preg_replace('#^.*?(<p>)#', '\\1', $data);

        $matches = array();
        $pattern = '#^<p>(<img\s+src="([^"]+\d+\.jpg)"/><br/>).*?</p>#';
        while (preg_match($pattern, $data, $matches, PREG_OFFSET_CAPTURE)) {
             $data = substr($data, 0, $matches[1][1] - 1) . substr($data, $matches[1][1] + strlen($matches[1][0]) - 1);
             $this->_thumbnails[] = $matches[2][0];
        }
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'cid'         => $this->_cid,
            'description' => $this->_description,
            'lat'         => $this->_lat,
            'lon'         => $this->_lon,
            'thumbnails'  => $this->_thumbnails,
            'title'       => $this->_title,
            'type'        => $this->_type,
            'url'         => $this->_url,
        );
    }
    
    /**
     * @return boolean
     */
    public function isValid()
    {
        return isset($this->_cid, $this->_description, $this->_lat, $this->_lon, $this->_title, $this->_url);
    }
}