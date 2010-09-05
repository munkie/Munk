<?php
/**
 * 
 * @author munkie
 * 
 * @property string $title
 * @property string $asin
 * @property string $mbid
 * @property string $releasetype
 * @property string $releasestatus
 * @property string $script
 * @property string $language
 *
 * @property Munk_MusicBrainz_Result_Artist     $artist
 * @property Munk_MusicBrainz_ResultSet_Tracks  $tracks
 * @property Munk_MusicBrainz_ResultSet_Tags    $tags
 * @property Munk_MusicBrainz_Result_Rating     $rating
 * @property Munk_MusicBrainz_Result_ReleaseGroup     $releaseGroup
 * @property Munk_MusicBrainz_ResultSet_Event $events
 */
class Munk_MusicBrainz_Result_Release extends Munk_MusicBrainz_Result_Abstract
{
    /*
     * 
     */
    const COVER_ART_SIZE_S = 'S';
    const COVER_ART_SIZE_M = 'M';
    const COVER_ART_SIZE_L = 'L';
    
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'title'         => null,
        'asin'          => null,
        'mbid'          => null,
        'releasetype'   => null,
        'releasestatus' => null,
        'script'        => null,
        'language'      => null,
        // incs
        'artist'        => null,
        'tracks'        => null,
        'tags'          => null,
        'rating'        => null,
        'releasegroup'  => null,
        'events'        => null,
    );
    
    /**
     * 
     * @param Munk_MusicBrainz_Result_Artist $artist
     * 
     * @return Munk_MusicBrainz_Result_Release
     */
    public function setArtist(Munk_MusicBrainz_Result_Artist $artist)
    {
        $this->_set('artist', $artist);
        return $this;
    }
    
    /**
     * 
     * @param string $size
     * @param string $server
     * 
     * @return string
     */
    public function getCoverArtUrl($size = self::COVER_ART_SIZE_L, $server = '01')
    {
        $url = "http://ec1.images-amazon.com/images/P/{$this->asin}.{$server}.{$size}ZZZZZZZ.jpg";
        return $url;
    }
    
    /**
     * @return string|null
     */
    public function getDate()
    {
        if ($this->events instanceof Munk_MusicBrainz_ResultSet_Event) {
            $oldestEvent = $this->events->findOldestEvent();
            if ($oldestEvent instanceof Munk_MusicBrainz_Result_Event) {
                return $oldestEvent->date;
            }
        }
        return null;
    }
}