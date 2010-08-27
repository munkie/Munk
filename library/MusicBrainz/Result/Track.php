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
}