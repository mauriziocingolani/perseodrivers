<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati del sonno.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitSleep {

    private $summaryTotalMinutesAsleep;
    private $summaryTotalSleepRecords;
    private $summaryTotalTimeInBed;
    private $records = [];

    public function __construct(array $data) {
        $this->summaryTotalMinutesAsleep = $data['summary']['totalMinutesAsleep'];
        $this->summaryTotalSleepRecords = $data['summary']['totalSleepRecords'];
        $this->summaryTotalTimeInBed = $data['summary']['totalTimeInBed'];
        for ($i = 0; $i < $this->summaryTotalSleepRecords; $i++) :
            $this->records[] = new FitbitSleepRecord($data['sleep'][$i]);
        endfor;
    }

    /**
     * 
     * @return integer
     */
    public function getSummaryTotalMinutesAsleep($readable = true) {
        return $readable ? (int) ($this->summaryTotalMinutesAsleep / 60) . ':' . $this->summaryTotalMinutesAsleep % 60 : $this->summaryTotalMinutesAsleep;
    }

    /**
     * 
     * @return integer
     */
    public function getSummaryTotalSleepRecords() {
        return $this->summaryTotalSleepRecords;
    }

    /**
     * 
     * @return integer
     */
    public function getSummaryTotalTimeInBed() {
        return $this->summaryTotalTimeInBed;
    }

    /**
     * @return FitbitSleepRecord[]
     */
    public function getRecords() {
        return $this->records;
    }

}
