<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Adapter_Rest implements Munk_MusicBrainz_Adapter_Interface
{
    /*
     * REST request type 
     */
    const REQUEST_TYPE = 'xml';
    
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
     * @return Munk_MusicBrainz_ResultSet_Abstract
     */
    protected function _requestResultSet($type, Munk_MusicBrainz_Filter_Abstract $filter)
    {
        $resource = $this->_makeResource($type);
        
        $params = $filter->toArray(true);
        
        $response = $this->_request($resource, $params);
        $mapper = Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract::factory($type, $response);
        
        return $mapper->getResultSet();
    }
    
    /**
     * 
     * @param string $type
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Abstract $inc
     * 
     * @return Munk_MusicBrainz_Result_Abstract
     */
    protected function _requestResult($type, $mbid, Munk_MusicBrainz_Inc_Abstract $inc)
    {
        $resource = $this->_makeResource($type, $mbid);
        
        $params = array(
            'inc'  => (string) $inc,
        );
        
        $response = $this->_request($resource, $params);
        
        $mapper = Munk_MusicBrainz_Adapter_Rest_Mapper_Abstract::factory($type, $response);
        return $mapper->getResult();
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
        $params += array('type' => self::REQUEST_TYPE);
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
        return $this->_requestResult(Munk_MusicBrainz::TYPE_ARTIST, $mbid, $inc);
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
        return $this->_requestResultSet(Munk_MusicBrainz::TYPE_ARTIST, $filter);
    }
    
    /**
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_ReleaseGroup $inc
     * 
     * @return Munk_MusicBrainz_Result_ReleaseGroup
     */
    public function getReleaseGroup($mbid, Munk_MusicBrainz_Inc_ReleaseGroup $inc)
    {
        return $this->_requestResult(Munk_MusicBrainz::TYPE_RELEASE_GROUP, $mbid, $inc);
    }

    /**
     * @param Munk_MusicBrainz_Filter_ReleaseGroup $filter
     * 
     * @return Munk_MusicBrainz_ResultSet_ReleaseGroup
     */
    public function searchReleaseGroups(Munk_MusicBrainz_Filter_ReleaseGroup $filter)
    {
        return $this->_requestResultSet(Munk_MusicBrainz::TYPE_RELEASE_GROUP, $filter);
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
        return $this->_requestResult(Munk_MusicBrainz::TYPE_RELEASE, $mbid, $inc);
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
        return $this->_requestResultSet(Munk_MusicBrainz::TYPE_RELEASE, $filter);
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
        return $this->_requestResult(Munk_MusicBrainz::TYPE_TRACK, $mbid, $inc);
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
        return $this->_requestResultSet(Munk_MusicBrainz::TYPE_TRACK, $filter);
    }
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Label $inc
     * 
     * @return Munk_MusicBrainz_Result_Label
     */
    public function getLabel($mbid, Munk_MusicBrainz_Inc_Label $inc)
    {
        return $this->_requestResult(Munk_MusicBrainz::TYPE_LABEL, $mbid, $inc);
    }
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Label $filter
     * @param Munk_MusicBrainz_Inc_Track $inc
     * 
     * @return Munk_MusicBrainz_ResultSet_Label
     */
    public function searchLabels(Munk_MusicBrainz_Filter_Label $filter)
    {
        return $this->_requestResultSet(Munk_MusicBrainz::TYPE_LABEL, $filter);
    }  
}