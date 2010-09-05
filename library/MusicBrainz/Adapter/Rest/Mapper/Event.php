<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Event extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_EVENT;
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'date'           => '/@date',
        'country'        => '/@country',
        'catalogNumber'  => '/@catalog-number',
        'barcode'        => '/@barcode',
        'format'         => '/@format',
        'script'         => '/text-representation/@script',
        'language'       => '/text-representation/@language',
        // incs
        'label'          => array('xpath' => '/label', 'relResult' => Munk_MusicBrainz::TYPE_LABEL),
    );
}