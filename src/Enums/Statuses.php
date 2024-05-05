<?php

namespace BrianLogan\LaravelUserStatus\Enums;

enum Statuses: string {
    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case AWAY = 'away';
    case INVISIBLE = 'invisible';
    case DO_NOT_DISTURB = 'do_not_disturb';
    case CUSTOM = 'custom';
}
