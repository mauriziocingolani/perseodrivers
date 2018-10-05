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

    /**
     * Costruisce una nuova istanza a partire dai dati resituiti dall'endpoint Sleep Logs.
     * @param array $data
     */
    public function __construct(array $data) {
        $this->summaryTotalMinutesAsleep = $data['summary']['totalMinutesAsleep'];
        $this->summaryTotalSleepRecords = $data['summary']['totalSleepRecords'];
        $this->summaryTotalTimeInBed = $data['summary']['totalTimeInBed'];
        for ($i = $this->summaryTotalSleepRecords - 1; $i >= 0; $i--) : # i record sono invertiti, vado dall'ultimo al primo
            $this->records[] = new FitbitSleepRecord($data['sleep'][$i]);
        endfor;
    }

    /**
     * Restituisce il numero di secondi di sonno, oppure la versione leggibile nel formato ore-minuti.
     * @param string $format Formato della versione leggibile
     * @return integer|string Tempo di sonno
     */
    public function getSummaryTotalMinutesAsleep($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromMinutes($this->summaryTotalMinutesAsleep) : $this->summaryTotalMinutesAsleep;
    }

    /**
     * Restituisce il numero di records che costituiscono il sonno totale.
     * @return integer Numero di records
     */
    public function getSummaryTotalSleepRecords() {
        return $this->getSummaryTotalSleepRecords();
    }

    /**
     * Restituisce il numero di secondi totali passati nel letto, oppure la versione leggibile nel formato ore-minuti.
     * @param string $format Formato della versione leggibile
     * @return integer|string Tempo passato nel letto
     */
    public function getSummaryTotalTimeInBed($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromMinutes($this->summaryTotalTimeInBed) : $this->summaryTotalTimeInBed;
    }

    /**
     * Restituisce i records che costituiscono il sonno totale.
     * @return FitbitSleepRecord[]
     */
    public function getRecords() {
        return $this->records;
    }

}
