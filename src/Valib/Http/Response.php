<?php

namespace Valib\Http;

class Response
{
    /**
     * Store the modified headers
     * @var array
     */
    private $_headers = [];

    /**
     * Store the content of the response
     * @var string
     */
    private $_content;

    /**
     * Create a response
     * @param string $content (optional)
     */
    public function __construct($content = "")
    {
        $this->setContent($content);
    }

    /**
     * Send the response to the client
     * @return void
     */
    public function send()
    {
        foreach ($this->headers() as $key => $value)

            header("$key: $value");

        echo $this->content();
    }

    /**
     * Get the modified headers for the response
     * @return array
     */
    public function headers()
    {
        return $this->_headers;
    }

    /**
     * Get the content of the response
     * @return string
     */
    public function content()
    {
        return $this->_content;
    }

    /**
     * Set the content of the response
     * @param string $content
     * @return self
     */
    public function setContent(string $content)
    {
        $this->_content = $content;

        return $this;
    }

    /**
     * Modify the headers of the response
     * @param array $headers
     * @return self
     */
    public function setHeaders(array $headers)
    {
        $this->_headers = array_merge($this->_headers, $headers);

        return $this;
    }

    /**
     * Remove all modified headers
     * @return self
     */
    public function clearHeaders()
    {
        $this->_headers = [];

        return $this;
    }

    /**
     * Remove modified headers
     * @param  arrray $headers
     * @return self
     */
    public function removeHeaders($headers)
    {
        foreach ($headers as $header)

            unset($this->_headers[$headers]);

        return $this;
    }
}
