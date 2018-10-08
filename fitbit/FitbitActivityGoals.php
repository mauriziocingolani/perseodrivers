<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Description of FitbitActivityGoal
 *
 * @author maurizio
 */
class FitbitActivityGoals {

    public $activeMinutes;
    public $caloriesOut;
    public $distance;
    public $steps;

    public function __construct(array $data) {
        foreach ($data as $prop => $value) :
            $this->$prop = $value;
        endforeach;
    }

}
