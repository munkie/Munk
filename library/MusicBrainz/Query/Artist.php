<?php
/**
 * 
 * @author munkie
 *
 * @property string $name
 * 
 * @method string getName()
 * @method Munk_MusicBrainz_Query_Artist setName($name)
 * @method boolean issetName()
 * @method Munk_MusicBrainz_Query_Artist unsetName()
 */
class Munk_MusicBrainz_Query_Artist extends Munk_MusicBrainz_Query_Abstract
{
    /**
     * 
     * @var array
     */
    protected $_data = array(
        'name' => null,
    );
}