<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest_Mapper_Release extends Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_type = Munk_MusicBrainz::TYPE_RELEASE;
    
    /**
     * 
     * @var string
     */
    protected $_resultXPath = '/metadata/release';
    
    /**
     * 
     * @var string
     */
    protected $_resultSetXPath = '/metadata/release-list/release';
    
    /**
     * 
     * @var array
     */
    protected $_map = array(
        'mbid'           => '/@id',
        'releasetype'    => array('xpath' => '/@type', 'callback' => '_releaseType'),
        'releasestatus'  => array('xpath' => '/@type', 'callback' => '_releaseStatus'),
        'title'          => '/title',
        'asin'           => '/asin',
        'script'         => '/text-representation/@script',
        'language'       => '/text-representation/@language',
        // incs
        'artist'         => array('xpath' => '/artist', 'relResult' => Munk_MusicBrainz::TYPE_ARTIST),
        'tracks'         => array('xpath' => '/track-list/track', 'relResultSet' => Munk_MusicBrainz::TYPE_TRACK),
        'tags'           => array('xpath' => '/tag-list/tag', 'relResultSet' => Munk_MusicBrainz::TYPE_TAG),
        'rating'         => array('xpath' => '/rating', 'relResult' => Munk_MusicBrainz::TYPE_RATING),
        'releaseGroup'   => array('xpath' => '/release-group', 'relResult' => Munk_MusicBrainz::TYPE_RELEASE_GROUP),
    );
    
    /**
     * 
     * @param SimpleXMLElement $value
     * @return string
     */
    protected function _releaseType(SimpleXMLElement $value)
    {
        return $this->_release($value, 0);
    }
    
    /**
     * 
     * @param SimpleXMLElement $value
     * @return string
     */
    protected function _releaseStatus(SimpleXMLElement $value)
    {
        return $this->_release($value, 1);
    }
    
    /**
     * 
     * @param SimpleXMLElement $value
     * @param int $pos
     * @return string
     */
    protected function _release(SimpleXMLElement $value, $pos)
    {
        $types = explode(' ', (string) $value);
        if (isset($types[$pos])) {
            return $types[$pos];
        }        
    }
}