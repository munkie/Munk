<?php
/**
 * 
 * @author munkie
 * 
 * @property string $mbid
 * @property string $title
 * @property string $type
 */
class Munk_MusicBrainz_Result_ReleaseGroup extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'mbid'  => null,
        'title' => null,
        'type'  => null,
    );
}