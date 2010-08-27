<?php

class Munk_MusicBrainz_Adapter_Rest_Mapper_Track extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_TRACK;
    
    /**
     * 
     * @var string
     */
    protected $_resultXPath = '/metadata/track';
    
    /**
     * 
     * @var string
     */
    protected $_resultSetXPath = '/metadata/track-list/track';
    
    /**
     * 
     * @var string
     */
    protected $_resultTag = 'track';
    
    /**
     * 
     * @var string
     */
    protected $_resultSetTag = 'track-list';    
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'mbid'           => '/@id',
        'title'          => '/title',
        'duration'       => '/duration',
    );
}