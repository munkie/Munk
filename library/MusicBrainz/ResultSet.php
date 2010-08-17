<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_ResultSet implements Munk_MusicBrainz_ResultSet_Interface
{
    /**
     * 
     * @var integer
     */
    protected $_position = 0;
    
    /**
     * 
     * @var array
     */
    protected $_data = array();
    
	/**
     * 
     */
    public function count()
    {
        return count($this->_data);
    }

	/**
     * 
     */
    public function current()
    {
        
    }

	/**
     * 
     */
    public function key()
    {
        return $this->_position;
    }

	/**
     * 
     */
    public function next()
    {
        
    }

	/**
     * 
     */
    public function rewind()
    {
        $this->_position = 0;
    }

	/**
     * @param integer $position
     */
    public function seek($position)
    {
        
    }

	/**
     * 
     */
    public function valid()
    {
        
    }
}