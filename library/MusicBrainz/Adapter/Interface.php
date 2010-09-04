<?php
/**
 * 
 * @author munkie
 *
 */
interface Munk_MusicBrainz_Adapter_Interface
{
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Artist $inc
     * 
     * @return Munk_MusicBrainz_Result_Artist
     */
    public function getArtist($mbid, Munk_MusicBrainz_Inc_Artist $inc);
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Abstract $filter
     * 
     * @return Munk_MusicBrainz_ResultSet_Artist
     */
    public function searchArtists(Munk_MusicBrainz_Filter_Artist $filter);

    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_ReleaseGroup $inc
     * 
     * @return Munk_MusicBrainz_Result_ReleaseGroup
     */
    public function getReleaseGroup($mbid, Munk_MusicBrainz_Inc_ReleaseGroup $inc);

    /**
     * 
     * @param Munk_MusicBrainz_Filter_ReleaseGroup $filter
     * @return Munk_MusicBrainz_ResultSet_ReleaseGroup
     */
    public function searchReleaseGroups(Munk_MusicBrainz_Filter_ReleaseGroup $filter);
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Release $inc
     * 
     * @return Munk_MusicBrainz_Result_Release
     */
    public function getRelease($mbid, Munk_MusicBrainz_Inc_Release $inc);
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Release $filter
     * 
     * @return Munk_MusicBrainz_ResultSet_Release
     */
    public function searchReleases(Munk_MusicBrainz_Filter_Release $filter);
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Track $inc
     * 
     * @return Munk_MusicBrainz_Result_Track
     */
    public function getTrack($mbid, Munk_MusicBrainz_Inc_Track $inc);
    
    /**
     * 
     * @param Munk_MusicBrainz_Filter_Track $filter
     * 
     * @return Munk_MusicBrainz_ResultSet_Track
     */
    public function searchTracks(Munk_MusicBrainz_Filter_Track $filter);
    
    /**
     * 
     * @param string $mbid
     * @param Munk_MusicBrainz_Inc_Label $inc
     * 
     * @return Munk_MusicBrainz_Result_Label
     */
    //public function getLabel($mbid, Munk_MusicBrainz_Inc_Label $inc);

    /**
     * 
     * @param Munk_MusicBrainz_Filter_Label $filter
     * 
     * @return Munk_MusicBrainz_ResultSet_Label
     */
    //public function searchLabels(Munk_MusicBrainz_Filter_Label $filter);
}