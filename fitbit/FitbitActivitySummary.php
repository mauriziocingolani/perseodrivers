<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati del sommario delle attività.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/activity/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitActivitySummary {

    private $activityCalories;
    private $caloriesBMR;
    private $caloriesOut;
    private $distances;
//    private $elevation; # apparentemente mancante
    private $fairlyActiveMinutes;
//    private $floors; # apparentemente mancante
    private $lightlyActiveMinutes;
    private $marginalCalories;
    private $sedentaryMinutes;
    private $steps;
    private $veryActiveMinutes;

    public function __construct(array $data) {
        $this->activityCalories = $data['activityCalories'];
        $this->caloriesBMR = $data['caloriesBMR'];
        $this->caloriesOut = $data['caloriesOut'];
        $this->distances = new FitbitActivitySummaryDistances($data['distances']);
//        $this->elevation = $data['elevation']; # apparentemente mancante
        $this->fairlyActiveMinutes = $data['fairlyActiveMinutes'];
//        $this->floors = $data['floors']; # apparentemente mancante
        $this->lightlyActiveMinutes = $data['lightlyActiveMinutes'];
        $this->marginalCalories = $data['marginalCalories'];
        $this->sedentaryMinutes = $data['sedentaryMinutes'];
        $this->steps = $data['steps'];
        $this->veryActiveMinutes = $data['veryActiveMinutes'];
    }

    /**
     * @return integer
     */
    public function getActivityCalories() {
        return $this->activityCalories;
    }

    /**
     * @return integer
     */
    public function getCaloriesBMR() {
        return $this->caloriesBMR;
    }

    /**
     * @return integer
     */
    public function getCaloriesOut() {
        return $this->caloriesOut;
    }

    /**
     * @return FitbitActivitySummaryDistances[]
     */
    public function getDistances() {
        return $this->distances;
    }

    /**
     * @return integer
     */
    public function getFairlyActiveMinutes() {
        return $this->fairlyActiveMinutes;
    }

    /**
     * @return integer
     */
    public function getLightlyActiveMinutes() {
        return $this->lightlyActiveMinutes;
    }

    /**
     * @return integer
     */
    public function getMarginalCalories() {
        return $this->marginalCalories;
    }

    /**
     * @return integer
     */
    public function getSedentaryMinutes() {
        return $this->sedentaryMinutes;
    }

    /**
     * @return integer
     */
    public function getSteps() {
        return $this->steps;
    }

    /**
     * @return integer
     */
    public function getVeryActiveMinutes() {
        return $this->veryActiveMinutes;
    }

}
