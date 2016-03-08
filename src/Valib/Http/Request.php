<?php

namespace Valib\Http;

use Valib\Utility\ExtArray;

class Request
{
    /**
     * The request method
     * @var string
     */
    private $_method;

    /**
     * The request scheme
     * @var string
     */
    private $_requestScheme;

    /**
     * The request time
     * @var float
     */
    private $_requestTime;

    /**
     * The request Uri
     * @var string
     */
    private $_requestUri;

    /**
     * The user agent
     * @var string
     */
    private $_userAgent;

    /**
     * The client's IP address
     * @var string
     */
    private $_remoteIp;

    /**
     * The client's Port number
     * @var integer
     */
    private $_remotePort;

    /**
     * The server protocol
     * @var string
     */
    private $_serverProtocol;

    /**
     * A list of query attributes
     * @var Valib\Utility\List
     */
    private $_query;

    /**
     * A list of inputs from a request
     * @var Valib\Utility\List
     */
    private $_input;


    /**
     * Capture the current request
     * @return Valib\Http\Request
     */
    public static function capture()
    {
        $request = new self();

        $request->setMethod($_SERVER['REQUEST_METHOD'])
                ->setScheme($_SERVER['REQUEST_SCHEME'])
                ->setTime($_SERVER['REQUEST_TIME_FLOAT'])
                ->setUri($_SERVER['REQUEST_URI'])
                ->setUserAgent($_SERVER['HTTP_USER_AGENT'])
                ->setRemoteIp($_SERVER['REMOTE_ADDR'])
                ->setRemotePort((int) $_SERVER['REMOTE_PORT'])
                ->setServerProtocol($_SERVER['SERVER_PROTOCOL'])
                ->setQuery($_GET)
                ->setInput($_POST);

        return $request;
    }

    /**
     * Get the current Http method
     * @return string
     */
    public function method()
    {
        return $this->_method;
    }

    /**
     * Get the request scheme
     * @return string
     */
    public function scheme()
    {
        return $this->_requestScheme;
    }

    /**
     * Get the time of the request
     * @return float
     */
    public function time()
    {
        return $this->_requestTime;
    }

    /**
     * Return the uri of the request
     * @return string
     */
    public function uri()
    {
        return $this->_requestUri;
    }

    /**
     * Return the user agent (browser)
     * @return string
     */
    public function userAgent()
    {
        return $this->_userAgent;
    }

    /**
     * Return the IP address of the client
     * @return string
     */
    public function remoteIp()
    {
        return $this->_remoteIp;
    }

    /**
     * Return the port number of the client
     * @return integer
     */
    public function remotePort()
    {
        return $this->_remotePort;
    }

    /**
     * Return the server protocol of the request
     * @return string
     */
    public function serverProtocol()
    {
        return $this->_serverProtocol;
    }

    /**
     * Return the query list
     * @return  Valib\Utility\List
     */
    public function query()
    {
        return $this->_query;
    }

    /**
     * Return the input list
     * @return  Valib\Utility\List
     */
    public function input()
    {
        return $this->_input;
    }

    /**
     * Set the Http request method
     * @param string $method
     * @return self
     */
    public function setMethod(string $method)
    {
        $this->_method = $method;

        return $this;
    }

    /**
     * Set the request scheme
     * @param string $method
     * @return self
     */
    public function setScheme(string $scheme)
    {
        $this->_requestScheme = $scheme;

        return $this;
    }

    /**
     * Set the time of the request
     * @param float $time
     * @return self
     */
    public function setTime(float $time)
    {
        $this->_requestTime = $time;

        return $this;
    }

    /**
     * Set the request uri
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri)
    {
        $this->_requestUri = $uri;

        return $this;
    }

    /**
     * Set the user agent for the request
     * @param string $agent
     * @return self
     */
    public function setUserAgent(string $agent)
    {
        $this->_userAgent = $agent;

        return $this;
    }

    /**
     * Set the client IP address
     * @param string $address
     * @return self
     */
    public function setRemoteIp(string $address)
    {
        $this->_remoteIp = $address;

        return $this;
    }

    /**
     * Set the client port number
     * @param integer $port
     * @return self
     */
    public function setRemotePort(int $port)
    {
        $this->_remotePort = $port;

        return $this;
    }

    /**
     * Set the server protocol
     * @param string $protocol
     * @return self
     */
    public function setServerProtocol(string $protocol)
    {
        $this->_serverProtocol = $protocol;

        return $this;
    }

    /**
     * Set the query data for the request
     * @param array $query
     * @return self
     */
    public function setQuery(array $query)
    {
        $this->_query = new ExtArray($query);

        return $this;
    }

    /**
     * Set the input for the request
     * @param array $input
     * @return self
     */
    public function setInput(array $input)
    {
        $this->_input = new ExtArray($input);

        return $this;
    }
}
