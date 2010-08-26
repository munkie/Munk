<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_ResultSet_Abstract implements Munk_MusicBrainz_ResultSet_Interface
{
    /**
     * 
     * @var integer
     */
    protected $_position = 0;
    
    /**
     * 
     * @var array
     */
    protected $_data = array();
    
    /**
     * 
     * @var string
     */
    protected $_resultClass;
    
    /**
     * 
     * @var integer
     */
    protected $_count = 0;
    
    /**
     * 
     * @var integer
     */
    protected $_offset = 0;
    
    /**
     * 
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->_setupResultClass();
        $this->setResults($data);
    }
    
    /**
     * @throws Munk_MusicBrainz_Exception
     */
    protected function _setupResultClass()
    {
        if (null === $this->_resultClass) {
            $className = get_class($this);
            if (0 === strpos($className, 'Munk_MusicBrainz_ResultSet_')) {
                $this->_resultClass = 'Munk_MusicBrainz_ResultSet_' . substr($className, 23);
            }
        }
        
        if (!class_exists($this->_resultClass)) {
            throw new Munk_MusicBrainz_Exception("Result class $this->_resultClass does not exist");
        }
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Result_Interface|array $result
     * 
     * @return Munk_MusicBrainz_ResultSet
     */
    public function addResult($result)
    {
        if ($result instanceof $this->_resultClass) {
            $this->_data[] = $result;
        } else if (is_array($result)) {
            $this->_data[] = new $this->_resultClass($result);
        } else {
            throw new Munk_MusicBrainz_Exception('Invalid result provided');
        }
    }
    
    /**
     * 
     * @param array $data
     */
    public function addResults(array $data)
    {
        foreach ($data as $result) {
            $this->addResult($result);
        }
    }
    
    /**
     * 
     * @param array $data
     */
    public function setResults(array $data)
    {
        $this->clearResults();
        $this->addResults($data);
    }
    
    /**
     * 
     */
    public function clearResults()
    {
        $this->_data = array();
    }
    
	/**
     * 
     */
    public function count()
    {
        return count($this->_data);
    }

	/**
     * @return Munk_MusicBrainz_Result_Interface
     */
    public function current()
    {
        return $this->_data[$this->_position];
    }

	/**
     * @return integer
     */
    public function key()
    {
        return $this->_position;
    }

	/**
     * 
     */
    public function next()
    {
        $this->_position++;
    }

	/**
     * 
     */
    public function rewind()
    {
        $this->_position = 0;
    }

	/**
     * @param integer $position
     */
    public function seek($position)
    {
        $this->_position = $position;
        if (!$this->valid()) {
            throw new OutOfBoundsException();
        }
    }

	/**
     * @return boolean
     */
    public function valid()
    {
        return (array_key_exists($this->_position, $this->_data));
    }
    
    /**
     * 
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->_count = (int) $count;
    }
    
    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->_count;
    }
    
    /**
     * 
     * @param inetger $offset
     */
    public function setOffset($offset)
    {
        $this->_offset = (int) $offset;
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
     * @param string $type
     * @param mixed  $data
     * 
     * @return Munk_MusicBrainz_ResultSet_Abstract
     */
    static public function factory($type, array $data = array())
    {
        $class = 'Munk_MusicBrainz_ResultSet_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Exception("Invalid type: $type. Class $class does not exist");
        }
        return new $class($data);
    }
}