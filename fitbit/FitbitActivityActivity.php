<?php

namespace mauriziocingolani\perseodrivers\fitbit;

class FitbitActivityActivity {

    private $activityId;
    private $activityParentId;
    private $calories;
    private $description;
    private $distance;
    private $duration;
    private $hasStartTime;
    private $isFavorite;
    private $logId;
    private $name;
    private $startTime;
    private $steps;

    public function __construct(array $data) {
        foreach ($data as $prop => $value) :
            $this->$prop = $value;
        endforeach;
    }

}
