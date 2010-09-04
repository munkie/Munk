<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Relation extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_RELATION;
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'type'   => '/@type',
        'target' => '/@target',
        'begin'  => '/@begin',
        'end'    => '/@end', 
    );
}