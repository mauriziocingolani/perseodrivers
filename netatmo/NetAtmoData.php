<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Classe che rappresenta i dati restituiti dalla lettura dei dispositivi associati all'account.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class NetAtmoData {

    private $status;
    private $time_exec;
    private $time_server;
    private $devices = [];
    private $user;

    public function __construct(array $data) {
        $this->status = $data['status'];
        $this->time_exec = $data['time_exec'];
        $this->time_server = $data['time_server'];
        foreach ($data['body']['devices'] as $device) :
            $this->devices[] = new NetAtmoDevice($device);
        endforeach;
        $this->user = new NetAtmoUser($data['body']['user']);
    }

    /**
     * @return NetAtmoDevice[]
     */
    public function getDevices() {
        return $this->devices;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTimeExec() {
        return $this->time_exec;
    }

    public function getTimeServer($readable = false, $format = 'd/m/Y H:i:s') {
        return $readable == true ? date($format, $this->time_server) : $this->time_server;
    }

    /**
     * @return NetAtmoUser
     */
    public function getUser() {
        return $this->user;
    }

}
