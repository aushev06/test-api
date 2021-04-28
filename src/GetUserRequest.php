<?php


namespace Src;


use Src\parts\LoginPart;
use Src\parts\UserPart;

class GetUserRequest extends Request
{
    public string $username;

    const ACTION = 'http://testapi.ru/<username>';

    public function query(): \Psr\Http\Message\ResponseInterface
    {
        $params = [
            'query' => $this->queryParams
        ];

        return $this->client->get($this->getUrl(), $params);
    }

    public function getResponse(): UserPart
    {
        try {
            $data = json_decode($this->query()->getBody()->getContents());
            $part = new UserPart();

            $part->status      = $data->status;
            $part->id          = $data->id;
            $part->name        = $data->name;
            $part->created_at  = $data->created_at;
            $part->blocked     = $data->blocked;
            $part->active      = $data->active;
            $part->permissions = $data->permissions;

            return $part;
        } catch (\Throwable $exception) {
            $this->logger->error($exception);
            $this->logger->error($exception->getTraceAsString());
        }
    }


    public function getUrl(): string
    {
        return str_replace('<username>', $this->username, static::ACTION);
    }
}