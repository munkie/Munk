<?php
/**
 * 
 * @author munkie
 * 
 * @property integer $limit
 * @property integer $offset
 * @property integer $query
 * 
 * @method string getLimit()
 * @method boolean issetLimit()
 * @method Munk_MusicBrainz_Filter_Abstract unsetLimit()
 *
 * @method string getOffset()
 * @method boolean issetOffset()
 * @method Munk_MusicBrainz_Filter_Abstract unsetOffset()
 * 
 * @method string getQuery()
 * @method Munk_MusicBrainz_Filter_Abstract setQuery($query)
 * @method boolean issetQuery()
 * @method Munk_MusicBrainz_Filter_Abstract unsetQuery()
 */
abstract class Munk_MusicBrainz_Filter_Abstract extends Munk_Util_DataObject_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_exceptionClass = 'Munk_MusicBrainz_Filter_Exception';
    
    /**
     * Basic query data
     * 
     * @var array
     */
    protected $_queryData = array(
        'limit'  => 25,
        'offset' => null,
        'query'  => null,
    );
    
    /**
     * 
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        $this->_data += $this->_queryData;
        parent::__construct($data);
    }
    
    /**
     * 
     * @param  integer $limit
     * @return Munk_MusicBrainz_Filter_Abstract
     */
    public function setLimit($limit)
    {
        $limit = (int) $limit;
        if ($limit < 1 || $limit > 100) {
            $this->_fault("Invalid limit value. Must be integer beetween 1 and 100");
        }
        return $this->_set('limit', $limit);
    }
    
    /**
     * 
     * @param integer $offset
     * @return Munk_MusicBrainz_Filter_Abstract
     */
    public function setOffset($offset)
    {
        return $this->_set('offset', (int) $offset);
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
        return http_build_query($this->toArray(true), $numericPrefix, $argSeparator);
    }
    
    /**
     * 
     * @param boolean $filterNullValues
     * @return array
     */
    public function toArray($filterNullValues = false)
    {
        $data = parent::toArray();
        if ($filterNullValues) {
            $data = array_filter($data, array($this, 'isNotNull'));
        }
        return $data;
    }
    
    /**
     * 
     * @param  mixed $value
     * @return boolean
     */
    public function isNotNull($value)
    {
        return null !== $value;
    }
    
    /**
     * 
     * @param string $type
     * @param array $data
     * 
     * @return Munk_MusicBrainz_Filter_Abstract
     */
    static public function factory($type, array $data = null)
    {
        $class = 'Munk_MusicBrainz_Filter_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Exception("Invalid query type provided: $type. Class $class does not exist");
        }
        return new $class($data);
    }
}