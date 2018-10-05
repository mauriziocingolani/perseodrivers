<?php

/**
 * Classe che rappresenta i dati di un singolo step di sonno.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */

namespace mauriziocingolani\perseodrivers\fitbit;

class FitbitSleepRecord {

    private $dateOfSleep;
    private $duration;
    private $efficiency;
    private $endTime;
    private $infoCode;
    private $isMainSleep;
    private $levels;
    private $levelsSummary;
    private $logId;
    private $minutesAfterWakeup;
    private $minutesAsleep;
    private $minutesAwake;
    private $minutesToFallAsleep;
    private $startTime;
    private $timeInBed;
    private $type;

    public function __construct(array $data) {
        $this->dateOfSleep = new \DateTime($data['dateOfSleep']);
        $this->duration = (int) $data['duration'];
        $this->efficiency = (int) $data['efficiency'];
        $this->endTime = new \DateTime($data['endTime']);
        $this->infoCode = $data['infoCode'];
        $this->isMainSleep = $data['isMainSleep'];
        foreach ($data['levels']['data'] as $level) :
            $this->levels[] = new FitbitSleepRecordLevel($level);
        endforeach;
        $this->levelsSummary = new FitbitSleepRecordLevelsSummary($data['levels']['summary']);
        $this->logId = (int) $data['logId'];
        $this->minutesAfterWakeup = (int) $data['minutesAfterWakeup'];
        $this->minutesAsleep = (int) $data['minutesAsleep'];
        $this->minutesAwake = (int) $data['minutesAwake'];
        $this->minutesToFallAsleep = (int) $data['minutesToFallAsleep'];
        $this->startTime = new \DateTime($data['startTime']);
        $this->timeInBed = (int) $data['timeInBed'];
        $this->type = $data['type'];
    }

    /**
     * 
     * @param string $format
     * @return string 
     */
    public function getDateOfSleep($format = 'd/m/Y') {
        return $this->dateOfSleep->format($format);
    }

    /**
     * 
     * @return integer
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * 
     * @return integer
     */
    public function getEfficiency() {
        return $this->efficiency;
    }

    /**
     * 
     * @param string $format
     * @return string 
     */
    public function getEndTime($format = 'H:i') {
        return $this->endTime->format($format);
    }

    /**
     * 
     * @return integer
     */
    public function getInfoCode() {
        return $this->efficiency;
    }

    /**
     * 
     * @return boolean
     */
    public function getIsMainSleep() {
        return $this->isMainSleep;
    }

    /**
     * 
     * @return FitbitSleepRecordLevel[]
     */
    public function getLevels() {
        return $this->levels;
    }

    /**
     * 
     * @return FitbitSleepRecordLevelsSummary
     */
    public function getLevelsSummary() {
        return $this->levelsSummary;
    }

    /**
     * 
     * @return integer
     */
    public function getLogId() {
        return $this->logId;
    }

    /**
     * 
     * @return integer
     */
    public function getMinutesAfterWakeup() {
        return $this->minutesAfterWakeup;
    }

    /**
     * 
     * @return integer
     */
    public function getMinutesAsleep() {
        return $this->minutesAsleep;
    }

    /**
     * 
     * @return integer
     */
    public function getMinutesAwake() {
        return $this->minutesAwake;
    }

    /**
     * 
     * @return integer
     */
    public function getMinutesToFallAsleep() {
        return $this->minutesToFallAsleep;
    }

    /**
     * 
     * @param string $format
     * @return string 
     */
    public function getStartTime($format = 'H:i') {
        return $this->startTime->format($format);
    }

    /**
     * 
     * @return integer
     */
    public function getTimeInBed() {
        return $this->timeInBed;
    }

    /**
     * 
     * @return string
     */
    public function getType() {
        return $this->type;
    }

}
