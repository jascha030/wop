<?php

declare(strict_types=1);

namespace Jascha030\Wop\Meta;

use PhpOption\None;
use PhpOption\Option;
use PhpOption\Some;
use function add_metadata;
use function delete_metadata;
use function delete_post_meta;
use function get_metadata;
use function update_metadata;

abstract class Meta
{
    /**
     * Implement by returning a string representing the $meta_type argument.
     *
     * @return string
     *
     * @see  get_metadata()
     * @link https://developer.wordpress.org/reference/functions/get_metadata
     */
    abstract protected static function getMetaType(): string;

    /**
     * @param int    $postId
     * @param string $key
     * @param bool   $single
     *
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
     * @param int    $objectId
     * @param string $key
     * @param mixed  $value
     * @param bool   $unique
     *
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
     * @param int    $objectId
     * @param string $key
     * @param mixed  $value
     * @param string $prevValue
     *
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

        return $result === false
            ? None::create()
            : new Some($value);
    }

    /**
     * @param int    $objectId
     * @param string $key
     * @param mixed  $value
     * @param bool   $deleteAll
     *
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
