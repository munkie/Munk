<?php
/**
 * 
 * @author munkie
 *
 */
interface Munk_MusicBrainz_Adapter_Interface
{
    public function getArtist($mbid, $inc = null);
    
    public function searchArtists($query, $limit = null, $inc = null);
    
    public function getReleaseGroup($mbid, $inc = null);
    
    public function searchReleaseGroups($query = null, $limit = null, $inc = null);
    
    public function getRelease($mbid, $inc = null);
    
    public function searchReleases($query, $limit = null, $inc = null);
    
    public function getTrack($mbid, $inc = null);
    
    public function searchTracks($query, $limit = null, $inc = null);
    
    public function getLabel($mbid, $inc = null);
    
    public function searchLabels($query, $limit = null, $inc = null);
}