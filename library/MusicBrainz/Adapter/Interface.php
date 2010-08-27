<?php
/**
 * 
 * @author munkie
 *
 */
interface Munk_MusicBrainz_Adapter_Interface
{
    public function getArtist($mbid, $inc = null);
    
    public function searchArtists($filter = null, $limit = null, $offset = null);
    /*
    public function getReleaseGroup($mbid, $inc = null);
    
    public function searchReleaseGroups($filter = null, $limit = null, $offset = null);
    */
    public function getRelease($mbid, $inc = null);
    
    public function searchReleases($filter = null, $limit = null, $offset = null);
    
    public function getTrack($mbid, $inc = null);
    
    public function searchTracks($filter = null, $limit = null, $offset = null);
    /*
    public function getLabel($mbid, $inc = null);
    
    public function searchLabels($filter = null, $limit = null, $offset = null);
    */
}