<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Rating extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_RATING;
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'value' => '/.',
        'count' => '/@votes-count' 
    );
}