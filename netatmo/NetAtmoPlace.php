<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Classe che rappresenta la posizione dell'utente associato all'accoutn NetAtmo.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class NetAtmoPlace {

    private $city;
    private $country;
    private $timezone;
    private $location;

    public function __construct(array $data) {
        $this->city = $data['city'];
        $this->country = $data['country'];
        $this->timezone = $data['timezone'];
        $this->location = $data['location'];
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getTimezone() {
        return $this->timezone;
    }

    public function getLatitude() {
        return $this->location[0];
    }

    public function getLongitude() {
        return $this->location[1];
    }

}
