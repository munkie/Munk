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
     * @param string $mbid
     * @param mixed  $inc
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    public function getArtist($mbid, $inc = null)
    {
        $inc = $this->_makeInc(Munk_MusicBrainz::TYPE_ARTIST, $inc);
        return $this->_getArtist($mbid, $inc);
    }
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    abstract protected function _getArtist($mbid, Munk_MusicBrainz_Inc_Artist $inc);
    
    /**
     * 
     * @param mixed   $query
     * @param mixed   $inc
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtists($query = null, $limit = null, $offset = null)
    {
        if (is_string($query)) {
            $query = array('name' => $query);
        }
        $query = $this->_makeQuery('Artist', $query, $limit, $offset);
        return $this->_searchArtist($query);
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Query_Artist $query
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    abstract protected function _searchArtists(Munk_MusicBrainz_Query_Artist $query);
}