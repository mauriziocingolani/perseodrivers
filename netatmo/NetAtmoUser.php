<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Classe che rappresenta un account NetAtmo.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class NetAtmoUser {

    private $mail;
    private $lang;
    private $reg_locale;

    public function __construct(array $data) {
        $this->mail = $data['mail'];
        $this->lang = $data['administrative']['lang'];
        $this->reg_locale = $data['administrative']['reg_locale'];
    }

    public function getMail() {
        return $this->mail;
    }

}
