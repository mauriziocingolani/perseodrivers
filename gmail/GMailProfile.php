<?php

namespace mauriziocingolani\perseodrivers\gmail;

/**
 * Classe che rappresenta un account GMail.
 * 
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class GMailProfile {

    private $_emailAddress;
    private $_messagesTotal;
    private $_threadsTotal;
    private $_historyId;

    public function __construct(array $data) {
        $this->_emailAddress = $data['emailAddress'];
        $this->_messagesTotal = $data['messagesTotal'];
        $this->_threadsTotal = $data['threadsTotal'];
        $this->_historyId = $data['historyId'];
    }

    public function getEmailAddress() {
        return $this->_emailAddress;
    }

}
