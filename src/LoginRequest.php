<?php


namespace Src;


use Src\parts\LoginPart;

class LoginRequest extends Request
{
    const ACTION = 'http://testapi.ru/auth';

    public function query(): \Psr\Http\Message\ResponseInterface
    {
        $params = [
            'query' => $this->queryParams
        ];

        return $this->client->get($this->getUrl(), $params);
    }

    public function getResponse(): LoginPart
    {
        try {
            $data = json_decode($this->query()->getBody()->getContents());
            $part = new LoginPart();

            $part->status = $data->status;
            $part->token  = $data->token;

            return $part;
        } catch (\Throwable $exception) {
            $this->logger->error($exception);
            $this->logger->error($exception->getTraceAsString());
        }
    }

}