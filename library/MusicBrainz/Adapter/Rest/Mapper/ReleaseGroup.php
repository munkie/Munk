<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_ReleaseGroup extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_RELEASE_GROUP;
    
    /**
     * 
     * @var string
     */
    protected $_resultXPath = '/metadata/release-group';
    
    /**
     * 
     * @var string
     */
    protected $_resultSetXPath = '/metadata/release-group-list/release-group';
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'mbid'  => '/@id',
        'type'  => '/@type',
        'title' => '/title', 
    );
}