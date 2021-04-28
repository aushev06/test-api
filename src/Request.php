<?php


namespace Src;


use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

abstract class Request
{
    const ACTION = 'http://testapi.ru/';

    public array $queryParams;
    public array $body;

    public function __construct(
        protected Client $client,
        protected LoggerInterface $logger
    ) {
    }

    abstract public function query(): \Psr\Http\Message\ResponseInterface;

    abstract public function getResponse(): mixed;

    /**
     * @param array $queryParams
     */
    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    public function getUrl(): string
    {
        return static::ACTION;
    }


}