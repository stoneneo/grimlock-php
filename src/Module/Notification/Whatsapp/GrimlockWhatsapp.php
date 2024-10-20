<?php

namespace Grimlock\Module\Notification\Whatsapp;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Module\Notification\Whatsapp\Bean\Person;
use Grimlock\Module\WebClient\GrimlockRestClient;

/**
 * @author Ruben Dario Huamani Ucharima
 */
class GrimlockWhatsapp
{

    private string $accessToken;
    private string $phoneNumberId;
    private GrimlockRestClient $restClient;

    /**
     * @throws GrimlockException
     */
    public function __construct()
    {
        if (empty($_ENV['WSP_KEY']) || $_ENV['WSP_KEY'] == '')
        {
            throw new GrimlockException(GrimlockWhatsapp::class,  'Whatsapp Phone Number Id [WSP_KEY] not found or empty');
        }
        if (empty($_ENV['WSP_JWT']) || $_ENV['WSP_JWT'] == '')
        {
            throw new GrimlockException(GrimlockWhatsapp::class,  'Whatsapp Access Token [WSP_JWT] not found or empty');
        }
        $this->accessToken = $_ENV['WSP_JWT'];
        $this->phoneNumberId = $_ENV['WSP_KEY'];

        $this->restClient = new GrimlockRestClient('https://graph.facebook.com/v18.0/'.$this->phoneNumberId);
        $this->restClient->addHeader('Authorization', 'Bearer : '.$this->accessToken);
    }

    /**
     * @param Person $person
     * @param string $message
     * @return bool
     * @throws GrimlockException
     */
    public function sendMessage(Person $person, string $message): bool
    {
        $responseClient = $this->restClient->post('/messages', $this->getBodyMessage($message, $person));
        $httpCode = $responseClient->getStatusCode();
        if ($httpCode == 200)
            return true;
        else
            return false;
    }

    /**
     * @param Person $person
     * @param string $template
     * @return bool
     * @throws GrimlockException
     */
    public function sendTemplate(Person $person, string $template): bool
    {
        $responseClient = $this->restClient->post('/messages', $this->getBodyTemplate($template, $person));
        $httpCode = $responseClient->getStatusCode();
        if ($httpCode == 200)
            return true;
        else
            return false;
    }

    /**
     * @param string $message
     * @param Person $person
     * @return string
     */
    private function formatMessage(string $message, Person $person): string
    {
        $keys = array('{NAME}');
        $values = array($person->getName());

        return str_replace($keys, $values, $message);
    }

    /**
     * @param string $message
     * @param Person $person
     * @return array
     */
    private function getBodyMessage(string $message, Person $person): array
    {
        return array(
            'type' => 'text',
            'to' => $person->getNumber(),
            'recipient_type' => 'individual',
            'messaging_product' => 'whatsapp',
            'text' => array(
                'body' => $this->formatMessage($message, $person)
            )
        );
    }

    /**
     * @param string $template
     * @param Person $person
     * @return array
     */
    private function getBodyTemplate(string $template, Person $person): array
    {
        return array(
            'type' => 'template',
            'to' => $person->getNumber(),
            'recipient_type' => 'individual',
            'messaging_product' => 'whatsapp',
            'template' => array(
                'name' => $template,
                'language' => 'es_ES'
            )
        );
    }

}