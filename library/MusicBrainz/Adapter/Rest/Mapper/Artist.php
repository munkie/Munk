<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Artist extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_ARTIST;
    
    /**
     * 
     * @var string
     */
    protected $_resultXPath = '/metadata/artist';
    
    /**
     * 
     * @var string
     */
    protected $_resultSetXPath = '/metadata/artist-list/artist';
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'mbid'           => '/@id',
        'type'           => '/@type',
        'name'           => '/name',
        'sortname'       => '/sort-name',
        'begindate'      => '/life-span/@begin',
        'enddate'        => '/life-span/@end',
        'disambiguation' => '/disambiguation',
    
        'releases'       => array('xpath' => '/release-list/release', 'relResultSet' => Munk_MusicBrainz::TYPE_RELEASE),
        'aliases'        => array('xpath' => '/alias-list/alias', 'relResultSet' => Munk_MusicBrainz::TYPE_ALIAS),
        'tags'           => array('xpath' => '/tag-list/tag', 'relResultSet' => Munk_MusicBrainz::TYPE_TAG),
        'rating'         => array('xpath' => '/rating', 'relResult' => Munk_MusicBrainz::TYPE_RATING),
        'releaseGroups'  => array('xpath' => '/release-group-list/release-group', 'relResultSet' => Munk_MusicBrainz::TYPE_RELEASE_GROUP),
    );
}