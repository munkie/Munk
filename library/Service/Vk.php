<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Service_Vk extends Zend_Service_Abstract
{
    /*
     * 
     */
    const FORMAT_XML  = 'xml';
    const FORMAT_JSON = 'json';
    
    const URI_VKONTAKTE = 'http://api.vkontakte.ru/api.php';
    const URI_VK        = 'http://api.vk.com/api.php';
    
    const SETTING_NOTICES     = 1;    // * +1 – пользователь разрешил отправлять ему уведомления.
    const SETTING_FRIENDS     = 2;
    const SETTING_PHOTOS      = 4;
    const SETTING_AUDIO       = 8;
    const SETTING_VIDEO       = 16;
    const SETTING_SUGGESTIONS = 32;   // * +32 – доступ к предложениям.
    const SETTING_QUESTIONS   = 64;   // * +64 – доступ к вопросам.
    const SETTING_WIKI        = 128;  // * +128 – доступ к wiki-страницам.
    const SETTING_MENU_LINK   = 256;  // * +256 – добавление ссылки на приложение в меню слева.
    const SETTING_WALL_LINK   = 512;  // * +512 – добавление ссылки на приложение для быстрой публикации на стенах пользователей.
    const SETTING_STATUS      = 1024; // * +1024 – доступ к статусам пользователя.
    const SETTING_NOTES       = 2048; //* +2048 – доступ заметкам пользователя.
    
    /**
     * 
     * @var array
     */
    protected $_appSettings = array();
    
    /**
     * 
     * @var string
     */
    protected $_apiId;
    
    /**
     * 
     * @var string
     */
    protected $_version = '2.0';
    
    /**
     * 
     * @var string
     */
    protected $_format = self::FORMAT_XML;
    
    /**
     * 
     * @var boolean
     */
    protected $_testMode = false;
    
    /**
     * 
     * @var string
     */
    protected $_secret;
    
    /**
     * 
     * @var integer
     */
    protected $_viewerId;
    
    /**
     * 
     * @var string
     */
    protected $_apiUri = self::URI_VKONTAKTE;
    
    /**
     * 
     * @var string
     */
    protected $_securedSecret;
    
    /**
     * 
     * @var Zend_Rest_Client
     */
    protected $_restClient;
    
    /**
     * 
     * @var string
     */
    protected $_namespace;
    
    /**
     * 
     * @param Zend_Config|array $options
     */
    public function __construct($options = null)
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }
        
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    /**
     * 
     * @param string $method
     * @param array  $args
     */
    public function __call($method, array $args)
    {
        // check if namespace is set
        if (null !== $this->_namespace) {
            $method = $this->_namespace . '.' . $method;
            $this->_namespace = null;
        }
        array_unshift($args, $method);
        return call_user_func_array(array($this, 'request'), $args);
    }
    
    /**
     * 
     * @param string $name
     */
    public function __get($name)
    {
        $this->_namespace = $name;
        return $this;
    }
    
    /**
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    
    /**
     * 
     * @param string $apiId
     */
    public function setApiId($apiId)
    {
        $this->_apiId = $apiId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getApiId()
    {
        return $this->_apiId;
    }
    
    /**
     * 
     * @param boolean $testMode
     */
    public function setTestMode($testMode = true)
    {
        $this->_testMode = (boolean) $testMode;
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->_testMode;
    }
    
    /**
     * 
     * @param string $format
     */
    public function setFormat($format)
    {
        switch ($format) {
            case self::FORMAT_JSON:
            case self::FORMAT_XML:
                $this->_format = $format;
                return $this;
        }
        
        throw new Munk_Service_Exception("Invalid format '$format' provided");
    }
    
    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->_format;
    }
    
    /**
     * 
     * @param integer $viewerId
     */
    public function setViewerId($viewerId)
    {
        $this->_viewerId = (int) $viewerId;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getViewerId()
    {
        return $this->_viewerId;
    }
    
    /**
     * 
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->_secret = $secret;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->_secret;
    }
    
    /**
     * 
     * @param string $version
     */
    public function setVerion($version)
    {
        $this->_version = $version;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }
    
    /**
     * 
     * @param string $apiUri
     */
    public function setApiUri($apiUri)
    {
        $this->_apiUri = $apiUri;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getApiUri()
    {
        return $this->_apiUri;
    }
    
    /**
     * 
     * @param array $settings
     * 
     * @return integer
     */
    public function getAppSettingsMask(array $settings = null)
    {
        if (null === $settings) {
            $settings = $this->getAppSettings();
        }
        return array_sum($settings);
    }
    
    /**
     * 
     * @param array $settings
     */
    public function setAppSettings(array $settings)
    {
        $this->_appSettings = array();
        return $this->addAppSettings($settings);
    }
    
    /**
     * 
     * @param array $settings
     * 
     * @return Munk_Service_Vk
     */
    public function addAppSettings(array $settings)
    {
        foreach ($settings as $set) {
            $constName = 'self::' . strtoupper('SETTING_' . $set);
            if (defined($constName)) {
                $this->_appSettings[] = constant($constName);
            // check if it is a power of 2
            } else {
                $root = sqrt((int) $set);
                if (!is_nan($root) && $root == (int) $root) {
                    $this->_appSettings[] = $root;
                }
            }
        }
        return $this;
    }
    
    /**
     * @return array
     */
    public function getAppSettings()
    {
        return $this->_appSettings;
    }
    
    /**
     * 
     * @param string $securedSecret
     */
    public function setSecuredSecret($securedSecret)
    {
        $this->_securedSecret = $securedSecret;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSecuredSecret()
    {
        return $this->_securedSecret;
    }
    
    /**
     * 
     * @param string $method
     * @param array  $params
     * @param string $httpMethod
     * 
     * @return SimpleXMLElement
     * 
     * @throws Munk_Service_Vk_Exception
     */
    public function request($method, array $params = array(), $httpMethod = 'get')
    {
        $params += array(
            'api_id' => $this->getApiId(),
            'method' => $method,
            'v'      => $this->getVersion(),
            'timestamp' => time(),
            'random'    => mt_rand(1, 100000000),
        );

        $params['sig'] = $this->_signature($params);
        
        if (true === ($testMode = $this->getTestMode())) {
            $params['test_mode'] = (int) $testMode;
        }
        
        $client = $this->_getRestClient();
        $result = $client->{'rest' . $httpMethod}('/api.php', $params);
        $result = new Zend_Rest_Client_Result($result->getBody());
        
        Zend_Wildfire_Plugin_FirePhp::send((string) Zend_Rest_Client::getHttpClient()->getLastRequest(), 'Request');
        Zend_Wildfire_Plugin_FirePhp::send((string) Zend_Rest_Client::getHttpClient()->getLastResponse()->getBody(), 'Response headers');
        Zend_Wildfire_Plugin_FirePhp::send((string) $result, 'Result');
        
        if (isset($result->response)) {
            return $result->response;
        }
        
        if (isset($result->error)) {
            throw new Munk_Service_Vk_Exception($result->error_msg, $result->error_code);
        }
        
        throw new Munk_Service_Vk_Exception('Invalid response');
    }
    
    /**
     * 
     * @param array $params
     * 
     * @return string
     */
    protected function _signature(array $params)
    {
        $str = '';
        
        ksort($params);
        foreach ($params as $key => $value) {
            $str.= $key . '=' . $value;
        }
        
        $str.= $this->getSecuredSecret();
        
        Zend_Wildfire_Plugin_FirePhp::send($str, 'signature');
        Zend_Wildfire_Plugin_FirePhp::send($params, 'params');
        
        return md5($str);
    }
    
    /**
     * @return Zend_Rest_Client
     */
    protected function _getRestClient()
    {
        if (null === $this->_restClient) {
            $this->_restClient = new Zend_Rest_Client($this->getApiUri());
        }
        return $this->_restClient;
    }
}