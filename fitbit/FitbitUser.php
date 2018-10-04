<?php

/**
 * Classe che rappresenta un account Fitbit.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/user/#get-profile
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */

namespace mauriziocingolani\perseodrivers\fitbit;

class FitbitUser {

    private $age;
    private $dateOfBirth;
    private $displayName;

    public function __construct(array $data) {
        $this->age = $data['user']['age'];
        $this->dateOfBirth = $data['user']['dateOfBirth'];
        $this->displayName = $data['user']['displayName'];
    }

    /**
     * 
     * @return integer
     */
    public function getAge() {
        return $this->age;
    }

    /**
     * 
     * @param string $format
     * @return string
     */
    public function getDateOfBirth($format = 'd/m/Y') {
        return (new \DateTime($this->dateOfBirth))->format($format);
    }

    /**
     * 
     * @return string
     */
    public function getDisplayName() {
        return $this->displayName;
    }

}
