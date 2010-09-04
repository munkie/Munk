<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Inc_Release extends Munk_MusicBrainz_Inc_Abstract
{
    /*
     * 
     */
    const COUNTS = Munk_MusicBrainz::INC_COUNTS;
    const RELEASE_EVENTS = Munk_MusicBrainz::INC_RELEASE_EVENTS;
    const DISCS = Munk_MusicBrainz::INC_DISCS;
    const RELEASE_GROUPS = Munk_MusicBrainz::INC_RELEASE_GROUPS;
    const ARTIST_RELS = Munk_MusicBrainz::INC_ARTIST_RELS;
    const LABEL_RELS = Munk_MusicBrainz::INC_LABEL_RELS;
    const RELEASE_RELS = Munk_MusicBrainz::INC_RELEASE_RELS;
    const TRACK_RELS = Munk_MusicBrainz::INC_TRACK_RELS;
    const URL_RELS = Munk_MusicBrainz::INC_URL_RELS;
    const LABELS = Munk_MusicBrainz::INC_LABELS;
    const TAGS = Munk_MusicBrainz::INC_TAGS;
    const RATINGS = Munk_MusicBrainz::INC_RATINGS;
    const USER_TAGS = Munk_MusicBrainz::INC_USER_TAGS;
    const USER_RATINGS = Munk_MusicBrainz::INC_USER_RATINGS;
    const ARTIST = Munk_MusicBrainz::INC_ARTIST;
    const TRACKS = Munk_MusicBrainz::INC_TRACKS;
    const TRACK_LEVEL_RELS = Munk_MusicBrainz::INC_TRACK_LEVEL_RELS;
    const ISRCS = Munk_MusicBrainz::INC_ISRCS;

        
    /**
     * 
     * @var array
     */
    protected $_data = array(
        self::COUNTS => null,
        self::RELEASE_EVENTS => null,
        self::DISCS => null,
        self::RELEASE_GROUPS => null,
        self::ARTIST_RELS => null,
        self::LABEL_RELS => null,
        self::RELEASE_RELS => null,
        self::TRACK_RELS => null,
        self::URL_RELS => null,
        self::LABELS => null,
        self::TAGS => null,
        self::RATINGS => null,
        //self::USER_TAGS => null,
        //self::USER_RATINGS => null,
        self::ARTIST => null,
        self::TRACKS => null,
        self::TRACK_LEVEL_RELS => null,
        self::ISRCS => null,
    );
}