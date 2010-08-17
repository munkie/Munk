<?php
/**
 * 
 * @author munkie
 *
 * @property string $id
 * @property string $name
 * @property string $gid
 * @property string $modpending
 * @property string $sortname
 * @property string $page
 * @property string $resolution
 * @property string $enddate
 * @property string $type
 * @property string $quality
 * @property string $modpending_qual
 * 
 * @property string $mbid
 * 
 */
class Munk_MusicBrainz_Result_Artist extends Munk_MusicBrainz_Result
{
    protected $_data = array(
        'id'              => null,
        'name'            => null,
        'gid'             => null,
        'modpending'      => null,
        'sortname'        => null,
        'page'            => null,
        'resolution'      => null,
        'enddate'         => null,
        'type'            => null,
        'quality'         => null,
        'modpending_qual' => null,
    );
    
    /**
     * @return string
     */
    public function getMbid()
    {
        return $this->gid;
    }
}