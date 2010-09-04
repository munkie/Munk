<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest implements Munk_MusicBrainz_Adapter_Interface
{
    /**
     * 
     * @var Zend_Rest_Client
     */
    protected $_restClient;
    
    /**
     * 
     * @var string
     */
    protected $_uri = 'http://musicbrainz.org/';
    
    /**
     * 
     * @var string
     */
    protected $_uriNamespace = '/ws/1/';
    
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
     * @throws Munk_MusicBrainz_Adapter_Rest_Exception
     */
    protected function _makeResource($type, $mbid = null)
    {
        if (!isset($this->_resources[$type])) {
            throw new Munk_MusicBrainz_Adapter_Rest_Exception("Resource for type: $type not found");
        }
        $resource = $this->_uriNamespace . $this->_resources[$type] . '/';
        if (null !== $mbid) {
            $resource.= $mbid . '/';
        }
        return $resource;
    }
    
    /**
     * 
     * @param string $type
     * @param Munk_MusicBrainz_Filter_Abstract $filter
     * 
     * @return SimpleXMLElement
     */
    protected function _requestCollection($type, Munk_MusicBrainz_Filter_Abstract $filter)
    {
        $resource = $this->_makeResource($type);
        
        $params = $filter->toArray(true);
        $params['type'] = $this->_type;
        
        return $this->_request($resource, $params);
    }
    
    /**
     * 
     * @param string $type
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Abstract $inc
     * 
     * @return SimpleXMLElement
     */
    protected function _requestResource($type, $mbid, Munk_MusicBrainz_Inc_Abstract $inc)
    {
        $resource = $this->_makeResource($type, $mbid);
        
        $params = array(
            'type' => $this->_type,
            'inc'  => (string) $inc,
        );
        
        return $this->_request($resource, $params);
    }
    
    /**
     * 
     * @param string $type
     * @param array $params
     * @param string $mbid
     * 
     * @return SimpleXMLElement
     * 
     * @throws Munk_MusicBrainz_Adapter_Rest_Exception
     */
    protected function _request($resource, array $params, $method = 'get')
    {
        $restClient = $this->getRestClient();
        $restClient->getHttpClient()->resetParameters();
        $method = 'rest' . $method;
        /* @var $response Zend_Http_Response */
        $response = $restClient->$method($resource, $params);
        
        if ($response->isError()) {
            throw new Munk_MusicBrainz_Adapter_Rest_Exception($response->getMessage(), $response->getStatus());
        }
        
        $body = $response->getBody();
        $body = str_replace(' xmlns="http://musicbrainz.org/ns/mmd-1.0#"', '', $body);
        return simplexml_load_string($body);
    }
    
    /**
     * @return Zend_Rest_Client
     */
    public function getRestClient()
    {
        if (null === $this->_restClient) {
            $this->_restClient = new Zend_Rest_Client($this->_uri);
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
    public function getArtist($mbid, Munk_MusicBrainz_Inc_Artist $inc)
    {
        $response = $this->_requestResource(Munk_MusicBrainz::TYPE_ARTIST, $mbid, $inc);
        $mapper = new Munk_MusicBrainz_Adapter_Rest_Mapper_Artist($response);
        return $mapper->getResult();
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Artist $filter
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtists(Munk_MusicBrainz_Filter_Artist $filter)
    {
        $response = $this->_requestCollection(Munk_MusicBrainz::TYPE_ARTIST, $filter);
        $mapper = new Munk_MusicBrainz_Adapter_Rest_Mapper_Artist($response);
        return $mapper->getResultSet();
    }
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Release $inc
     * 
     * @return Munk_MusicBrainz_Result_Release
     */
    public function getRelease($mbid, Munk_MusicBrainz_Inc_Release $inc)
    {
        $response = $this->_requestResource(Munk_MusicBrainz::TYPE_RELEASE, $mbid, $inc);
        $mapper = new Munk_MusicBrainz_Adapter_Rest_Mapper_Release($response);
        return $mapper->getResult();
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Artist $filter
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchReleases(Munk_MusicBrainz_Filter_Release $filter)
    {
        $response = $this->_requestCollection(Munk_MusicBrainz::TYPE_RELEASE, $filter);
        $mapper = new Munk_MusicBrainz_Adapter_Rest_Mapper_Release($response);
        return $mapper->getResultSet();
    }
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Track $inc
     * 
     * @return Munk_MusicBrainz_Result_Track
     */
    public function getTrack($mbid, Munk_MusicBrainz_Inc_Track $inc)
    {
        $response = $this->_requestResource(Munk_MusicBrainz::TYPE_TRACK, $mbid, $inc);
        $mapper = new Munk_MusicBrainz_Adapter_Rest_Mapper_Track($response);
        return $mapper->getResult();
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Track $filter
     * @param Munk_MusicBrainz_Inc_Track $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchTracks(Munk_MusicBrainz_Filter_Track $filter)
    {
        $response = $this->_requestCollection(Munk_MusicBrainz::TYPE_TRACK, $filter);
        $mapper = new Munk_MusicBrainz_Adapter_Rest_Mapper_Track($response);
        return $mapper->getResultSet();
    }
}