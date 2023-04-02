<?php

declare(strict_types=1);

namespace Jascha030\Wop\Meta;

final class PostMeta extends Meta
{
    /**
     * {@inheritDoc}
     */
    protected static function getMetaType(): string
    {
        return 'post';
    }
}
