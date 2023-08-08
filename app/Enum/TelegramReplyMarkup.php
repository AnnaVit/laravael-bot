<?php

declare(strict_types=1);

namespace App\Enum;

final class TelegramReplyMarkup
{
    public const INLINE_KEYBOARD = 'inline_keyboard';
    public const KEYBOARD = 'keyboard';
    public const REMOVE_KEYBOARD = 'remove_keyboard';
    public const FORCE_REPLY = 'force_reply';
}
