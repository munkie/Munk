<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Filter_Release extends Munk_MusicBrainz_Filter_ReleaseGroup
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'title' => null,
        'discid' => null, 
        'artist' => null,
        'artistid' => null,
        'releasetypes' => array(),
        'count' => null,
        'date' => null,
        'asin' => null,
        'lang' => null,
        'script' => null,
        'cdstubs' => null,
    );
}