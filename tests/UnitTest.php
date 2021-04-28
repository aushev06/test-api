<?php

namespace Tests;


use GuzzleHttp\Client;
use Psr\Log\NullLogger;
use Src\GetUserRequest;
use Src\LoginRequest;
use Src\parts\UserPart;
use Src\UpdateUserRequest;

class UnitTest extends \PHPUnit\Framework\TestCase
{
    private string   $token;
    private UserPart $user;

    public function testLogin()
    {
        $client = new Client();
        $logger = new NullLogger();

        $request = new LoginRequest($client, $logger);

        $request->setQueryParams(['login' => 'test', 'pass' => 12345]);
        $data = $request->getResponse();

        self::assertTrue(!empty($data->token));
        self::assertTrue(!empty($data->status));

        $this->token = $data->token;
    }

    public function testGetUserByToken()
    {
        $client = new Client();
        $logger = new NullLogger();

        $request           = new GetUserRequest($client, $logger);
        $request->username = 'ivanov';

        $request->setQueryParams(['token' => $this->token]);
        $data = $request->getResponse();

        self::assertTrue($data->status === "OK");

        $this->user = $data;
    }

    public function testUpdateUser()
    {
        $client = new Client();
        $logger = new NullLogger();

        $request         = new UpdateUserRequest($client, $logger);
        $request->userId = $this->user->id;

        $request->setQueryParams(['token' => $this->token]);
        $request->setBody(get_object_vars($this->user));

        $data = $request->getResponse();

        self::assertTrue($data->status === "OK");
    }

}