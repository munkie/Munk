<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_Adapter_Abstract implements Munk_MusicBrainz_Adapter_Interface
{
    /**
     * 
     * @param string $type
     * @param array|Munk_MusicBrainz_Query_Abstract $query
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_Query_Abstract
     * 
     * @throws Munk_MusicBrainz_Exception
     */
    protected function _makeQuery($type, $query = null, $limit = null, $offset = null)
    {
        $class = 'Munk_MusicBrainz_Query_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Exception("Invalid query type provided: $type. Class $class does not exist");
        }
        if (is_array($query) || null === $query) {
            $query = new $class($query);
        } else if (!$query instanceof $class) {
            throw new Munk_MusicBrainz_Exception("Invalid query object must be instance of $class");
        }
        
        if (null !== $limit) {
            $query->setLimit($limit);
        }
        
        if (null !== $offset) {
            $query->setOffset($offset);
        }
        
        return $query;
    }
    
    /**
     * 
     * @param string $type
     * @param array|Munk_MusicBrainz_Inc_Abstract $inc
     * 
     * @return Munk_MusicBrainz_Inc_Abstract
     */
    protected function _makeInc($type, $inc = null)
    {
        $class = 'Munk_MusicBrainz_Inc_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Exception("Invalid inc type provided: $type. Class $class does not exist");
        }
        if (is_array($inc) || null === $inc) {
            $inc = new $class($inc);
        } else if (!$inc instanceof $class) {
            throw new Munk_MusicBrainz_Exception("Invalid inc object must be instance of $class");
        }

        return $inc;
    }
    
    /**
     * 
     * @param mixed   $query
     * @param mixed   $inc
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtists($query = null, $inc = null, $limit = null, $offset = null)
    {
        if (is_string($query)) {
            $query = array('name' => $query);
        }
        $query = $this->_makeQuery('Artist', $query, $limit, $offset);
        $inc   = $this->_makeInc('Artist', $inc);
        return $this->_searchArtist($query, $inc);
    }
    
    abstract protected function _searchArtists(Munk_MusicBrainz_Query_Artist $query, Munk_MusicBrainz_Inc_Artist $inc);
}