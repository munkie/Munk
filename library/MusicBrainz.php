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
    const TYPE_ARTIST        = 'Artist';
    const TYPE_RELEASE_GROUP = 'ReleaseGroup';
    const TYPE_RELEASE       = 'Release';
    const TYPE_TRACK         = 'Track';
    const TYPE_LABEL         = 'Label';
    
    const TYPE_ALIAS         = 'Alias';
    const TYPE_TAG           = 'Tag';
    
    /**
     * 
     * @var incs
     */
    const INC_ALIASES           = 'aliases';
    const INC_RELEASE_GROUPS    = 'release-groups';
    const INC_SA                = 'sa';
    const INC_VA                = 'va';
    const INC_ARTIST_RELS       = 'artist-rels';
    const INC_LABEL_RELS        = 'label-rels';
    const INC_RELEASE_RELS      = 'release-rels';
    const INC_TRACK_RELS        = 'track-rels';
    const INC_URL_RELS          = 'url-rels';
    const INC_TAGS              = 'tags';
    const INC_RATINGS           = 'ratings';
    const INC_USER_TAGS         = 'user-tags';
    const INC_USER_RATINGS      = 'user-ratings';
    const INC_COUNTS            = 'counts';
    const INC_RELEASE_EVENTS    = 'release-events';
    const INC_DISCS             = 'discs';
    const INC_LABELS            = 'labels';
    const INC_ARTIST            = 'artist';
    const INC_RELEASE           = 'release';
    const INC_TRACKS            = 'tracks';
    const INC_TRACK_LEVEL_RELS  = 'track-level-rels';
    const INC_ISRCS             = 'isrcs';
    const INC_PUIDS             = 'puids';
    
 
    /*
     * Artist types
     */
    const ARTIST_TYPE_UNKNOWN   = 'Unknown';
    const ARTIST_TYPE_PERSON    = 'Person';
    const ARTIST_TYPE_GROUP     = 'Group';
    
    /*
     * Release types
     */
    const RELEASE_TYPE_ALBUM        = 'Album'; // An album, perhaps better defined as a "Long Play" (LP) release, generally consists of previously unreleased material. This includes release re-issues, with or without bonus tracks.
    const RELEASE_TYPE_SINGLE       = 'Single'; // A single typically has one main song and possibly a handful of additional tracks or remixes of the main track. A single is usually named after its main song. A single has different definitions in different markets, so if you are unsure please check the ReleaseAttributes page.
    const RELEASE_TYPE_EP           = 'EP'; // An EP is a so-called "Extended Play" release and often contains the letters EP in the title.
    const RELEASE_TYPE_COMPILATION  = 'Compilation'; // A compilation is a collection of previously released tracks by one or more artists. Please note that this is a simplified description of a compilation. If you are unsure, please refer to the full description on the ReleaseTypes page.
    const RELEASE_TYPE_SOUNDTRACK   = 'Soundtrack'; // A soundtrack is the musical score to a movie, TV series, stage show, computer game etc.
    const RELEASE_TYPE_SPOKENWORD   = 'Spokenword'; // Non-music spoken word releases.
    const RELEASE_TYPE_INTERVIEW    = 'Interview'; // An interview release contains an interview, generally with an Artist.
    const RELEASE_TYPE_AUDIOBOOK    = 'Audiobook'; // An audiobook is a book read by a narrator without music.
    const RELEASE_TYPE_LIVE         = 'Live'; // A release that was recorded live.
    const RELEASE_TYPE_REMIX        = 'Remix'; // A release that primarily contains remixed material.
    const RELEASE_TYPE_OTHER        = 'Other'; // Any release that does not fit or can't decisively be placed in any of the categories above.

    /*
     * Release statuses
     */
    const RELEASE_STATUS_OFFICIAL       = 'Official'; // Any release officially sanctioned by the artist and/or their record company. (Most releases will fit into this category.)
    const RELEASE_STATUS_PROMOTION      = 'Promotion'; // A giveaway release or a release intended to promote an upcoming official release. (e.g. prerelease albums or releases included with a magazine, versions supplied to radio DJs for air-play, etc).
    const RELEASE_STATUS_BOOTLEG        = 'Bootleg'; // An unofficial/underground release that was not sanctioned by the artist and/or the record company.
    const RELEASE_STATUS_PSEUDO_RELEASE = 'Pseudo-Release'; // A pseudo-release is a duplicate release for translation/transliteration purposes that does not appear on an actual release as described on 
    
    /**
     * 
     * @var string
     */
    protected $_defaultAdapter = 'Rest';
    
    /**
     * 
     * @param mixed $adapter
     * @param mixed $config
     */
    public function __construct($adapter = null, $config = array())
    {
        if (null === $adapter) {
            $adapter = $this->_defaultAdapter;
        }
        $mbAdapter = self::factory($adapter, $config);
        $this->setAdapter($mbAdapter);
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Adapter_Interface $adapter
     */
    public function setAdapter(Munk_MusicBrainz_Adapter_Interface $adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }
    
    /**
     * @return Munk_MusicBrainz_Adapter_Interface
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }
    
   /**
     * 
     * @param string $type
     * @param array|Munk_MusicBrainz_Filter_Abstract $filter
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_Filter_Abstract
     * 
     * @throws Munk_MusicBrainz_Adapter_Exception
     */
    protected function _makeFilter($type, $filter = null, $limit = null, $offset = null)
    {
        if (is_array($filter) || null === $filter) {
            $filter = Munk_MusicBrainz_Filter_Abstract::factory($type, $filter);
        } else if (!$filter instanceof Munk_MusicBrainz_Filter_Abstract) {
            throw new Munk_MusicBrainz_Adapter_Exception("Invalid query object must be instance of Munk_MusicBrainz_Filter_Abstract");
        }
        
        if (null !== $limit) {
            $filter->setLimit($limit);
        }
        
        if (null !== $offset) {
            $filter->setOffset($offset);
        }
        
        return $filter;
    }
    
    /**
     * 
     * @param string $type
     * @param array|Munk_MusicBrainz_Inc_Abstract $inc
     * 
     * @return Munk_MusicBrainz_Inc_Abstract
     * 
     * @throws Munk_MusicBrainz_Adapter_Exception
     */
    protected function _makeInc($type, $inc = null)
    {
        if (is_array($inc) || null === $inc) {
            $inc = Munk_MusicBrainz_Inc_Abstract::factory($type, $inc);
        } else if (!$inc instanceof Munk_MusicBrainz_Inc_Abstract) {
            throw new Munk_MusicBrainz_Adapter_Exception("Invalid inc object must be instance of Munk_MusicBrainz_Inc_Abstract");
        }

        return $inc;
    }
    
    /**
     * 
     * @param string $mbid
     * @param mixed  $inc
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    public function getArtist($mbid, $inc = null)
    {
        $inc = $this->_makeInc(Munk_MusicBrainz::TYPE_ARTIST, $inc);
        return $this->getAdapter()->getArtist($mbid, $inc);
    }
    
    /**
     * 
     * @param mixed   $filter
     * @param mixed   $inc
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtists($filter = null, $limit = null, $offset = null)
    {
        if (is_string($filter)) {
            $filter = array('name' => $filter);
        }
        $filter = $this->_makeFilter(Munk_MusicBrainz::TYPE_ARTIST, $filter, $limit, $offset);
        return $this->getAdapter()->searchArtists($filter);
    }
    
    /**
     * 
     * @param string $mbid
     * @param mixed  $inc
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    public function getRelease($mbid, $inc = null)
    {
        $inc = $this->_makeInc(Munk_MusicBrainz::TYPE_RELEASE, $inc);
        return $this->getAdapter()->getRelease($mbid, $inc);
    }
    
    /**
     * 
     * @param mixed   $filter
     * @param mixed   $inc
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchReleases($filter = null, $limit = null, $offset = null)
    {
        if (is_string($filter)) {
            $filter = array('title' => $filter);
        }
        $filter = $this->_makeFilter(Munk_MusicBrainz::TYPE_RELEASE, $filter, $limit, $offset);
        return $this->getAdapter()->searchReleases($filter);
    }
    
    /**
     * 
     * @param string $mbid
     * @param mixed  $inc
     * 
     * @return Munk_MusicBrainz_Result_Track
     */
    public function getTrack($mbid, $inc = null)
    {
        $inc = $this->_makeInc(Munk_MusicBrainz::TYPE_TRACK, $inc);
        return $this->getAdapter()->getTrack($mbid, $inc);
    }
    
    /**
     * 
     * @param mixed   $filter
     * @param mixed   $inc
     * @param integer $limit
     * @param integer $offset
     * 
     * @return Munk_MusicBrainz_ResultSet_Track
     */
    public function searchTracks($filter = null, $limit = null, $offset = null)
    {
        if (is_string($filter)) {
            $filter = array('title' => $filter);
        }
        $filter = $this->_makeFilter(Munk_MusicBrainz::TYPE_TRACK, $filter, $limit, $offset);
        return $this->getAdapter()->searchTracks($filter);
    }
    
    /**
     * 
     * @param mixed $adapter
     * @param mixed $config
     * 
     * @return Munk_MusicBrainz_Adapter_Interface
     */
    static public function factory($adapter, $config = array())
    {
        if ($adapter instanceof Zend_Config) {
            $adapter = $adapter->toArray();
        }
        
        if (is_array($adapter)) {
            if (isset($adapter['params'])) {
                $config = $adapter->params;
            }
            if (isset($adapter['adapter'])) {
                $adapter = $adapter['adapter'];
            } else {
                $adapter = null;
            }
        }
        
        if ($config instanceof Zend_Config) {
            $config = $config->toArray();
        }
        
        if (!is_array($config)) {
            throw new Munk_MusicBrainz_Exception('Config must be array or Zend_Config');
        }
        
        if ($adapter instanceof Munk_MusicBrainz_Adapter_Interface) {
            return $adapter;
        }
        
        if (!is_string($adapter) || empty($adapter)) {
            throw new Munk_MusicBrainz_Adapter_Exception('Adapter must be string or Munk_MusicBrainz_Adapter_Interface realization');
        }
        
        /*
         * Form full adapter class name
         */
        $adapterNamespace = 'Munk_MusicBrainz_Adapter';
        if (isset($config['adapterNamespace'])) {
            if ($config['adapterNamespace'] != '') {
                $adapterNamespace = $config['adapterNamespace'];
            }
            unset($config['adapterNamespace']);
        }

        // Adapter no longer normalized- see http://framework.zend.com/issues/browse/ZF-5606
        $adapterName = $adapterNamespace . '_';
        $adapterName .= str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($adapter))));
        
        /*
         * Load the adapter class.  This throws an exception
         * if the specified class cannot be loaded.
         */
        if (!class_exists($adapterName)) {
            throw new Munk_MusicBrainz_Adapter_Exception("Class $adapterName does not exist");
        }
        
        $adapter = new $adapterName($config);
        
        if (!$adapter instanceof Munk_MusicBrainz_Adapter_Interface) {
            throw new Munk_MusicBrainz_Exception('Adapter must implement Munk_MusicBrainz_Adapter_Interface');
        }
        
        return $adapter;
    }
}