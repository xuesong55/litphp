<?php

declare(strict_types=1);

namespace Lit\Nexus\Derived;

use Lit\Nexus\Interfaces\KeyValueInterface;
use Lit\Nexus\Interfaces\ReadableKeyValueInterface;

class FrozenKeyValue implements ReadableKeyValueInterface
{
    /**
     * @var KeyValueInterface
     */
    protected $keyValue;

    protected function __construct(KeyValueInterface $keyValue)
    {
        $this->keyValue = $keyValue;
    }

    /**
     * @param KeyValueInterface $keyValue
     * @return static
     */
    public static function wrap(KeyValueInterface $keyValue)
    {
        if ($keyValue instanceof static) {
            return $keyValue;
        }
        return new static($keyValue);
    }

    /**
     * @param array|\ArrayAccess $content
     * @return static
     */
    public static function wrapOffset($content)
    {
        return self::wrap(OffsetKeyValue::wrap($content));
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->keyValue->get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key)
    {
        return $this->keyValue->exists($key);
    }
}
