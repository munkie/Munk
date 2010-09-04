<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Result_Release extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'title' => null,
        'asin'  => null,
        'mbid'  => null,
        'releasetype' => null,
        'releasestatus' => null,
        'script' => null,
        'language' => null,
        // rels
        'artist' => null,
    );
    
    /**
     * 
     * @param Munk_MusicBrainz_Result_Artist $artist
     * @return Munk_MusicBrainz_Result_Release
     */
    public function setArtist(Munk_MusicBrainz_Result_Artist $artist)
    {
        return $this->__set('artist', $artist);
    }
}