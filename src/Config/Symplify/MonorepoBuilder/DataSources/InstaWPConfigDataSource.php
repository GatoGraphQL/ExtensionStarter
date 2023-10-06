<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\InstaWPConfigDataSource as UpstreamInstaWPConfigDataSource;

class InstaWPConfigDataSource extends UpstreamInstaWPConfigDataSource
{
    /**
     * @return array<array<string,mixed>>
     */
    public function getInstaWPConfigEntries(): array
    {
        return [
            /**
             * @gatographql-project-info
             *
             * If executing integration tests in PROD using InstaWP
             * (via workflow `integration_tests`), provide the
             * template slug and repo ID to spin a new InstaWP instance
             * via GitHub Action `instawp/wordpress-testing-automation`.
             *
             * Also configure the `INSTAWP_TOKEN` secret in your repo.
             *
             * @see https://github.com/InstaWP/wordpress-testing-automation
             * @see https://instawp.com/how-to-integrate-wordpress-with-git/
             */
            [
                'templateSlug' => '{ INSTAWP_TEMPLATE_SLUG }',
                'repoID' => 0,
            ],
        ];
    }
}
