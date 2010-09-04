<?php
/**
 * 
 * @author munkie
 * 
 * @property string  $mbid
 * @property string  $title
 * @property integer $duration
 */
class Munk_MusicBrainz_Result_Track extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'mbid' => null,
        'title' => null,
        'duration' => null,
    );
    
    public function getHours()
    {
        return (int) $this->duration / 3600000;
    }
    
    /**
     * @return integer
     */
    public function getMinutes()
    {
        return (int) ($this->duration % 3600000) / 60000;
    }
    
    /**
     * @return integer
     */
    public function getSeconds()
    {
        return (int) ($this->duration % 60000) / 1000;
    }
}