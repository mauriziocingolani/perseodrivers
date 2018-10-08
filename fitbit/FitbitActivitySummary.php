<?php

namespace mauriziocingolani\perseodrivers\fitbit;

class FitbitActivitySummary {

    public $activityCalories;
    public $caloriesBMR;
    public $caloriesOut;
    public $distances;
//    public $elevation; # apparentemente mancante
    public $fairlyActiveMinutes;
//    public $floors; # apparentemente mancante
    public $lightlyActiveMinutes;
    public $marginalCalories;
    public $sedentaryMinutes;
    public $steps;
    public $veryActiveMinutes;

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

}
