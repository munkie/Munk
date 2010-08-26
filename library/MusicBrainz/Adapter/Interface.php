<?php
/**
 * 
 * @author munkie
 *
 */
interface Munk_MusicBrainz_Adapter_Interface
{
    public function getArtist($mbid, $inc = null);
    
    public function searchArtists($query = null, $limit = null, $offset = null);
    /*
    public function getReleaseGroup($mbid, $inc = null);
    
    public function searchReleaseGroups($query = null, $limit = null, $offset = null);
    
    public function getRelease($mbid, $inc = null);
    
    public function searchReleases($query = null, $limit = null, $offset = null);
    
    public function getTrack($mbid, $inc = null);
    
    public function searchTracks($query = null, $limit = null, $offset = null);
    
    public function getLabel($mbid, $inc = null);
    
    public function searchLabels($query = null, $limit = null, $offset = null);
    */
}