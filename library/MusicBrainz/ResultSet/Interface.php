<?php
/**
 * 
 * @author munkie
 *
 */
interface Munk_MusicBrainz_ResultSet_Interface extends SeekableIterator, Countable
{
    /**
     * 
     * @param Munk_MusicBrainz_Result_Interface|array $result
     */
    public function addResult($result);
    
    /**
     * 
     * @param array $data
     */
    public function addResults(array $data);
    
    /**
     * 
     * @param array $data
     */
    public function setResults(array $data);
    
    /**
     * 
     */
    public function clearResults();
}