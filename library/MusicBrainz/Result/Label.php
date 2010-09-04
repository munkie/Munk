<?php
/**
 * 
 * @author munkie
 * 
 * @property string $name
 * @property string $mbid
 * @property string $sortname
 * @property string $country
 * @property string $labelCode
 * @property string $type
 * 
 * @property Munk_MusicBrainz_ResultSet_Alias  $aliases
 * @property Munk_MusicBrainz_ResultSet_Tag    $tags
 * @property Munk_MusicBrainz_Result_Rating    $rating
 */
class Munk_MusicBrainz_Result_Label extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'name'      => null,
        'mbid'      => null,
        'sortname'  => null,
        'country'   => null,
        'labelcode' => null,
        'type'      => null,
        // incs
        'aliases'   => null,
        'tags'      => null,
        'rating'    => null,
    );
}