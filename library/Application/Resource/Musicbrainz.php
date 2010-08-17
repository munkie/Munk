<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Application_Resource_Musicbrainz extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * 
     * @var Munk_MusicBrainz
     */
    protected $_musicbrainz;
    
    /**
     * @return Munk_MusicBrainz
     */
    public function getMusicBrainz()
    {
        if (null === $this->_musicbrainz) {
            $this->_musicbrainz = new Munk_MusicBrainz($this->getOptions());
        }
        return $this->_musicbrainz;
    }
    
    /**
     * @return Munk_MusicBrainz
     */
    public function init()
    {
        return $this->getMusicBrainz();
    }
}