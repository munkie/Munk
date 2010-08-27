<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Filter_Release extends Munk_MusicBrainz_Filter_Abstract
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
        'releasetypes' => null,
        'count' => null,
        'date' => null,
        'asin' => null,
        'lang' => null,
        'script' => null,
        'cdstubs' => null,
    );
}