<?php

namespace Grimlock\Module\RestClient\Bean;

use Psr\Http\Message\ResponseInterface;
use Grimlock\Core\Util\GrimlockList;

class GrimlockResponse
{

    private GrimlockList $headers;
    private int $code;
    private string $body;

    public static function create(ResponseInterface $response): GrimlockResponse
    {
        $code = $response->getStatusCode();
        $headers = new GrimlockList();
        foreach ($response->getHeaders() as $name => $values) {
            $grimlockHeader = new GrimlockHeader();
            $grimlockHeader->setName($name);
            $grimlockHeader->setValue($values[0]);
            $headers->append($grimlockHeader);
        }
        $body = $response->getBody()->getContents();

        return new GrimlockResponse($code, $headers, $body);
    }

    private function __construct(int $code, GrimlockList $headers, string $body)
    {
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function processResponse(ResponseInterface $response): void
    {
        $this->code = $response->getStatusCode();
        foreach ($response->getHeaders() as $name => $values) {
            $grimlockHeader = new GrimlockHeader();
            $grimlockHeader->setName($name);
            $grimlockHeader->setValue($values[0]);
            $this->headers->append($grimlockHeader);
        }
        $this->body = $response->getBody()->getContents();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getHeader(string $name): ?GrimlockHeader
    {
        for ($i = 0; $i < $this->headers->getSize(); $i ++)
        {
            $header = $this->headers->getItem($i);
            if ($header->getName() == $name)
                return $header;
        }
        return null;
    }

    public function getHeaders(): GrimlockList
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }

}