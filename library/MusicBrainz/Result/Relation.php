<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_Result_Relation extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * @var array
     */
    protected $_data = array(
        'type'     => null,
        'target'   => null,
        'begin'    => null,
        'end'      => null,
        'relation' => null,
    );
}