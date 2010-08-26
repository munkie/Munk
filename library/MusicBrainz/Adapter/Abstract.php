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
     * @param array|Munk_MusicBrainz_Filter_Abstract $filter
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_Filter_Abstract
     * 
     * @throws Munk_MusicBrainz_Exception
     */
    protected function _makeFilter($type, $filter = null, $limit = null, $offset = null)
    {
        if (is_array($filter) || null === $filter) {
            $filter = Munk_MusicBrainz_Filter_Abstract::factory($type, $filter);
        } else if (!$filter instanceof Munk_MusicBrainz_Filter_Abstract) {
            throw new Munk_MusicBrainz_Exception("Invalid query object must be instance of Munk_MusicBrainz_Filter_Abstract");
        }
        
        if (null !== $limit) {
            $filter->setLimit($limit);
        }
        
        if (null !== $offset) {
            $filter->setOffset($offset);
        }
        
        return $filter;
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
        if (is_array($inc) || null === $inc) {
            $inc = Munk_MusicBrainz_Inc_Abstract::factory($type, $inc);
        } else if (!$inc instanceof Munk_MusicBrainz_Inc_Abstract) {
            throw new Munk_MusicBrainz_Exception("Invalid inc object must be instance of Munk_MusicBrainz_Inc_Abstract");
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
     * @param mixed   $filter
     * @param mixed   $inc
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtists($filter = null, $limit = null, $offset = null)
    {
        if (is_string($filter)) {
            $filter = array('name' => $filter);
        }
        $filter = $this->_makeFilter('Artist', $filter, $limit, $offset);
        return $this->_searchArtists($filter);
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Artist $filter
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    abstract protected function _searchArtists(Munk_MusicBrainz_Filter_Artist $filter);
}