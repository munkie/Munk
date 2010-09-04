<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Tag extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_TAG;
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'name'  => '',
        'count' => '/@count' 
    );
}