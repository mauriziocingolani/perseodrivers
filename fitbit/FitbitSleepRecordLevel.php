<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Classe che rappresenta i dati dei livelli di un singolo step di sonno.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/sleep/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class FitbitSleepRecordLevel {

    private $dateTime;
    private $level;
    private $seconds;

    public function __construct(array $data) {
        $this->dateTime = new \DateTime($data['dateTime']);
        $this->level = $data['level'];
        $this->seconds = (int) $data['seconds'];
    }

    /**
     * 
     * @param string $format
     * @return string
     */
    public function getDateTime($format = 'd/m/Y H:i') {
        return $this->dateTime->format($format);
    }

    /**
     * 
     * @return string
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * 
     * @return integer
     */
    public function getSeconds($readable = true) {
        return $readable ? FitbitHelpers::GetReadableTimeFromSeconds($this->seconds) : $this->seconds;
    }

}
