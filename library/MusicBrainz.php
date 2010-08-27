<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz
{
    /*
     * Entity types
     */
    const TYPE_ARTIST = 'Artist';
    const TYPE_RELEASE_GROUP = 'ReleaseGroup';
    const TYPE_RELEASE = 'Release';
    const TYPE_TRACK = 'Track';
    const TYPE_LABEL = 'Label';
    
    /**
     * 
     * @var incs
     */
    const INC_ALIASES = 'aliases';
    const INC_RELEASE_GROUPS = 'release-groups';
    const INC_SA = 'sa';
    const INC_VA = 'va';
    const INC_ARTIST_RELS = 'artist-rels';
    const INC_LABEL_RELS = 'label-rels';
    const INC_RELEASE_RELS = 'release-rels';
    const INC_TRACK_RELS = 'track-rels';
    const INC_URL_RELS = 'url-rels';
    const INC_TAGS = 'tags';
    const INC_RATINGS = 'ratings';
    const INC_USER_TAGS = 'user-tags';
    const INC_USER_RATINGS = 'user-ratings';
    const INC_COUNTS = 'counts';
    const INC_RELEASE_EVENTS = 'release-events';
    const INC_DISCS = 'discs';
    const INC_LABELS = 'labels';
    const INC_ARTIST = 'artist';
    const INC_TRACKS = 'tracks';
    const INC_TRACK_LEVEL_RELS = 'track-level-rels';
    const INC_ISRCS = 'isrcs';
 
    /*
     * Artist types
     */
    const ARTIST_TYPE_UNKNOWN    = 'Unknown';
    const ARTIST_TYPE_PERSON     = 'Person';
    const ARTIST_TYPE_GROUP      = 'Group';
    
    /*
     * Release types
     */
    const RELEASE_TYPE_ALBUM = 'Album'; // An album, perhaps better defined as a "Long Play" (LP) release, generally consists of previously unreleased material. This includes release re-issues, with or without bonus tracks.
    const RELEASE_TYPE_SINGLE = 'Single'; // A single typically has one main song and possibly a handful of additional tracks or remixes of the main track. A single is usually named after its main song. A single has different definitions in different markets, so if you are unsure please check the ReleaseAttributes page.
    const RELEASE_TYPE_EP = 'EP'; // An EP is a so-called "Extended Play" release and often contains the letters EP in the title.
    const RELEASE_TYPE_COMPILATION = 'Compilation'; // A compilation is a collection of previously released tracks by one or more artists. Please note that this is a simplified description of a compilation. If you are unsure, please refer to the full description on the ReleaseTypes page.
    const RELEASE_TYPE_SOUNDTRACK = 'Soundtrack'; // A soundtrack is the musical score to a movie, TV series, stage show, computer game etc.
    const RELEASE_TYPE_SPOKENWORD = 'Spokenword'; // Non-music spoken word releases.
    const RELEASE_TYPE_INTERVIEW = 'Interview'; // An interview release contains an interview, generally with an Artist.
    const RELEASE_TYPE_AUDIOBOOK = 'Audiobook'; // An audiobook is a book read by a narrator without music.
    const RELEASE_TYPE_LIVE = 'Live'; // A release that was recorded live.
    const RELEASE_TYPE_REMIX = 'Remix'; // A release that primarily contains remixed material.
    const RELEASE_TYPE_OTHER = 'Other'; // Any release that does not fit or can't decisively be placed in any of the categories above.

    /*
     * Release statuses
     */
    const RELEASE_STATUS_OFFICIAL = 'Official'; // Any release officially sanctioned by the artist and/or their record company. (Most releases will fit into this category.)
    const RELEASE_STATUS_PROMOTION = 'Promotion'; // A giveaway release or a release intended to promote an upcoming official release. (e.g. prerelease albums or releases included with a magazine, versions supplied to radio DJs for air-play, etc).
    const RELEASE_STATUS_BOOTLEG = 'Bootleg'; // An unofficial/underground release that was not sanctioned by the artist and/or the record company.
    const RELEASE_STATUS_PSEUDO_RELEASE = 'Pseudo-Release'; // A pseudo-release is a duplicate release for translation/transliteration purposes that does not appear on an actual release as described on 
    
    /**
     * 
     * @param mixed $adapter
     * @param mixed $config
     * 
     * @return Munk_MusicBrainz_Adapter_Interface
     */
    static public function factory($adapter, $config = array())
    {
        $adapterName = $adapter;
        $adapterNamespace = 'Munk_MusicBrainz_Adapter';
        $adapterClass = rtrim($adapterNamespace, '_') . '_' . $adapterName;
        return new $adapterClass($config);
    }
}