<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Service_Lastfm extends Zend_Service_Abstract
{
    const PLAYLIST_PROTOCOL = 'lastfm://playlist/';
    
    /**
     * 
     * @var string
     */
    protected $_apiUrl = 'http://ws.audioscrobbler.com/2.0/';
    
    /**
     * 
     * @var unknown_type
     */
    protected $_format = 'json';
    
    /**
     * @var string
     */
    protected $_apiKey;
    
    /**
     * Methods namespaces
     * 
     * @var array
     */
    protected $_namespaces = array(
        'album',
        'artist',
        'auth',
        'event',
        'geo',
        'group',
        'library',
        'playlist',
        'radio',
        'tag',
        'tasteometer',
        'track',
        'user',
        'venue',
    );
    
    /**
     * 
     * @param $apiKey
     */
    public function __construct($apiKey = null)
    {
        if (null !== $apiKey) {
            $this->setApiKey($apiKey);
        }
    }
    
    /**
     * 
     * @param string $apiKey
     * @return Munk_Service_Lastfm
     */
    public function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->_apiKey;
    }
    
    protected function _request($method, array $params = array(), $httpMethod = Zend_Http_Client::GET)
    {
        $params += array(
            'method'  => $method,
            'api_key' => $this->getApiKey(),
            'format'  => $this->_format,
        );
        
        $client = self::getHttpClient();
        $client->setUri($this->_apiUrl)
               ->setMethod($httpMethod)
               ->setParameterGet($params);
               
        $result = $client->request();
        $json = Zend_Json::decode($result->getBody());
        
        if (isset($json['error'], $json['message'])) {
            throw new Munk_Service_Lastfm_Exception($json['message'], $json['error']);
        }
        
        return $json;
    }
    
    /**
     * 
     * @param string $method
     * @param array  $params
     * 
     * @return array
     */
    public function read($method, array $params = array())
    {
        return $this->_request($method, $params, Zend_Http_Client::GET);
    }
    
    /**
     * 
     * @param $method
     * @param $params
     * 
     * @return array
     */
    public function write($method, array $params = array())
    {
        return $this->_request($method, $params, Zend_Http_Client::POST);
    }
    
    /*
     * 
     */
    
    /**
     * 
     * @param string $name
     * @param array  $args
     * 
     * @return unknown
     * 
     * @throws Munk_Service_Lastfm_Exception
     */
    public function __call($name, $args)
    {
        foreach ($this->_namespaces as $namespace) {
            if (0 === strpos($name, $namespace)) {
                $command = substr($name, strlen($namespace) - 1);
                // lcfirst for php < 5.3
                $command[0] = strtolower($command[0]);
                $method = "$namespace.$command";
                if (null === $args[0] || is_array($args[0])) {
                    if (isset($args[1]) && true === $args[0]) {
                        return $this->write($method, $args[0]);
                    } else {
                        return $this->read($method, $args[0]);    
                    }
                } else if (!is_array($args[0])) {
                    throw new Munk_Service_Lastfm_Exception('Params must be array or null');
                }
            }
        }
        
        throw new Munk_Service_Lastfm_Exception("Method $name is invalid");
    }
    
    /**
     * 
     * @param $artist
     * @param $limit
     * @param $page
     * 
     * @return array
     */
    public function artistSearch($artist, $limit = null, $page = null)
    {
        $params = array(
            'artist' => (string) $artist,
            'limit'  => $limit,
            'page'   => $page,
        );
        return $this->read('artist.search', $params);
    }
    
    /**
     * 
     * @param string $artist
     * @param string $mbid
     * @param string $username
     * @param string $lang
     * 
     * @return array
     */
    public function artistGetInfo($artist = null, $mbid = null, $username = null, $lang = null)
    {
        $params = array(
            'artist'   => $artist,
            'mbid'     => $mbid,
            'username' => $username,
            'lang'     => $lang,
        );
        
        if (null === $params['artist'] && null === $params['mbid']) {
            throw new Munk_Service_Lastfm_Exception('artist or mbid param must be provided');
        }
        
        $params = array_filter($params);
        
        return $this->read('artist.getInfo',$params);
    }
    
    /**
     * 
     * @param  string $artist
     * @return array
     */
    public function artistGetTopAlbums($artist)
    {
        $params = array(
            'artist' => $artist,
        );
        return $this->read('artist.getTopAlbums', $params);
    }
    
    /**
     * 
     * @param string  $album
     * @param integer $limit
     * @param integer $page
     * 
     * @return array
     */
    public function albumSearch($album, $limit = null, $page = null)
    {
        $params = array(
            'album'  => (string) $album,
            'limit'  => $limit,
            'page'   => $page,
        );
        return $this->read('album.search', $params);        
    }
    
    /**
     * 
     * @param string $album
     * @param string $artist
     * @param string $mbid
     * @param string $username
     * @param string $lang
     * 
     * @return array
     */
    public function albumGetInfo($album, $artist = null, $mbid = null, $username = null, $lang = null)
    {
        $params = array(
            'album'    => $album,
            'artist'   => $artist,
            'mbid'     => $mbid,
            'username' => $username,
            'lang'     => $lang,
        );
        $params = array_filter($params);
        return $this->read('album.getInfo', $params);
    }
    
    /**
     * 
     * @param string $playlistURL
     * @return array
     */
    public function playlistFetch($playlistURL)
    {
        if (0 !== strpos($playlistURL, self::PLAYLIST_PROTOCOL)) {
            $playlistURL = self::PLAYLIST_PROTOCOL . $playlistURL;
        }
        $params = array(
            'playlistURL' => $playlistURL,
        );
        return $this->read('playlist.fetch', $params);
    }
    
    /**
     * 
     * @param integer $albumId
     * @return array
     */
    public function playlistFetchByAlbumId($albumId)
    {
        return $this->playlistFetch(self::PLAYLIST_PROTOCOL . 'album/' . $albumId);
    }
    
    /**
     * 
     * @param string $tag
     * @return array
     */
    public function playlistFetchByTag($tag)
    {
        return $this->playlistFetch(self::PLAYLIST_PROTOCOL . 'tag/' . $tag . '/freetracks');
    }
}