<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Filter_Track extends Munk_MusicBrainz_Filter_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'title'       => null,
        'artist'      => null,
        'release'     => null,
        'duration'    => null,
        'tracknumber' => null,
        'artistid'    => null,
        'releaseid'   => null,
        'puid'        => null,
        'count'       => null,
        'releasetype' => null,
    );
}