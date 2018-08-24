<?php

namespace NotificationChannels\Kavenegar;

class KavenegarMessage
{
    /** @var string */
    protected $receptor;

    /** @var string */
    protected $sender;

    /** @var string */
    protected $message;

    /** @var string */
    protected $template;

    /** @var string */
    protected $type;
    
    /** @var array */
    protected $tokens = [];

    /**
     * @param string $receptor
     * @return static
     */
    public static function create($receptor = '')
    {
        return new static($receptor);
    }

    /**
     * @param string $receptor
     */
    public function __construct($receptor = '')
    {
        $this->receptor = $receptor;
    }

    /**
     * Set the receptor.
     *
     * @param $receptor
     *
     * @return $this
     */
    public function receptor($receptor)
    {
        $this->receptor = $receptor;

        return $this;
    }

    /**
     * Set the sender.
     *
     * @param $sender
     *
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the message.
     *
     * @param $message
     *
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the template.
     *
     * @param $template
     *
     * @return $this
     */
    public function template($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set the type.
     *
     * @param $type
     *
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the token.
     *
     * @param string $token
     * @param string $num
     * @return $this
     */
    public function token($token, $num = '')
    {
        $this->tokens = array_merge($this->tokens, ["token$num" => $token]);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $parameters = [];
        if ($this->receptor)
            $parameters = array_merge($parameters, ['receptor' => $this->receptor]);

        if ($this->sender)
            $parameters = array_merge($parameters, ['sender' => $this->sender]);

        if ($this->message)
            $parameters = array_merge($parameters, ['message' => $this->message]);

        if ($this->type)
            $parameters = array_merge($parameters, ['type' => $this->type]);

        if ($this->template)
            $parameters = array_merge($parameters, ['template' => $this->template]);

        if (count($this->tokens))
            $parameters = array_merge($parameters, $this->tokens);

        return $parameters;
    }
}
