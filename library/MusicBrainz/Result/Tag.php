<?php
/**
 * 
 * @author munkie
 * 
 * @property string  $name
 * @property integer $count 
 */
class Munk_MusicBrainz_Result_Tag extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'name'  => null,
        'count' => null,
    );
}