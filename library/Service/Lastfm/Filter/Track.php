<?php

class Munk_Service_Lastfm_Filter_Track implements Zend_Filter_Interface
{
    protected $_patterns = array(
        //array('/[^\w ]/', '')
    );
    
	/**
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        foreach ($this->_patterns as $p) {
            list($pattern, $replacement) = $p;
            $value = preg_replace($pattern, $replacement, $value);
        }
        return $value;
    }
}