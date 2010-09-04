<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Inc_ReleaseGroup extends Munk_MusicBrainz_Inc_Abstract
{
    /*
     * 
     */
    const ARTIST   = Munk_MusicBrainz::INC_ARTIST;
    const RELEASES = Munk_MusicBrainz::INC_RELEASES;
    
    /**
     * 
     * @var array
     */
    protected $_data = array(
        self::ARTIST   => null,
        self::RELEASES => null,
    );
}