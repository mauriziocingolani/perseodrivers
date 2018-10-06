<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati degli obbiettivi di sonno.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitSleepGoal {

    private $awakeRestlessPercentage;
    private $flowId;
    private $recommendedSleepGoal;
    private $typicalDuration;
    private $typicalWakeupTime;
    private $bedtime;
    private $minDuration;
    private $updatedOn;
    private $wakeupTime;

    /**
     * Costruisce una nuova istanza a partire dai dati resituiti dall'endpoint Sleep Goals.
     * @param array $data
     */
    public function __construct(array $data) {
        $this->awakeRestlessPercentage = $data['consistency']['awakeRestlessPercentage'];
        $this->flowId = $data['consistency']['flowId'];
        $this->recommendedSleepGoal = $data['consistency']['recommendedSleepGoal'];
        $this->typicalDuration = $data['consistency']['typicalDuration'];
        $this->typicalWakeupTime = $data['consistency']['typicalWakeupTime'];
        $this->bedtime = $data['goal']['bedtime'];
        $this->minDuration = $data['goal']['minDuration'];
        $this->updatedOn = new \DateTime($data['goal']['updatedOn']);
        $this->wakeupTime = $data['goal']['wakeupTime'];
    }

    /**
     * @return float
     */
    public function getAwakeRestlessPercentage() {
        return $this->awakeRestlessPercentage;
    }

    /**
     * @return integer
     */
    public function getFlowId() {
        return $this->flowId;
    }

    /**
     * @param boolean $readable
     * @return integer|string
     */
    public function getRecommendedSleepGoal($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromMinutes($this->recommendedSleepGoal) : $this->recommendedSleepGoal;
    }

    /**
     * @param boolean $readable
     * @return integer|string
     */
    public function getTypicalDuration($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromMinutes($this->typicalDuration) : $this->typicalDuration;
    }

    /**
     * @return string
     */
    public function getTypicalWakeupTime() {
        return $this->typicalWakeupTime;
    }

    /**
     * @return string
     */
    public function getBedtime() {
        return $this->bedtime;
    }

    /**
     * @param boolean $readable
     * @return integer|string
     */
    public function getMinDuration($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromMinutes($this->minDuration) : $this->minDuration;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getUpdatedOn($format = 'd/m/Y H:i:s') {
        return $this->updatedOn->format($format);
    }

    /**
     * @return string
     */
    public function getWakeupTime() {
        return $this->getWakeupTime();
    }

}
