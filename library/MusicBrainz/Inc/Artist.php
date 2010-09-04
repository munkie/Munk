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
    
    /**
     * 
     * @var array
     */
    protected $_data = array(
        Munk_MusicBrainz::INC_ALIASES         => null,
        Munk_MusicBrainz::INC_RELEASE_GROUPS  => null,
        Munk_MusicBrainz::INC_ARTIST_RELS     => null,
        Munk_MusicBrainz::INC_LABEL_RELS      => null,
        Munk_MusicBrainz::INC_RELEASE_RELS    => null,
        Munk_MusicBrainz::INC_TRACK_RELS      => null,
        Munk_MusicBrainz::INC_URL_RELS        => null,
        Munk_MusicBrainz::INC_TAGS            => null,
        Munk_MusicBrainz::INC_RATINGS         => null,
        //Munk_MusicBrainz::INC_USER_TAGS       => null,
        //Munk_MusicBrainz::INC_USER_RATINGS    => null,
        Munk_MusicBrainz::INC_COUNTS          => null,
        Munk_MusicBrainz::INC_RELEASE_EVENTS  => null,
        Munk_MusicBrainz::INC_DISCS           => null,
        //Munk_MusicBrainz::INC_LABELS          => null,
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
     */
    public function getSa($type)
    {
        return $this->_getRelease(self::SA, $type);
    }
    
    /**
     * 
     * @param string $type
     */
    public function getVa($type)
    {
        return $this->_getRelease(self::VA, $type);
    }
    
    /**
     * 
     * @param  array|string $value
     * @return Munk_MusicBrainz_Inc_Artist
     */
    public function setSa($type, $value = true)
    {
        return $this->_setRelease(self::SA, $type, $value);
    }
    
    /**
     * 
     * @param  array|string $value
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