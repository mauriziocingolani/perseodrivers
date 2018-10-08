<?php

namespace mauriziocingolani\perseodrivers\fitbit;

/**
 * Driver di comunicazione con dispositivi Fitbit.
 * 
 * @link https://dev.fitbit.com/build/reference/web-api/
 * @author Maurizio Cingolani <mauriziocingolani74@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @version 1.0.2
 */
class FitbitDriver {

    const BASE_URL = 'https://www.fitbit.com';
    const API_URL = 'https://api.fitbit.com';

    /**
     * Genera l'url della pagina per la richiesta di autorizzazione. Di ritorno nell'array di GET si troveranno i due elementi:
     * <ul>
     * <li>code: codice di autorizzazione per la successiva richiesta di token</li>
     * <li>state: codice di stato per check CSRF</li>
     * </ul>
     * @param string $client_id ID cliente dell'app
     * @param string $redirect_uri Url di ritorno dalla pagina di autorizzazione
     * @param string $state Codice di stato per check CSRF
     * @param string $scope Scope autorizzazione (default elenco)
     * @return string Url per richiesta autorizzazione
     */
    public function authorize($client_id, $redirect_uri, $state, array $scope = ['activity', 'nutrition', 'heartrate', 'location', 'nutrition', 'profile', 'settings', 'sleep', 'social', 'weight']) {
        $scope = $scope ?? self::AUTH_SCOPE_READ_STATION;
        return self::BASE_URL . '/oauth2/authorize' .
                '?response_type=code' .
                "&client_id=$client_id" .
                "&redirect_uri=$redirect_uri" .
                "&scope=" . join(' ', $scope) .
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
            $opts = ['http' => [
                    'method' => 'POST',
                    'header' => 'Authorization: Basic ' . base64_encode("$client_id:$client_secret") . "\r\n" .
                    "Content-type: application/x-www-form-urlencoded",
                    'content' => http_build_query([
                        'grant_type' => $grant_type,
                        'client_id' => $client_id,
                        'redirect_uri' => $redirect_uri,
                        'code' => $code,
                        'scope' => $scope,
                    ]),
            ]];
            $response = file_get_contents(self::API_URL . '/oauth2/token', false, stream_context_create($opts));
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
     * @param string $refreshToken Token per il refresh
     * @return array Dati del nuovo token
     */
    public function refreshToken($client_id, $client_secret, $refreshToken, $expires_in = 28800) {
        try {
            $opts = ['http' => [
                    'method' => 'POST',
                    'header' => 'Authorization: Basic ' . base64_encode("$client_id:$client_secret") . "\r\n" .
                    "Content-type: application/x-www-form-urlencoded",
                    'content' => http_build_query([
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $refreshToken,
                        'expires_in' => $expires_in,
                    ]),
            ]];
            $response = file_get_contents(self::API_URL . '/oauth2/token', false, stream_context_create($opts));
            return json_decode($response, true);
        } catch (\Exception $ex) {
            \yii\helpers\VarDumper::dump($ex, 10, true);
            die();
            return $ex;
        }
    }

    /**
     * Restituisce i dati dell'account attualmente connesso.
     * @param string $token Token di autorizzazione
     * @return \mauriziocingolani\perseodrivers\fitbit\FitbitUser
     */
    public function getProfile($token) {
        try {
            $opts = ['http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]];
            $response = file_get_contents(self::API_URL . '/1/user/-/profile.json', false, stream_context_create($opts));
            return new FitbitUser(json_decode($response, true));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Restituisce i dati delle attività per la data indicata.
     * @param string $token Token di autorizzazione
     * @param string $date Data in formato 'Y-m-d'
     * @return mauriziocingolani\perseodrivers\FitbitActivity
     */
    public function getDailyActivitiesSummary($token, $date) {
        try {
            $opts = ['http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]];
            $response = file_get_contents(self::API_URL . "/1/user/-/activities/date/$date.json", false, stream_context_create($opts));
            return new FitbitActivity(json_decode($response, true));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Restituisce i dati del sonno per la data indicata.
     * @param string $token Token di autorizzazione
     * @param string $date Data in formato 'Y-m-d'
     * @return \mauriziocingolani\perseodrivers\fitbit\FitbitSleep
     */
    public function getSleepLogs($token, $date) {
        try {
            $opts = ['http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]];
            $response = file_get_contents(self::API_URL . "/1.2/user/-/sleep/date/$date.json", false, stream_context_create($opts));
            return new FitbitSleep(json_decode($response, true));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Restituisce i dati degli bbiettivi di sonno.
     * @param string $token Token di autorizzazione
     * @return \mauriziocingolani\perseodrivers\fitbit\FitbitSleepGoal
     */
    public function getSleepGoals($token) {
        try {
            $opts = ['http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Bearer $token",
            ]];
            $response = file_get_contents(self::API_URL . "/1/user/-/sleep/goal.json", false, stream_context_create($opts));
            return new FitbitSleepGoal(json_decode($response, true));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
