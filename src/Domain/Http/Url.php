<?php

namespace Mcustiel\Phiremock\Domain\Http;

class Url
{
    const URL_PATH_REGEX = '~^/(?:[^/?#]*)?(?:[^?#]*)(?:\?(?:[^#]*))?~';

    /** @var string * */
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->ensureIsValidUrl($url);
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->url;
    }

    private function ensureIsValidUrl($url)
    {
        if (!\is_string($url)) {
            throw new \InvalidArgumentException(
                sprintf('Url must be a string. Got: %s', \gettype($url))
            );
        }

        if (!preg_match(self::URL_PATH_REGEX, $url)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid http url: %s', var_export($url, true))
            );
        }
    }
}
