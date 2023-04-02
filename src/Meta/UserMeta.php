<?php

declare(strict_types=1);

namespace Jascha030\Wop\Meta;

final class UserMeta extends Meta
{
    /**
     * {@inheritDoc}
     */
    protected static function getMetaType(): string
    {
        return 'user';
    }
}
