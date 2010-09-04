<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Inc_Artist extends Munk_MusicBrainz_Inc_Abstract
{
    /*
     * 
     */
    const SA = 'sa';
    const VA = 'va';
    
    /*
     * 
     */
    const ALIASES        = Munk_MusicBrainz::INC_ALIASES;
    const RELEASE_GROUPS = Munk_MusicBrainz::INC_RELEASE_GROUPS;
    const ARTIST_RELS    = Munk_MusicBrainz::INC_ARTIST_RELS;
    const LABEL_RELS     = Munk_MusicBrainz::INC_LABEL_RELS;
    const RELEASE_RELS   = Munk_MusicBrainz::INC_RELEASE_RELS;
    const TRACK_RELS     = Munk_MusicBrainz::INC_TRACK_RELS;
    const URL_RELS       = Munk_MusicBrainz::INC_URL_RELS;
    const TAGS           = Munk_MusicBrainz::INC_TAGS;
    const RATINGS        = Munk_MusicBrainz::INC_RATINGS;
    const USER_TAGS      = Munk_MusicBrainz::INC_USER_TAGS;
    const USER_RATINGS   = Munk_MusicBrainz::INC_USER_RATINGS;
    const COUNTS         = Munk_MusicBrainz::INC_COUNTS;
    const RELEASE_EVENTS = Munk_MusicBrainz::INC_RELEASE_EVENTS;
    const DISCS          = Munk_MusicBrainz::INC_DISCS;
    const LABELS         = Munk_MusicBrainz::INC_LABELS;
    
    /**
     * 
     * @var array
     */
    protected $_data = array(
        self::ALIASES         => null,
        self::RELEASE_GROUPS  => null,
        self::ARTIST_RELS     => null,
        self::LABEL_RELS      => null,
        self::RELEASE_RELS    => null,
        self::TRACK_RELS      => null,
        self::URL_RELS        => null,
        self::TAGS            => null,
        self::RATINGS         => null,
        self::USER_TAGS       => null,
        self::USER_RATINGS    => null,
        self::COUNTS          => null,
        self::RELEASE_EVENTS  => null,
        self::DISCS           => null,
        self::LABELS          => null,
    );
    
    /**
     * 
     * @var array
     */
    protected $_releases = array(
        self::SA => array(),
        self::VA => array(),
    );
    
    /**
     * 
     */
    public function init()
    {
        // when labels is set server return errors
        $this->_needsAuth[] = self::LABELS;
    }
    
    /**
     * 
     * @param string $method
     * @param array  $args
     * 
     * @return mixed 
     * 
     * @throws Munk_MusicBrainz_Inc_Exception
     */
    public function __call($method, $args)
    {
        if (preg_match('/^(get|set|isset|unset)(sa|va)-?(.+)$/i', $method, $matches)) {
            $operation = strtolower($matches[1]);
            $key       = strtolower($matches[2]);
            $type      = $matches[3];
            switch ($operation) {
                case 'get':
                    return $this->_getRelease($key, $type);
                case 'set':
                    $value = isset($args[0]) ? $args[0] : true;
                    return $this->_setRelease($key, $type, $value);
                case 'isset':
                    return parent::__call('isset' . $key, array($type));
                case 'unset':
                    return parent::__call('unset' . $key, array($type));
            }
        }
        return parent::__call($method, $args);
    }
    
    /**
     * 
     * @param string $type
     * @param string $value
     * 
     * @return true|null
     */
    protected function _getRelease($key, $type)
    {
        if (isset($this->_releases[$key][$type])) {
            return true;
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param string $key
     * @param array|string $type
     * @param mixed $value
     * 
     * @return Munk_MusicBrainz_Inc_Artist
     */
    protected function _setRelease($key, $type, $value)
    {
        $value = (true === $value) ? $value : null;
        foreach ((array) $type as $t) {
            $this->_releases[$key][$t] = $value;
        }
        return $this;
    }
    
    /**
     * 
     * @param string $type
     * 
     * @return string
     */
    public function getSa($type)
    {
        return $this->_getRelease(self::SA, $type);
    }
    
    /**
     * 
     * @param string $type
     * 
     * @return string
     */
    public function getVa($type)
    {
        return $this->_getRelease(self::VA, $type);
    }
    
    /**
     * 
     * @param  array|string $value
     * 
     * @return Munk_MusicBrainz_Inc_Artist
     */
    public function setSa($type, $value = true)
    {
        return $this->_setRelease(self::SA, $type, $value);
    }
    
    /**
     * 
     * @param  array|string $value
     * 
     * @return Munk_MusicBrainz_Inc_Artist
     */
    public function setVa($type, $value = true)
    {
        return $this->_setRelease(self::VA, $type, $value);
    }
    
    /**
     * 
     * @param boolean $filterEmptyValues
     * 
     * @return array
     */
    public function toArray($filterEmptyValues = false)
    {
        $data = parent::toArray($filterEmptyValues);
        foreach ($this->_releases as $key => $types) {
            foreach ($types as $type => $value) {
                if (true === $value) {
                    $data[$key . '-' . $type] = true;
                }
            }
        }
        return $data;
    }
}