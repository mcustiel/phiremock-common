<?php

namespace Mcustiel\Phiremock\Domain\Http;

class JsonBody extends Body
{
    /** @param mixed $body */
    public function __construct($body)
    {
        parent::__construct(json_encode($body));
    }
}
