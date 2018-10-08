<?php

namespace mauriziocingolani\perseodrivers\fitbit;

class FitbitActivitySummaryDistances {

    public $total;
    public $tracker;
    public $loggedActivities;
    public $veryActive;
    public $moderatelyActive;
    public $lightlyActive;
    public $sedentaryActive;

    public function __construct(array $data) {
        foreach ($data as $d) :
            $prop = $d['activity'];
            $this->$prop = $d['distance'];
        endforeach;
    }

}
