<?php

namespace Grimlock\Module\RestClient;

use Exception;
use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Util\GrimlockList;
use Grimlock\Module\Notification\Whatsapp\GrimlockWhatsapp;
use Grimlock\Module\RestClient\Bean\GrimlockHeader;
use Grimlock\Module\RestClient\Bean\GrimlockResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 *
 */
class GrimlockRestClient
{

    private string $baseUri;
    private int $timeout;
    private GrimlockList $headers;
    private Client $client;

    public function __construct(string $baseUri, int $timeout = 2, bool $sslEnabled = true)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
            'verify' => $sslEnabled,
        ]);
        $this->baseUri = $baseUri;
        $this->timeout = $timeout;
        $this->headers = new GrimlockList();
    }

    public function addHeader($name, $value): void
    {
        $header = new GrimlockHeader();
        $header->setName($name);
        $header->setValue($value);
        $this->headers->append($header);
    }

    /**
     * @throws GrimlockException
     */
    private function getHeaders(): array {
        $headers = array();
        for ($i = 0; $i < $this->headers->getSize(); $i++)
        {
            $headers[$this->headers->getItem($i)->getName()] = $this->headers->getItem($i)->getValue();
        }

        return $headers;
    }

    /**
     * @throws GrimlockException
     */
    public function get(string $uri, array $query = array()): GrimlockResponse
    {
        try {
            $response = $this->client->request('GET', $this->baseUri . $uri, [
                'headers' => $this->getHeaders(),
                'query' => $query,
                'timeout' => $this->timeout
            ]);
            return GrimlockResponse::create($response);
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockWhatsapp::class, $e->getMessage());
        } catch (GuzzleException $e) {
            throw new GrimlockException(GrimlockWhatsapp::class, $e->getMessage());
        }
    }

    /**
     * @throws GrimlockException
     */
    public function post(string $uri, array $body): GrimlockResponse
    {
        try {
            $response = $this->client->request('POST', $this->baseUri . $uri, [
               'headers' => $this->getHeaders(),
               'json' => $body
            ]);
            return GrimlockResponse::create($response);
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockWhatsapp::class, $e->getMessage());
        } catch (GuzzleException $e) {
            throw new GrimlockException(GrimlockWhatsapp::class, $e->getMessage());
        }
    }

    /**
     * @throws GrimlockException
     */
    public function put(string $uri, array $body): GrimlockResponse
    {
        try {
            $response = $this->client->request('PUT', $this->baseUri . $uri, [
                'headers' => $this->getHeaders(),
                'json' => $body
            ]);
            return GrimlockResponse::create($response);
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockWhatsapp::class, $e->getMessage());
        } catch (GuzzleException $e) {
            throw new GrimlockException(GrimlockWhatsapp::class, $e->getMessage());
        }
    }


}