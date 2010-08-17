<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz extends Munk_MusicBrainz_Abstract
{
    /**
     * 
     * @param $mbid
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    public function getArtist($mbid)
    {
        $query = "SELECT * FROM artist WHERE gid = ?";
        return $this->_query(self::TYPE_ARTIST, $query, $mbid);
    }
    
    /**
     * 
     * @param strign  $name
     * @param integer $offset
     * @param integer $limit
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtist($name = '', $offset = null, $limit = null)
    {
        $term = $name;
        $query = "artist:($term)(sortname:($term) alias:($term) !artist:($term))";
        return $this->search(self::TYPE_ARTIST, $query, $offset, $limit);
    }
    
    /**
     * 
     * @param $id
     * 
     * @return Munk_MusicBrainz_ResultSet_Alias
     */
    public function getArtistAliases($id)
    {
        return $this->_getAliases($id, 'ArtistAlias');
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
    public function search($resultSetName, $query = null, $offset = null, $limit = null)
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
    
    /**
     * 
     * @param integer $id
     * @param string  $table
     * 
     * @return Munk_MusicBrainz_ResultSet_Alias
     */
    protected function _getAliases($id, $table)
    {
        $query = "SELECT id, Name, TimesUsed, LastUsed, ModPending
                    FROM $table
                    WHERE ref = ?
                    ORDER BY TimesUsed DESC";
        return $this->_querySet(self::TYPE_ALIAS, $query, $id);
    }
}