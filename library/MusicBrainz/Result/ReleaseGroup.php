<?php
/**
 * 
 * @author munkie
 * 
 * @property string $mbid
 * @property string $title
 * @property string $type
 * 
 * @property Munk_MusicBrainz_Result_Artist $artist
 * @property Munk_MusicBrainz_ResultSet_Release $releases
 */
class Munk_MusicBrainz_Result_ReleaseGroup extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'mbid'  => null,
        'title' => null,
        'type'  => null,
        // incs
        'artist'   => null,
        'releases' => null,
    );
}