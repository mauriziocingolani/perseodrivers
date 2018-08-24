<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Classe che rappresenta una stazione NetAtmo.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class NetAtmoDevice extends NetAtmoGenericDevice {

    private $last_upgrade;
    private $wifi_status;
    private $station_name;
    private $place;
    private $modules = [];

    public function __construct(array $data) {
        parent::__construct($data);
        $this->last_upgrade = $data['last_upgrade'];
        $this->wifi_status = $data['wifi_status'];
        $this->station_name = $data['station_name'];
        $this->place = new NetAtmoPlace($data['place']);
        foreach ($data['modules'] as $module) :
            $this->modules[] = new NetAtmoModule($module);
        endforeach;
    }

    public function getStationName() {
        return $this->station_name;
    }

    /**
     * @param type $index
     * @return NetAtmoModule
     */
    public function getModule($index) {
        return $this->modules[$index] ?? null;
    }

}
