<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Filter_ReleaseGroup extends Munk_MusicBrainz_Filter_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'title' => null,
        'artist' => null,
        'artistid' => null,
        'releasetypes' => array(),
    );
    
    /**
     * 
     * @param array|string $types
     * 
     * @return Munk_MusicBrainz_Filter_ReleaseGroup
     */
    public function setReleaseTypes($types)
    {
        $this->_data['releasetypes'] = (array) $types;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getReleaseTypes()
    {
        $types = implode(' ', $this->_data['releasetypes']);
        if ("" !== $types) {
            return $types;
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param string $type
     * 
     * @return Munk_MusicBrainz_Filter_ReleaseGroup
     */
    public function addReleaseType($type)
    {
        if (!in_array($type, $this->_data['releasetypes'])) {
            $this->_data['releasetypes'][] = $type;
        }
        return $this;
    }
    
    /**
     * 
     * @param string $type
     * 
     * @return Munk_MusicBrainz_Filter_ReleaseGroup
     */
    public function removeReleaseType($type)
    {
        $key = array_search($type, $this->_data['releasetypes']);
        if (false !== $key) {
            unset($this->_data[$key]);
        }
        return $this;
    }
}