<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Inc_Label extends Munk_MusicBrainz_Inc_Abstract
{
    /*
     * 
     */
    const ALIASES       = Munk_MusicBrainz::INC_ALIASES;
    const ARTIST_RELS   = Munk_MusicBrainz::INC_ARTIST_RELS;
    const LABEL_RELS    = Munk_MusicBrainz::INC_LABEL_RELS;
    const RELEASE_RELS  = Munk_MusicBrainz::INC_RELEASE_RELS;
    const TRACK_RELS    = Munk_MusicBrainz::INC_TRACK_RELS;
    const URL_RELS      = Munk_MusicBrainz::INC_URL_RELS;
    const TAGS          = Munk_MusicBrainz::INC_TAGS;
    const RATINGS       = Munk_MusicBrainz::INC_RATINGS;
    const USER_TAGS     = Munk_MusicBrainz::INC_USER_TAGS;
    const USER_RATINGS  = Munk_MusicBrainz::INC_USER_RATINGS;
    
    /**
     * 
     * @var array
     */
    protected $_data = array(
        self::ALIASES       => null,
        self::ARTIST_RELS   => null,
        self::LABEL_RELS    => null,
        self::RELEASE_RELS  => null,
        self::TRACK_RELS    => null,
        self::URL_RELS      => null,
        self::TAGS          => null,
        self::RATINGS       => null,
        self::USER_TAGS     => null,
        self::USER_RATINGS  => null,
    );
}