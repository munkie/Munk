<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_Result_Abstract extends Munk_Util_DataObject_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_exceptionClass = 'Munk_MusicBrainz_Result_Exception';
    
    /**
     * 
     * @param string $type
     * @param mixed  $data
     * 
     * @return Munk_MusicBrainz_Result_Abstract
     */
    static public function factory($type, $data = null)
    {
        $class = 'Munk_MusicBrainz_Result_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Exception("Invalid type: $type. Class $class does not exist");
        }
        return new $class($data);
    }
}