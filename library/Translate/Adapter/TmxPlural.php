<?php

/** Zend_Locale */
require_once 'Zend/Locale.php';

/** Zend_Translate_Adapter */
require_once 'Zend/Translate/Adapter.php';


/**
 * @category   Munk
 * @package    Munk_Translate
 */
class Munk_Translate_Adapter_TmxPlural extends Zend_Translate_Adapter {
    // Internal variables
    protected $_file    = false;
    protected $_tu      = null;
    protected $_tuv     = null;
    protected $_seg     = null;
    protected $_content = null;
    protected $_data    = array();
    
    /**
     * True if tu datatype is "plural"
     * 
     * @var boolean
     */
    protected $_tuPlural;
    
    /**
     * Plural form of tuv
     * 
     * @var integer
     */
    protected $_tuvPluralForm;

    /**
     * Load translation data (TMX file reader)
     *
     * @param  string  $filename  TMX file to add, full path must be given for access
     * @param  string  $locale    Locale has no effect for TMX because TMX defines all languages within
     *                            the source file
     * @param  array   $option    OPTIONAL Options to use
     * @throws Zend_Translation_Exception
     * @return array
     */
    protected function _loadTranslationData($filename, $locale, array $options = array())
    {
        $this->_data = array();
        if (!is_readable($filename)) {
            require_once 'Zend/Translate/Exception.php';
            throw new Zend_Translate_Exception('Translation file \'' . $filename . '\' is not readable.');
        }

        $encoding = $this->_findEncoding($filename);
        $this->_file = xml_parser_create($encoding);
        xml_set_object($this->_file, $this);
        xml_parser_set_option($this->_file, XML_OPTION_CASE_FOLDING, 0);
        xml_set_element_handler($this->_file, "_startElement", "_endElement");
        xml_set_character_data_handler($this->_file, "_contentElement");

        if (!xml_parse($this->_file, file_get_contents($filename))) {
            $ex = sprintf('XML error: %s at line %d',
                          xml_error_string(xml_get_error_code($this->_file)),
                          xml_get_current_line_number($this->_file));
            xml_parser_free($this->_file);
            require_once 'Zend/Translate/Exception.php';
            throw new Zend_Translate_Exception($ex);
        }

        return $this->_data;
    }

	protected function _startElement($file, $name, $attrib)
    {
        if ($this->_seg !== null) {
            $this->_content .= "<".$name;
            foreach($attrib as $key => $value) {
                $this->_content .= " $key=\"$value\"";
            }
            $this->_content .= ">";
        } else {
            switch(strtolower($name)) {
                case 'tu':
                    if (isset($attrib['tuid']) === true) {
                        $this->_tu = $attrib['tuid'];
                    }
                    if (isset($attrib['datatype']) && $attrib['datatype'] == 'plural') {
                    	$this->_tuPlural = true;
                    }
                    break;
                case 'tuv':
                    if (isset($attrib['xml:lang']) === true) {
                        $this->_tuv = $attrib['xml:lang'];
                        if (isset($this->_data[$this->_tuv]) === false) {
                            $this->_data[$this->_tuv] = array();
                        }
                        if (true === $this->_tuPlural && isset($attrib['plural-form'])) {
                        	$this->_tuvPluralForm = $attrib['plural-form'];
                        }
                    }
                    break;
                case 'seg':
                    $this->_seg     = true;
                    $this->_content = null;
                    break;
                default:
                    break;
            }
        }
    }

    protected function _endElement($file, $name)
    {
        if (($this->_seg !== null) and ($name !== 'seg')) {
            $this->_content .= "</".$name.">";
        } else {
            switch (strtolower($name)) {
                case 'tu':
                    $this->_tu = null;
                    $this->_tuPlural = null;
                    break;
                case 'tuv':
                    $this->_tuv = null;
                    $this->_tuvPluralForm = null;
                    break;
                case 'seg':
                    $this->_seg = null;                    
                    if (!empty($this->_content) or (!isset($this->_data[$this->_tuv][$this->_tu]))) {
                    	if (true === $this->_tuPlural) {
                    		if (null !== $this->_tuvPluralForm) {
                    			$this->_data[$this->_tuv][$this->_tu][$this->_tuvPluralForm] = $this->_content;
                    		}
                    	} else {
                        	$this->_data[$this->_tuv][$this->_tu] = $this->_content;
                    	}
                    }
                    break;
                default:
                    break;
            }
        }
    }

    protected function _contentElement($file, $data)
    {
        if (($this->_seg !== null) and ($this->_tu !== null) and ($this->_tuv !== null)) {
            $this->_content .= $data;
        }
    }

    protected function _findEncoding($filename)
    {
        $file = file_get_contents($filename, null, null, 0, 100);
        if (strpos($file, "encoding") !== false) {
            $encoding = substr($file, strpos($file, "encoding") + 9);
            $encoding = substr($encoding, 1, strpos($encoding, $encoding[0], 1) - 1);
            return $encoding;
        }
        return 'UTF-8';
    }

    /**
     * Returns the adapter name
     *
     * @return string
     */
    public function toString()
    {
        return "TmxPlural";
    }
}
