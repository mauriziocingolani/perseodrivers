<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati delle distanze del sommario delle attività.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/activity/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitActivitySummaryDistances {

    private $total;
    private $tracker;
    private $loggedActivities;
    private $veryActive;
    private $moderatelyActive;
    private $lightlyActive;
    private $sedentaryActive;

    public function __construct(array $data) {
        foreach ($data as $d) :
            $prop = $d['activity'];
            $this->$prop = $d['distance'];
        endforeach;
    }

    /**
     * @return float
     */
    public function getTotal() {
        return $this->total;
    }


    /**
     * @return float
     */
    public function getTracker() {
        return $this->tracker;
    }

    /**
     * @return integer
     */
    public function getLoggedActivities() {
        return $this->loggedActivities;
    }

    /**
     * @return float
     */
    public function getVeryActive() {
        return $this->veryActive;
    }

    /**
     * @return float
     */
    public function getModeratelyActive() {
        return $this->moderatelyActive;
    }

    /**
     * @return float
     */
    public function getLightlyActive() {
        return $this->lightlyActive;
    }

    /**
     * @return float
     */
    public function getSedentaryActive() {
        return $this->sedentaryActive;
    }

}
