<?php

namespace Grimlock\Module\Notification\Firebase;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Util\GrimlockList;
use Grimlock\Module\Notification\Firebase\Bean\Notification;
use Grimlock\Module\Notification\Firebase\Bean\Person;
use Grimlock\Module\Notification\Whatsapp\GrimlockWhatsapp;
use Grimlock\Module\WebClient\GrimlockRestClient;

use Exception;

/**
 * @author Ruben Dario Huamani Ucharima
 */
class GrimlockFirebase
{

    private string $firebaseKey;
    private GrimlockRestClient $restClient;

    /**
     * @throws GrimlockException
     */
    public function __construct()
    {
        if (empty($_ENV['FCM_KEY']) || $_ENV['FCM_KEY'] == '')
        {
            throw new GrimlockException(GrimlockWhatsapp::class,  'Firebase Cloud Messaging Key [FCM_KEY] not found or empty');
        }
        $this->firebaseKey = $_ENV['FCM_KEY'];
        $this->restClient = new GrimlockRestClient("https://fcm.googleapis.com");
        $this->restClient->addHeader('Authorization', 'key='.$this->firebaseKey);
        $this->restClient->addHeader('Content-Length', '0');
    }

    /**
     * @param Notification $notification
     * @param Person $person
     * @return bool
     * @throws GrimlockException
     */
    public function sendNotification(Notification $notification, Person $person): bool
    {
        try {
            $body = array(
                'to' => $person->getIdRegistration(),
                'notification' => array(
                    'title' => $notification->getTitle(),
                    'body' => $this->formatMessage($notification->getBody(), $person)
                )
            );

            $responseClient = $this->restClient->post('/fcm/send', $body);
            if ($responseClient->getStatusCode() == "200")
                return true;
            else
                return false;
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockFirebase::class, $e->getMessage());
        }
    }

    /**
     * @param Notification $notification
     * @param GrimlockList $persons
     * @return bool
     * @throws GrimlockException
     */
    public function sendNotifications(Notification $notification, GrimlockList $persons): bool
    {
        try {
            $idRegistrations = array();
            for ($i = 0; $i < $persons->getSize(); $i++)
                $idRegistrations = $persons->getItem($i)->getIdRegistration();

            $body = array(
                'registration_ids' => array_chunk($idRegistrations, 1000),
                'notification' => array(
                    'title' => $notification->getTitle(),
                    'body' => $notification->getBody()
                )
            );

            $responseClient = $this->restClient->post('/fcm/send', $body);
            if ($responseClient->getStatusCode() == "200")
                return true;
            else
                return false;
        } catch (Exception $e) {
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