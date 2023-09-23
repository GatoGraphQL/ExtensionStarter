<?php

declare(strict_types=1);

namespace DollyShepherd\HelloDolly\Hooks;

use PoP\Root\App;
use PoP\Root\Hooks\AbstractHookSet;

class UnsetHelloDollyHookSet extends AbstractHookSet
{
    protected function init(): void
    {
        // As this is a sample plugin, remove the "Hello Dolly" notice in the admin
        App::removeAction('admin_notices', 'hello_dolly');
        App::removeAction('admin_head', 'dolly_css');
    }
}
