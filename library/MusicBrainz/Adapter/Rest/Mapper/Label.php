<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Label extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_LABEL;
    
    /**
     * 
     * @var string
     */
    protected $_resultXPath = '/metadata/label';
    
    /**
     * 
     * @var string
     */
    protected $_resultSetXPath = '/metadata/label-list/label';
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'mbid'      => '/@id',
        'type'      => '/@type',
        'name'      => '/name',
        'sortname'  => '/sort-name',
        'labelCode' => '/label-code',
        'country'   => '/country',
        // incs
        'aliases'   => array('xpath' => '/alias-list/alias', 'relResultSet' => Munk_MusicBrainz::TYPE_ALIAS),
        'tags'      => array('xpath' => '/tag-list/tag', 'relResultSet' => Munk_MusicBrainz::TYPE_TAG),
        'rating'    => array('xpath' => '/rating', 'relResult' => Munk_MusicBrainz::TYPE_RATING),  
    );
}