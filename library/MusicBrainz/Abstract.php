<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_Abstract
{
    /**
     * 
     * @var unknown_type
     */
    protected $_db;
    
    /**
     * 
     * @var unknown_type
     */
    protected $_limit = 25;
    
    /**
     * 
     * @param $options
     */
    public function __construct($options = array())
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        } else if ($options instanceof Zend_Db_Adapter_Pdo_Pgsql) {
            $options = array('db' => $options);
        } else if (!is_array($options)) {
            throw new Munk_MusicBrainz_Exception('Invalid options passed to gateway');
        }
        
        if (!isset($options['db'])) {
            throw new Munk_MusicBrainz_Exception('Db adapter is required');
        }
        
        $this->setOptions($options);
    }
    
    /**
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $method = 'set' . $options;
            if (method_exists($this, $method)) {
                $this->$method($options);
            }
        }
    }
    
    /**
     * 
     * @param Zend_Db_Adapter_Pdo_Pgsql|array $db
     */
    public function setDb($db)
    {
        if ($db instanceof Zend_Db_Adapter_Pdo_Pgsql) {
            $this->_db = $db;
        } else {
            $this->_db = Zend_Db::factory('Pdo_Pgsql', $db);
        }
    }
    
    /**
     * @return Zend_Db_Adapter_Pdo_Pgsql
     */
    public function getDb()
    {
        return $this->_db;
    }
    
    /**
     * 
     * @param integer $limit
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
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
     * @param string $resultClass
     * @param string $query
     * @param mixed  $bind
     * 
     * @return Munk_MusicBrainz_Result_Interface|false
     */
    protected function _query($resultName, $query, $bind = array())
    {
        $data = $this->getDb()->query($query, $bind)
                              ->fetch(Zend_Db::FETCH_ASSOC);
        if (!is_array($data)) {
            return false;
        } else {
            return $this->_createResult($resultName, $data);
        }
    }
    
    /**
     * 
     * @param string $resultSetClass
     * @param string $query
     * @param mixed  $bind
     * 
     * @return Munk_MusicBrainz_ResultSet_Interface|false
     */
    protected function _querySet($resultSetName, $query, $bind = array())
    {
        $data = $this->getDb()->query($query, $bind)
                              ->fetchAll(Zend_Db::FETCH_ASSOC);
        if (0 == count($data)) {
            return false;
        } else {
            return $this->_createResultSet($resultSetName, $data);
        }
    }
    
    /**
     * 
     * @param string $resultName
     * @param array  $data
     * 
     * @return Munk_MusicBrainz_Result_Interface
     */
    protected function _createResult($resultName, array $data)
    {
        $resultClass = 'Munk_MusicBrainz_Result_' . $resultName;
        return new $resultClass($data);
    }
    
    /**
     * 
     * @param string $resultSetName
     * @param array  $data
     * 
     * @return Munk_MusicBrainz_ResultSet_Interface
     */
    protected function _createResultSet($resultSetName, array $data)
    {
        $resultSetClass = 'Munk_MusicBrainz_ResultSet_' . $resultSetName;
        return new $resultSetClass($data);
    }
    
    /**
     * 
     * @param string  $resultSetName
     * @param string  $query
     * @param integer $offset
     * @param integer $limit
     * 
     * @return Munk_MusicBrainz_ResultSet_Interface|false
     */
    protected function _search($resultSetName, $query = null, $offset = null, $limit = null)
    {
        if (null === $offset) {
            $offset = 0;
        }
        if (null === $limit) {
            $limit = $this->getLimit();
        }
        
        $data = null;
        
        return $this->_createResultSet($resultSetName, $data);
    }
}