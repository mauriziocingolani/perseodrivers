<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Classe che rappresenta un modulo connesso a una stazione NetAtmo.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0.1
 */
class NetAtmoModule extends NetAtmoGenericDevice {

    private $module_name;
    private $battery_vp;
    private $battery_percent;

    public function __construct(array $data) {
        parent::__construct($data);
        $this->module_name = $data['module_name'];
        $this->battery_vp = $data['battery_vp'];
        $this->battery_percent = $data['battery_percent'];
    }

    public function getModuleName() {
        return $this->module_name;
    }

    public function getBatteryVp() {
        return $this->battery_vp;
    }

    public function getBatteryPercent() {
        return $this->battery_percent;
    }

}
