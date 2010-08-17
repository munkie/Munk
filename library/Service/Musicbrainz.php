<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Service_Musicbrainz extends Zend_Service_Abstract
{
    /**
     * 
     * @var string
     */
    protected $_restUrl = 'http://musicbrainz.org/ws/1/';
    
    /**
     * 
     * @var string
     */
    protected $_type = 'xml';
}