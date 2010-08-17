<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz
{
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
     * @param string $resultClass
     * @param string $query
     * @param mixed  $bind
     * 
     * @return Munk_MusicBrainz_Result_Interface
     */
    protected function _query($resultClass, $query, $bind = array())
    {
        $result = $this->getDb()->query($query, $bind)
                                ->fetch(Zend_Db::FETCH_ASSOC);
        if (!is_array($result)) {
            return false;
        } else {
            return new $resultClass($result);
        }
    }
    
    /**
     * 
     * @param string $resultSetClass
     * @param string $query
     * @param mixed  $bind
     * 
     * @return Munk_MusicBrainz_ResultSet_Interface
     */
    protected function _querySet($resultSetClass, $query, $bind = array())
    {
        $result = $this->getDb()->query($query, $bind)
                                ->fetch(Zend_Db::FETCH_ASSOC);
        if (!is_array($result)) {
            return false;
        } else {
            return new $resultClass($result);
        }
    }
}