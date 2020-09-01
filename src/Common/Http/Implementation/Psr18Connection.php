<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Common\Http\Implementation;

use Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Psr18Connection implements RemoteConnectionInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client = null)
    {
        if (!$client) {
            $client = new GuzzleClient();
        }
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface::send()
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        return $this->client->send($request);
    }
}
