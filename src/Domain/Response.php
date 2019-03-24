<?php

namespace Mcustiel\Phiremock\Domain;

abstract class Response
{
    public function isHttpResponse()
    {
        return false;
    }

    public function isProxyResponse()
    {
        return false;
    }
}
