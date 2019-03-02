<?php

namespace mauriziocingolani\perseodrivers\gmail;

/**
 * Classe che rappresenta un messaggio GMail.
 * 
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class GMailMessage {

    private $_id;
    private $_labelIds;
    private $_internalDate;
    private $_headers;
    private $_headersData;

    /** Returns the full email message data with body content parsed in the payload field; the raw field is not used. (default) */
    const FORMAT_FULL = 'full';

    /** Returns only email message ID, labels, and email headers. */
    const FORMAT_METADATA = 'metadata';

    /** Returns only email message ID and labels; does not return the email headers, body, or payload. */
    const FORMAT_MINIMAL = 'minimal';

    /** Returns the full email message data with body content in the raw field as a base64url encoded string; the payload field is not used. */
    const FORMAT_RAW = 'raw';

    public function __construct(array $data) {
        $this->_id = $data['id'];
        $this->_internalDate = $data['internalDate'] / 1000;
        $this->_labelIds = $data['labelIds'];
        $this->_headers = $data['payload']['headers'];
        foreach ($this->_headers as $h) :
            $this->_headersData[$h['name']] = $h['value'];
        endforeach;
    }

    public function getId() {
        return $this->_id;
    }

    public function getReceived() {
        return $this->_internalDate;
    }

    public function getFrom() {
        return $this->_headersData['From'] ?? null;
    }

    public function getSubject() {
        return $this->_headersData['Subject'] ?? null;
    }

    public function isUnread() {
        return in_array('UNREAD', $this->_labelIds);
    }

}
