<?php

namespace Grimlock\Module\Notification\Firebase;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Log\Enum\LevelLog;
use Grimlock\Core\Log\GrimlockLog;
use Grimlock\Module\Notification\Firebase\Bean\Notification;
use Grimlock\Module\Notification\Firebase\Bean\Person;
use Grimlock\Module\RestClient\GrimlockRestClient;

use Exception;

/**
 * @author Ruben Dario Huamani Ucharima
 */
class GrimlockFirebase
{

    private string $firebaseProject;

    private GrimlockLog $grimlockLog;
    private GrimlockRestClient $restClient;

    private ServiceAccountCredentials $googleCredentials;

    /**
     * @throws GrimlockException
     */
    public function __construct()
    {
        if (empty($_ENV['FCM_PROJECT_ID']) || $_ENV['FCM_PROJECT_ID'] == '')
        {
            throw new GrimlockException(GrimlockFirebase::class,  'Firebase Cloud Messaging Key [FCM_PROJECT_ID] not found or empty');
        }
        //Get Google Firebase Access Token
        $serviceAccountFile = __DIR__ . '/../../../../../../../resources/firebase.json';
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $this->googleCredentials = new ServiceAccountCredentials($scopes, $serviceAccountFile);
        $token = $this->googleCredentials->fetchAuthToken();
        $accessToken = $token['access_token'];

        //Create Rest Client
        $this->firebaseProject = $_ENV['FCM_PROJECT_ID'];
        $this->restClient = new GrimlockRestClient("https://fcm.googleapis.com",2);
        $this->restClient->addHeader('Content-Length', '0');
        $this->restClient->addHeader('Authorization', 'Bearer ' . $accessToken);

        //Enabled Log
        $this->grimlockLog = new GrimlockLog(LevelLog::Info);
    }

    /**
     * @param Notification $notification
     * @return bool
     * @throws GrimlockException
     */
    public function sendNotification(Notification $notification): bool {
        try {
            $body = array(
                'message' => array(
                    'topic' => $notification->getTopic(),
                    'notification' => array(
                        'title' => $notification->getTitle(),
                        'body' => $notification->getBody()
                    )
                )
            );

            $responseClient = $this->restClient->post('/v1/projects/'.$this->firebaseProject.'/messages:send', $body);

            if ($responseClient->getCode() == 200) {
                $this->grimlockLog->info('Notification Push send successfully.');
                return true;
            }
            else {
                $this->grimlockLog->info('Notification Push send error. ');
                return false;
            }
        } catch (Exception $e) {
            $this->grimlockLog->error($e->getMessage());
            throw new GrimlockException(GrimlockFirebase::class, $e->getMessage());
        }
    }

    /**
     * @param Notification $notification
     * @param Person $person
     * @return bool
     * @throws GrimlockException
     */
    public function sendNotificationPerson(Notification $notification, Person $person): bool
    {
        try {
            $body = array(
                'token' => $person->getIdRegistration(),
                'notification' => array(
                    'title' => $notification->getTitle(),
                    'body' => $this->formatMessage($notification->getBody(), $person)
                )
            );

            $responseClient = $this->restClient->post('/v1/projects/'.$this->firebaseProject.'/messages:send', $body);
            if ($responseClient->getCode() == 200) {
                $this->grimlockLog->info('Notification Push send successfully.');
                return true;
            }
            else {
                $this->grimlockLog->info('Notification Push send error. ');
                return false;
            }
        } catch (Exception $e) {
            $this->grimlockLog->error($e->getMessage());
            throw new GrimlockException(GrimlockFirebase::class, $e->getMessage());
        }
    }

    private function formatMessage(string $message, Person $person): string
    {
        $keys = array('{NAME}', '{LASTNAME}');
        $values = array($person->getName(), $person->getLastname());

        return str_replace($keys, $values, $message);
    }

}