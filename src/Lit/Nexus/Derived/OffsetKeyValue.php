<?php

declare(strict_types=1);

namespace Lit\Nexus\Derived;

use Lit\Nexus\Interfaces\KeyValueInterface;
use Lit\Nexus\Traits\KeyValueTrait;

class OffsetKeyValue implements KeyValueInterface
{
    use KeyValueTrait;

    protected $content;

    protected function __construct($content)
    {
        if (!($content instanceof \ArrayAccess) && !is_array($content)) {
            throw new \InvalidArgumentException();
        }

        $this->content = $content;
    }

    /**
     * @param array|\ArrayAccess $content
     * @return static
     */
    public static function wrap($content)
    {
        if ($content instanceof static) {
            return $content;
        }

        return new static($content);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value)
    {
        $this->content[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key)
    {
        unset($this->content[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->content[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key)
    {
        return isset($this->content[$key]);
    }

    /**
     * @return array|\ArrayAccess
     */
    public function getContent()
    {
        return $this->content;
    }
}
