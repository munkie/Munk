<?php
/**
 * 
 * @author munkie
 *
 * @property string $name
 * 
 * @method string getName()
 * @method Munk_MusicBrainz_Filter_Artist setName($name)
 * @method boolean issetName()
 * @method Munk_MusicBrainz_Filter_Artist unsetName()
 */
class Munk_MusicBrainz_Filter_Artist extends Munk_MusicBrainz_Filter_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'name' => null,
    );
}