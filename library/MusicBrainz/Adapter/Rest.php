<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest extends Munk_MusicBrainz_Adapter_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_restUrl = 'http://musicbrainz.org/ws/1';
    
    /**
     * 
     * @var string
     */
    protected $_type = 'xml';
    
    /**
     * 
     * @var array
     */
    protected $_resources = array(
        Munk_MusicBrainz::TYPE_ARTIST        => 'artist',
        Munk_MusicBrainz::TYPE_RELEASE_GROUP => 'release-group',
        Munk_MusicBrainz::TYPE_RELEASE       => 'release',
        Munk_MusicBrainz::TYPE_TRACK         => 'track',
        Munk_MusicBrainz::TYPE_LABEL         => 'label',
    );
    
    /**
     * 
     * @param string $type
     * @return string
     * 
     * @throws Munk_MusicBrainz_Exception
     */
    protected function _makeResource($type, $mbid = null)
    {
        if (!isset($this->_resources[$type])) {
            throw new Munk_MusicBrainz_Exception("Resource for type: $type not found");
        }
        $resource = '/' . $this->_resources[$type] . '/';
        if (null !== $mbid) {
            $resource.= $mbid . '/';
        }
        return $resource;
    }
    
    /**
     * 
     * @param string $type
     * @param Munk_MusicBrainz_Filter_Abstract $filter
     */
    protected function _requestCollection($type, Munk_MusicBrainz_Filter_Abstract $filter)
    {
        $resource = $this->_makeResource($type);
        
        $params = $filter->toArray(true);
        $params['type'] = $this->_type;
        
        $response = $this->_request($resource, $params);
    }
    
    protected function _requestResource($type, $mbid, Munk_MusicBrainz_Inc_Abstract $inc)
    {
        $resource = $this->_makeResource($type, $mbid);
        
        $params = array(
            'type' => $this->_type,
            'inc'  => (string) $inc,
        );
        
        $response = $this->_request($resource, $params);
        
    }
    
    /**
     * 
     * @param string $type
     * @param array $params
     * @param string $mbid
     * 
     * @return Zend_Rest_Client_Result
     */
    protected function _request($resource, array $params, $method = 'Get')
    {
        $restClient = $this->getRestClient();
        $restClient->getHttpClient()->resetParameters();
        $method = 'rest' . $method;
        $response = $restClient->$method($resource, $params);
        
        return $response;
    }
    
    /**
     * @return Zend_Rest_Client
     */
    public function getRestClient()
    {
        if (null === $this->_restClient) {
            $this->_restClient = new Zend_Rest_Client($this->_restUrl);
        }

        return $this->_restClient;
    }
    
    /**
     * 
     * @param Zend_Rest_Client $restClient
     */
    public function setRestClient(Zend_Rest_Client $restClient)
    {
        $this->_restClient = $restClient;
    }
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    protected function _getArtist($mbid, Munk_MusicBrainz_Inc_Artist $inc)
    {
        return $this->_requestResource(Munk_MusicBrainz::TYPE_ARTIST, $mbid, $inc);
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Artist $filter
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    protected function _searchArtists(Munk_MusicBrainz_Filter_Artist $filter)
    {
        return $this->_requestCollection(Munk_MusicBrainz::TYPE_ARTIST, $filter);
    }
}