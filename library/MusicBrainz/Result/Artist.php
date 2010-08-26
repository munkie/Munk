<?php
/**
 * 
 * @author munkie
 *
 * @property string $name
 * @property string $mbid
 * @property string $modpending
 * @property string $sortname
 * @property string $page
 * @property string $resolution
 * @property string $begindate
 * @property string $enddate
 * @property string $type
 * @property string $quality
 * @property string $modpending_qual
 * 
 * @property string $mbid
 * 
 */
class Munk_MusicBrainz_Result_Artist extends Munk_MusicBrainz_Result_Abstract
{
    protected $_data = array(
        'id'              => null,
        'name'            => null,
        'mbid'            => null,
        'modpending'      => null,
        'sortname'        => null,
        'page'            => null,
        'resolution'      => null,
        'begindate'       => null,
        'enddate'         => null,
        'type'            => null,
        'quality'         => null,
        'modpending_qual' => null,
    );
    
    /**
     * @return string
     */
    public function getGid()
    {
        return $this->mbid;
    }
}