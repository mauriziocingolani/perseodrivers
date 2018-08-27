<?php

namespace mauriziocingolani\perseodrivers\netatmo;

/**
 * Driver di comunicazione con dispositivi NetAtmo.
 * 
 * @link https://dev.netatmo.com/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0
 */
class NetAtmoDriver {

    const BASE_URL = 'https://api.netatmo.com';
    const AUTH_GRANT_TYPE_PASSWORD = 'password';
    const AUTH_GRANT_TYPE_CODE = 'authorization_code';
    const AUTH_SCOPE_READ_STATION = 'read_station';

    /**
     * Genera l'url della pagina per la richiesta di autorizzazione. Di ritorno nell'array di GET si troveranno i due elementi:
     * <ul>
     * <li>code: codice di autorizzazione per la successiva richiesta di token</li>
     * <li>state: codice di stato per check CSRF</li>
     * </ul>
     * @param string $client_id ID cliente dell'app
     * @param string $redirect_uri Url di ritorno dalla pagina di autorizzazione
     * @param string $state Codice di stato per check CSRF
     * @param string $scope Scope autorizzazione (default 'read_station')
     * @return string Url per richiesta autorizzazione
     */
    public function authorize($client_id, $redirect_uri, $state, $scope = null) {
        $scope = $scope ?? self::AUTH_SCOPE_READ_STATION;
        return self::BASE_URL . '/oauth2/authorize' .
                "?client_id=$client_id" .
                "&redirect_uri=$redirect_uri" .
                "&scope=$scope" .
                "&state=$state";
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
    public function getToken($grant_type, $client_id, $client_secret, $redirect_uri, $code, $scope = null) {
        try {
            $scope = $scope ?? self::AUTH_SCOPE_READ_STATION;
            $context = $this->_getContext([
                'grant_type' => $grant_type,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'code' => $code,
                'scope' => $scope,
            ]);
            $response = file_get_contents(self::BASE_URL . '/oauth2/token', false, $context);
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
            $response = file_get_contents(self::BASE_URL . '/oauth2/token', false, $context);
            return json_decode($response, true);
        } catch (\Exception $ex) {
            return $e->getMessage();
        }
    }

    /**
     * Restituisce i dati delle stazioni. Per il dettaglio della struttura dell'array sorgente restituito si veda
     * {@link https://dev.netatmo.com/resources/technical/reference/weather/getstationsdata}.
     * 
     * @param string $token Token di autorizzazione
     * @return NetAtmoData Dati delle stazioni
     */
    public function getStationsData($token) {
        if (!$token)
            return null;
        try {
            $context = $this->_getContext([
                'access_token' => $token,
            ]);
            $response = file_get_contents(self::BASE_URL . '/api/getstationsdata', false, $context);
            return new NetAtmoData(json_decode($response, true));
        } catch (\Exception $e) {
            return $e->getMessage();
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
