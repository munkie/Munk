<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Inc_Track extends Munk_MusicBrainz_Inc_Abstract
{
    /**
     * 
     * @var const
     */
    const ARTIST        = Munk_MusicBrainz::INC_ARTIST;
    const RELEASE       = Munk_MusicBrainz::INC_RELEASE;
    const PUIDS         = Munk_MusicBrainz::INC_PUIDS;
    const ARTIST_RELS   = Munk_MusicBrainz::INC_ARTIST_RELS;
    const LABEL_RELS    = Munk_MusicBrainz::INC_LABEL_RELS;
    const RELEASE_RELS  = Munk_MusicBrainz::INC_RELEASE_RELS;
    const URL_RELS      = Munk_MusicBrainz::INC_URL_RELS;
    const TAGS          = Munk_MusicBrainz::INC_TAGS;
    const RATINGS       = Munk_MusicBrainz::INC_RATINGS;
    const USER_TAGS     = Munk_MusicBrainz::INC_USER_TAGS;
    const USER_RATINGS  = Munk_MusicBrainz::INC_USER_RATINGS;
    const ISRCS         = Munk_MusicBrainz::INC_ISRCS;
            
    /**
     * 
     * @var array
     */
    protected $_data = array(
        self::ARTIST        => null,
        self::RELEASE       => null,
        self::PUIDS         => null,
        self::ARTIST_RELS   => null,
        self::LABEL_RELS    => null,
        self::RELEASE_RELS  => null,
        self::URL_RELS      => null,
        self::TAGS          => null,
        self::RATINGS       => null,
        self::USER_TAGS     => null,
        self::USER_RATINGS  => null,
        self::ISRCS         => null,
    );
}