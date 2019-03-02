<?php

namespace mauriziocingolani\perseodrivers\gmail;

/**
 * Driver di comunicazione con GMail.
 * 
 * @link https://developers.google.com/oauthplayground/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class GMailDriver {

    const BASE_URL = 'https://accounts.google.com';
    const API_URL = 'https://www.googleapis.com';
    const AUTH_SCOPE_FULL = 'https://mail.google.com';
    const AUTH_SCOPE_COMPOSE = 'https://www.googleapis.com/auth/gmail.compose';
    const AUTH_SCOPE_INSERT = 'https://www.googleapis.com/auth/gmail.insert';
    const AUTH_SCOPE_LABELS = 'https://www.googleapis.com/auth/gmail.labels';
    const AUTH_SCOPE_METADATA = 'https://www.googleapis.com/auth/gmail.metadata';
    const AUTH_SCOPE_MODIFY = 'https://www.googleapis.com/auth/gmail.modify';
    const AUTH_SCOPE_READONLY = 'https://www.googleapis.com/auth/gmail.readonly';
    const AUTH_SCOPE_SEND = 'https://www.googleapis.com/auth/gmail.send';
    const AUTH_SCOPE_SETTINGS_BASIC = 'https://www.googleapis.com/auth/gmail.settings.basic';
    const AUTH_SCOPE_SETTINGS_SHARING = 'https://www.googleapis.com/auth/gmail.settings.sharing';

    /**
     * Genera l'url della pagina per la richiesta di autorizzazione. Di ritorno nell'array di GET si troveranno i due elementi:
     * <ul>
     * <li>code: codice di autorizzazione per la successiva richiesta di token</li>
     * <li>state: codice di stato per check CSRF</li>
     * </ul>
     * @param string $client_id ID cliente dell'app
     * @param string $redirect_uri Url di ritorno dalla pagina di autorizzazione
     * @param string $state Codice di stato per check CSRF
     * @param string $scope Scope autorizzazione (default accesso completo')
     * @return string Url per richiesta autorizzazione
     */
    public function authorize($client_id, $redirect_uri, $scope = null) {
        $scope = $scope ?? self::AUTH_SCOPE_FULL;
        return self::BASE_URL . '/o/oauth2/v2/auth' .
                "?redirect_uri=$redirect_uri" .
                "&prompt=consent" .
                "&response_type=code" .
                "&client_id=$client_id" .
                "&scope=$scope" .
                "&access_type=offline";
    }

    /**
     * Permette di ottenere un token di autorizzazione da usare nelle successive richieste.
     * Il metodo restituisce un array con i seguenti elementi:
     * <ul>
     * <li>access_token: token di accesso</li>
     * <li>expires_in: secondi di validità del token</li>
     * <li>refresh_token: token per il refresh dopo la scadenza</li>
     * </ul>
     * @param string $grant_type Tipologia di autenticazione
     * @param string $client_id ID app
     * @param string $client_secret Chiave segreta app 
     * @param string $redirect_uri Url di ritorno (uguale a quello usato per ottenere il codice di autorizzazione!) 
     * @param string $code Codice di autorizzazione
     * @param string $scope Scope (default 'read_station')
     * @return array Dati del token
     */
    public function getToken($grant_type, $client_id, $client_secret, $redirect_uri, $code) {
        try {
            $context = $this->_getContext([
                'code' => $code,
                'redirect_uri' => $redirect_uri,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'scope' => null,
                'grant_type' => $grant_type,
            ]);
            $response = file_get_contents(self::API_URL . '/oauth2/v4/token', false, $context);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Esegue il refresh di un token non più valido in quanto scaduto.
     * Restituisce un array identico a quello restituito da {@link getToken}.
     * @param string $client_id ID app
     * @param string $client_secret Chiave segreta app
     * @param string $token Token per il refresh
     * @return array Dati del nuovo token
     */
    public function refreshToken($client_id, $client_secret, $token) {
        try {
            $context = $this->_getContext([
                'grant_type' => "refresh_token",
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'refresh_token' => $token,
            ]);
            $response = file_get_contents(self::API_URL . '/oauth2/v4/token', false, $context);
            return json_decode($response, true);
        } catch (\Exception $ex) {
            return $e->getMessage();
        }
    }

    /**
     * Restituisce i dati del profilo. Per il dettaglio della struttura dell'array sorgente restituito si veda
     * {@link https://developers.google.com/gmail/api/v1/reference/users/getProfile}.
     * @param string $token Token di autorizzazione
     * @return GMailProfile Dati del profilo
     */
    public function getProfile($token) {
        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]]);
            $response = file_get_contents(self::API_URL . '/gmail/v1/users/me/profile', false, $context);
            return new GMailProfile(json_decode($response, true));
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Restituisce l'elenco dei messaggi nella casella "Posta in arrivo". Per il dettaglio della struttura dell'array sorgente
     *  restituito si veda {@link https://developers.google.com/gmail/api/v1/reference/users/messages/list}.
     * @param string $token 
     * @param string $id
     * @return array Messaggi
     */
    public function getInboxMessages($token) {
        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]]);
            $response = file_get_contents(self::API_URL . '/gmail/v1/users/me/messages?labelIds=INBOX', false, $context);
            return json_decode($response, true);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * 
     * @param string $token Token di autorizzazione
     * @param string $id ID del messaggio
     * @param string $format Formato del messaggo (opzionale)
     * @return GMailMessage Messaggio
     */
    public function getMessage($token, $id, $format = null) {
        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]]);
            $url = self::API_URL . '/gmail/v1/users/me/messages/' . $id;
            if ($format)
                $url .= '?format=' . $format;
            $response = file_get_contents($url, false, $context);
            return new GMailMessage(json_decode($response, true));
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Restituisce lo stream per la chiamata all'end-point.
     * @param array $query_data Elenco dei parametri
     * @return resource Stream
     */
    private function _getContext(array $query_data) {
        $postdata = http_build_query($query_data);
        $opts = ['http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
        ]];
        return stream_context_create($opts);
    }

}
