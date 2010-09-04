<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_Adapter_Db implements Munk_MusicBrainz_Adapter_Interface
{
    /**
     * 
     * @param $mbid
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    public function getArtist($mbid, Munk_MusicBrainz_Inc_Artist $inc)
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
    public function searchArtist(Munk_MusicBrainz_Filter_Artist $filter)
    {
        $term = $filter->name;
        $query = "artist:($term)(sortname:($term) alias:($term) !artist:($term))";
        return $this->search(self::TYPE_ARTIST, $query, $filter->offset, $filter->limit);
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