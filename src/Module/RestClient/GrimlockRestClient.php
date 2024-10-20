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
use GuzzleHttp\Psr7\Request;

/**
 *
 */
class GrimlockRestClient
{

    private string $baseUri;
    private int $timeout;
    private GrimlockList $headers;
    private Client $client;

    public function __construct(string $baseUri, int $timeout = 2)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
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
    private function addRequestHeaders(Request &$request): void
    {
        $request->withHeader('Content-Type', 'application/json');
        $request->withHeader('Accept', 'application/json');
        for ($i = 0; $i < $this->headers->getSize(); $i++)
        {
            $request->withHeader($this->headers->getItem($i)->getName(), $this->headers->getItem($i)->getValue());
        }
    }

    /**
     * @throws GrimlockException
     */
    public function get(string $uri, array $query = array()): GrimlockResponse
    {
        try {
            $request = new Request('GET', $this->baseUri . $uri);
            $this->addRequestHeaders($request);
            $response = $this->client->send($request, [
                'query' => $query,
                'timeout' => $this->timeout,
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
            $response = $this->client->request('POST', $uri,[
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
            $response = $this->client->request('PUT', $uri,[
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