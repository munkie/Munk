<?php
/**
 * 
 * @author munkie
 * 
 * @property string $date
 */
class Munk_MusicBrainz_Result_Event extends Munk_MusicBrainz_Result_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'date'          => null,
        'country'       => null,
        'catalognumber' => null,
        'barcode'       => null,
        'format'        => null,
        // inc
        'label'         => null,
    );
}