<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Inc_Artist extends Munk_MusicBrainz_Inc_Abstract
{
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
        Munk_MusicBrainz::INC_USER_TAGS       => null,
        Munk_MusicBrainz::INC_USER_RATINGS    => null,
        Munk_MusicBrainz::INC_COUNTS          => null,
        Munk_MusicBrainz::INC_RELEASE_EVENTS  => null,
        Munk_MusicBrainz::INC_DISCS           => null,
        Munk_MusicBrainz::INC_LABELS          => null,
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
        if (preg_match('/^(get|set|isset|unset)(sa|va)-?(.*)$/i', $method, $matches)) {
            $operation = strtolower($matches[1]);
            $type      = strtolower($matches[2]);
            $value     = $matches[3];
            if ('' == $value) {
                if (!isset($args[0])) {
                    throw new Munk_MusicBrainz_Inc_Exception("No value found for $type property");
                }
                $value = $args[0];
            }
            if (!is_array($value)) {
                // TODO check $value is valid release type
                $key = $type . '-' . $value;
            } else if ('set' != $operation) {
                throw new Munk_MusicBrainz_Inc_Exception("$type value must be string not array");
            }
            switch ($operation) {
                case 'get':
                    if (isset($this->_data[$key])) {
                        return true;
                    } else {
                        return null;
                    }
                    return $this;
                case 'set':
                    foreach ((array) $value as $v) {
                        $key = $type . '-' . $v;
                        $this->_data[$key] = true;
                    }
                    return $this;
                case 'isset':
                    return isset($this->_data[$key]);
                case 'unset':
                    if (array_key_exists($key, $this->_data)) {
                        unset($this->_data[$key]);
                    }
                    return $this;
            }
        }
        return parent::__call($method, $args);
    }
}