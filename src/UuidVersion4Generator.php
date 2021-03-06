<?php
namespace Icecave\Druid;

use Icecave\Isolator\Isolator;

/**
 * Generates a Version 4 UUID as per RFC-4122.
 *
 * @link http://tools.ietf.org/html/rfc4122#section-4.4
 */
class UuidVersion4Generator implements UuidGeneratorInterface
{
    /**
     * @param Isolator|null $isolator
     */
    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    /**
     * Generate a version 4 UUID.
     *
     * @link http://tools.ietf.org/html/rfc4122#section-4.4
     *
     * @return UuidInterface
     */
    public function generate()
    {
        return new Uuid(
            $this->isolator->mt_rand(0, Uuid::MASK16),
            $this->isolator->mt_rand(0, Uuid::MASK16),
            $this->isolator->mt_rand(0, Uuid::MASK16),
            $this->isolator->mt_rand(0, Uuid::MASK16)
                & static::GENERATOR_VERSION_MASK
                | (static::GENERATOR_VERSION_VALUE << static::VERSION_OFFSET),
            $this->isolator->mt_rand(0, Uuid::MASK8)
                & static::GENERATOR_RESERVED_MASK
                | static::GENERATOR_RESERVED_VALUE,
            $this->isolator->mt_rand(0, Uuid::MASK8),
            $this->isolator->mt_rand(0, Uuid::MASK16),
            $this->isolator->mt_rand(0, Uuid::MASK16),
            $this->isolator->mt_rand(0, Uuid::MASK16)
        );
    }

    const GENERATOR_VERSION_MASK = 0x0fff;
    const GENERATOR_VERSION_VALUE = 4; // version 4
    const GENERATOR_RESERVED_MASK = 0x7f;
    const GENERATOR_RESERVED_VALUE = 0x80;

    const VERSION_OFFSET = 12;

    private $isolator;
}
