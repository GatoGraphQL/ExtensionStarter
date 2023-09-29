<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject;

final class Option
{
    /**
     * @var string
     */
    public final const COPY_UPSTREAM_MONOREPO_FOLDER_ENTRIES = 'copy-upstream-monorepo-folder-entries';
    /**
     * @var string
     */
    public final const COPY_UPSTREAM_MONOREPO_FILE_ENTRIES = 'copy-upstream-monorepo-file-entries';
}
