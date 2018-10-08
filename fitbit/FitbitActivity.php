<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati delle attività.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitActivity {

    public $activities = [];
    public $goals;
    public $summary;

    /**
     * Costruisce una nuova istanza a partire dai dati resituiti dall'endpoint Daily Activity Summary.
     * @param array $data
     */
    public function __construct(array $data) {
        foreach ($data['activities'] as $activity) :
            $this->activities[] = new FitbitActivityActivity(($activity));
        endforeach;
        $this->goals = new FitbitActivityGoals($data['goals']);
        $this->summary = new FitbitActivitySummary($data['summary']);
    }

    /**
     * @return FitbitActivityActivity[]
     */
    public function getActivities() {
        return $this->activities;
    }

    /**
     * @return FitbitActivityGoals
     */
    public function getGoals() {
        return $this->goals;
    }

    /**
     * @return FitbitActivitySummary
     */
    public function getSummary() {
        return $this->getSummary();
    }

}
