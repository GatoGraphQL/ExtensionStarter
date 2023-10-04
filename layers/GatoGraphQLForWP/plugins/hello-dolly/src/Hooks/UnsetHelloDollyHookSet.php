<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly\Hooks;

use PoP\Root\Hooks\AbstractHookSet;

class UnsetHelloDollyHookSet extends AbstractHookSet
{
    protected function init(): void
    {
        // As this is a sample plugin, remove the "Hello Dolly" notice in the admin
        \remove_action('admin_notices', 'hello_dolly');
        \remove_action('admin_head', 'dolly_css');
    }
}
