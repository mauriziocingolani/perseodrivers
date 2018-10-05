<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che espone metodi statici con utility varie.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitHelpers {

    /**
     * Convente un numero di minuti nel formato leggibile ore-minuti.
     * @param integer $minutes Numero di minuti
     * @return string Tempo in formato {X}h {Y}m
     */
    public static function GetReadableTimeFromMinutes($minutes) {
        $hours = (int) ($minutes / 60);
        $minutes = $minutes % 60;
        return ($hours > 0 ? $hours . 'h ' : null) .
                $minutes . 'm';
    }

    /**
     * 
     * @param int $seconds
     * @param boolean $showSeconds
     * @return type
     */
    public static function GetReadableTimeFromSeconds($seconds, $showSeconds = false) {
        $hours = (int) ($seconds / 3600);
        $minutes = (int) (($seconds - $hours * 3600) / 60);
        $seconds = $seconds % 3600;
        return trim(($hours > 0 ? $hours . 'h ' : null) . $minutes . 'm ' . ($showSeconds ? $seconds . 's ' : null));
    }

}
