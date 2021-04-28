<?php


namespace Src;


use Src\parts\LoginPart;
use Src\parts\UpdateUserPart;
use Src\parts\UserPart;

class UpdateUserRequest extends Request
{
    public int $userId;

    const ACTION = 'http://testapi.ru/<userId>/update';

    public function query(): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->post($this->getUrl(), ['body' => $this->body]);
    }

    public function getResponse(): UserPart
    {
        try {
            $data = json_decode($this->query()->getBody()->getContents());

            $part         = new UpdateUserPart();
            $part->status = $data->status;

            return $data;
        } catch (\Throwable $exception) {
            $this->logger->error($exception);
            $this->logger->error($exception->getTraceAsString());
        }
    }


    public function getUrl(): string
    {
        return str_replace('<userId>', $this->userId, static::ACTION);
    }
}