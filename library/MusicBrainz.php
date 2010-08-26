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
    const INC_SA = 'sa-';
    const INC_VA = 'va-';
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