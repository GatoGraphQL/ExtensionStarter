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
             * Configuration for executing integration tests
             * using InstaWP
             *
             * @gatographql-project-action-maybe-required
             *
             * If executing integration tests in PROD using InstaWP
             * (via workflow `integration_tests`), uncomment the lines
             * below, and provide the template slug and repo ID to
             * spin a new InstaWP instance via GitHub Action
             * `instawp/wordpress-testing-automation`.
             *
             * Also configure the `INSTAWP_TOKEN` secret in your repo.
             *
             * @see https://github.com/InstaWP/wordpress-testing-automation
             * @see https://instawp.com/how-to-integrate-wordpress-with-git/
             *
             * You can provide many entries for InstaWP,
             * to execute tests against different environments
             * (eg: using different versions of PHP, and/or WordPress)
             */
            // [
            //     'templateSlug' => '{ INSTAWP_TEMPLATE_SLUG }',
            //     'repoID' => 0,
            // ],
        ];
    }
}
