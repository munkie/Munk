<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz
{
    /*
     * Entity types
     */
    const TYPE_ARTIST = 'Artist';
    const TYPE_RELEASE_GROUP = 'ReleaseGroup';
    const TYPE_RELEASE = 'Release';
    const TYPE_TRACK = 'Track';
    const TYPE_LABEL = 'Label';

    /**
     * 
     * @param mixed $adapter
     * @param mixed $config
     * 
     * @return Munk_MusicBrainz_Adapter_Interface
     */
    static public function factory($adapter, $config = array())
    {
        $adapterName = $adapter;
        $adapterNamespace = 'Munk_MusicBrainz_Adapter';
        $adapterClass = rtrim($adapterNamespace, '_') . '_' . $adapterName;
        return new $adapterClass($config);
    }
}