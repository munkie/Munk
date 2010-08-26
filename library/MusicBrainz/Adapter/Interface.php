<?php
/**
 * 
 * @author munkie
 *
 */
interface Munk_MusicBrainz_Adapter_Interface
{
    public function getArtist($mbid, $inc = null);
    
    public function searchArtists($query = null, $inc = null, $limit = null, $offset = null);
    
    public function getReleaseGroup($mbid, $inc = null);
    
    public function searchReleaseGroups($query = null, $inc = null, $limit = null, $offset = null);
    
    public function getRelease($mbid, $inc = null);
    
    public function searchReleases($query = null, $inc = null, $limit = null, $offset = null);
    
    public function getTrack($mbid, $inc = null);
    
    public function searchTracks($query = null, $inc = null, $limit = null, $offset = null);
    
    public function getLabel($mbid, $inc = null);
    
    public function searchLabels($query = null, $inc = null, $limit = null, $offset = null);
}