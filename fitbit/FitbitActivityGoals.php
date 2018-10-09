<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati del sommario degli obbiettivi di attività.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/activity/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitActivityGoals {

    private $activeMinutes;
    private $caloriesOut;
    private $distance;
    private $steps;

    public function __construct(array $data) {
        foreach ($data as $prop => $value) :
            $this->$prop = $value;
        endforeach;
    }

    /**
     * @return integer
     */
    public function getActiveMinutes() {
        return $this->activeMinutes;
    }

    /**
     * @return integer
     */
    public function getCaloriesOut() {
        return $this->caloriesOut;
    }

    /**
     * @return float
     */
    public function getDistance() {
        return $this->distance;
    }

    /**
     * @return integer
     */
    public function getSteps() {
        return $this->steps;
    }

}
