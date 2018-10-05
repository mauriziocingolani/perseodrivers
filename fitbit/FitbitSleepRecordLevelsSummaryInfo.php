<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati del sommario dei livelli di un singolo step di sonno.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitSleepRecordLevelsSummaryInfo {

    private $count;
    private $minutes;

    public function __construct(array $data) {
        $this->count = $data['count'];
        $this->minutes = $data['minutes'];
    }

    /**
     * 
     * @return integer
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * 
     * @return integer
     */
    public function getMinutes($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromMinutes($this->minutes) : $this->minutes;
    }

}
