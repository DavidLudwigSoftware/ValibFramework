<?php

namespace Valib\Http;

class RedirectResponse extends Response
{
    private $_url;

    public function __construct(string $url = Null)
    {
        $this->setUrl($url);
    }

    public function to(string $routeName, array $slugs = [])
    {
        $this->setUrl(route($routeName, $slugs));

        return $this;
    }

    public function setUrl(string $url = Null)
    {
        $this->_url = $url;

        $this->setHeaders(['Location' => $url]);

        return $this;
    }
}
