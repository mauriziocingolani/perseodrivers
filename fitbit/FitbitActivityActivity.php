<?php

namespace mauriziocingolani\perseodrivers\fitbit;

class FitbitActivityActivity {

    public $activityId;
    public $activityParentId;
    public $calories;
    public $description;
    public $distance;
    public $duration;
    public $hasStartTime;
    public $isFavorite;
    public $logId;
    public $name;
    public $startTime;
    public $steps;

    public function __construct(array $data) {
        foreach ($data as $prop => $value) :
            $this->$prop = $value;
        endforeach;
    }

}
