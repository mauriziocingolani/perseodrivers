<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta il sommario dei livelli di un singolo step di sonno.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitSleepRecordLevelsSummary {

    private $asleep;
    private $awake;
    private $restless;

    public function __construct(array $data) {
        $this->asleep = new FitbitSleepRecordLevelsSummaryInfo($data['asleep']);
        $this->awake = new FitbitSleepRecordLevelsSummaryInfo($data['awake']);
        $this->restless = new FitbitSleepRecordLevelsSummaryInfo($data['restless']);
    }

    /**
     * 
     * @return FitbitSleepRecordLevelsSummaryInfo
     */
    public function getAsleep() {
        return $this->asleep;
    }

    /**
     * 
     * @return FitbitSleepRecordLevelsSummaryInfo
     */
    public function getAwake() {
        return $this->awake;
    }

    /**
     * 
     * @return FitbitSleepRecordLevelsSummaryInfo
     */
    public function getRestless() {
        return $this->restless;
    }

}
