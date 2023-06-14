<?php

declare(strict_types=1);

namespace Jascha030\Wop\Meta;

use PhpOption\None;
use PhpOption\Option;
use PhpOption\Some;
use function add_metadata;
use function delete_metadata;
use function get_metadata;
use function update_metadata;

abstract class Meta
{
    /**
     * Implement by returning a string representing the $meta_type argument.
     *
     * @see  get_metadata()
     * @see https://developer.wordpress.org/reference/functions/get_metadata
     */
    abstract protected static function getMetaType(): string;

    /**
     * @return Option<mixed>
     */
    public static function get(int $postId, string $key, bool $single = false): Option
    {
        $result = get_metadata(static::getMetaType(), $postId, $key, $single);

        return empty($result)
            ? None::create()
            : new Some($result);
    }

    /**
     * @return Option<int>
     */
    public static function add(int $objectId, string $key, mixed $value, bool $unique = false): Option
    {
        $result = add_metadata(static::getMetaType(), $objectId, $key, $value, $unique);

        return empty($result)
            ? None::create()
            : new Some($result);
    }

    /**
     * @return Option<mixed>
     */
    public static function update(int $objectId, string $key, mixed $value, string $prevValue = ''): Option
    {
        $result = update_metadata(
            static::getMetaType(),
            $objectId,
            $key,
            $value,
            $prevValue
        );

        return false === $result
            ? None::create()
            : new Some($value);
    }

    /**
     * @return Option<bool>
     */
    public static function delete(int $objectId, string $key, mixed $value, bool $deleteAll = false): Option
    {
        return Option::fromValue(
            delete_metadata(
                static::getMetaType(),
                $objectId,
                $key,
                $value,
                $deleteAll
            ),
            false
        );
    }
}
