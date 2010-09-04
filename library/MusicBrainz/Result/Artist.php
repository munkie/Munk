<?php
/**
 * 
 * @author munkie
 *
 * @property string $name
 * @property string $mbid
 * @property string $sortname
 * @property string $page
 * @property string $resolution
 * @property string $begindate
 * @property string $enddate
 * @property string $type
 * @property string $quality
 * @property string $disambiguation
 * 
 * @property Munk_MusicBrainz_ResultSet_Release $releases
 * 
 */
class Munk_MusicBrainz_Result_Artist extends Munk_MusicBrainz_Result_Abstract
{
    protected $_data = array(
        'name'            => null,
        'mbid'            => null,
        'sortname'        => null,
        'page'            => null,
        'resolution'      => null,
        'begindate'       => null,
        'enddate'         => null,
        'type'            => null,
        'quality'         => null,
        'disambiguation'  => null,
        // incs
        'releases'        => null,
        'aliases'         => null,
        'tags'            => null,
        'rating'          => null,
    );
    
    /**
     * @return string
     */
    public function getGid()
    {
        return $this->mbid;
    }
}