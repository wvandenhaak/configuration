<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Service;

use Wvandenhaak\Configuration\Common\Enum\GroupEnum;
use Wvandenhaak\Configuration\Common\Exception\ValidationException;

/**
 * A validator to validate an array on required keys and values
 */
class GroupValidator
{

    /**
     * @param array $group
     * @return void
     * @throws ValidationException
     */
    public function validateGroup(array $group): void
    {
        if (empty($group[GroupEnum::KEY_NAME])) {
            throw new ValidationException("Group missing required 'name' key.");
        }

        if (empty($group[GroupEnum::KEY_KEYS])) {
            throw new ValidationException("Group missing required 'keys' key.");
        }

        if (is_array($group[GroupEnum::KEY_KEYS]) === false) {
            throw new ValidationException(sprintf(
                "Group '%s' is missing an array of keys.",
                $group[GroupEnum::KEY_NAME]
            ));
        }
    }
}