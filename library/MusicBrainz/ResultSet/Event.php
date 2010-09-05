<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_MusicBrainz_ResultSet_Event extends Munk_MusicBrainz_ResultSet_Abstract
{
    /**
     * @return Munk_MusicBrainz_Result_Event
     */
    public function findOldestEvent()
    {
        $set = $this->toArray();
        usort($set, array($this, 'dateSort'));
        return reset($set);
    }
    
    /**
     * 
     * @param $a
     * @param $b
     * 
     * @return integer
     */
    public function dateSort($a, $b)
    {
        $aDate = (string) $a->date;
        $bDate = (string) $b->date;
        if ($aDate == $bDate) {
            return 0;
        } else if ($aDate > $bDate) {
            return 1;
        } else {
            return -1;
        }
    }
}