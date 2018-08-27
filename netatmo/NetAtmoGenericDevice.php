<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Superclass di dispositivi e moduli.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0.1
 */
class NetAtmoGenericDevice {

    const TYPE_BASE_STATION = 'NAMain';
    const TYPE_OUTDOOR_MODULE = 'NAModule1';
    const TYPE_WIND_MODULE = 'NAModule2';
    const TYPE_RAIN_MODULE = 'NAModule3';
    const TYPE_OPTIONAL_INDOOR_MODULE = 'NAModule4';

    protected $_id;
    protected $type;
    protected $firmware;
    protected $data_type;
    protected $dashboard_data;

    /**
     * Le sottoclassi DEVONO chiamare questo costruttore nel proprio contruttore.
     * @param array $data Dati della lettura
     */
    public function __construct(array $data) {
        $this->_id = $data['_id'];
        $this->type = $data['type'];
        $this->firmware = $data['firmware'];
        $this->data_type = $data['data_type'];
        $this->dashboard_data = $data['dashboard_data'];
    }

    # info dispositivo

    public function GetId() {
        return $this->_id;
    }

    public function getType() {
        return $this->type;
    }

    public function getFirmware() {
        return $this->firmware;
    }

    public function getDataType() {
        return $this->data_type;
    }

    # dati

    public function getData() {
        return $this->dashboard_data;
    }

    public function getAbsolutePressure() {
        return $this->dashboard_data['AbsolutePressure'] ?? null;
    }

    public function getDateMinTemp() {
        return $this->dashboard_data['date_min_temp'] ?? null;
    }

    public function getDateMaxTemp() {
        return $this->dashboard_data['date_max_temp'] ?? null;
    }

    public function getCO2() {
        return $this->dashboard_data['CO2'] ?? null;
    }

    public function getHumidity() {
        return $this->dashboard_data['Humidity'] ?? null;
    }

    public function getMaxTemp() {
        return $this->dashboard_data['max_temp'] ?? null;
    }

    public function getMinTemp() {
        return $this->dashboard_data['min_temp'] ?? null;
    }

    public function getNoise() {
        return $this->dashboard_data['Noise'] ?? null;
    }

    public function getPressure() {
        return $this->dashboard_data['Pressure'] ?? null;
    }

    public function getPressureTrend() {
        return $this->dashboard_data['pressure_trend'] ?? null;
    }

    public function getTemperature() {
        return $this->dashboard_data['Temperature'] ?? null;
    }

    public function getTempTrend() {
        return $this->dashboard_data['temp_trend'] ?? null;
    }

    public function getTimeUtc() {
        return $this->dashboard_data['time_utc'] ?? null;
    }

}
