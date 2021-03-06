<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Model;

use Wvandenhaak\Configuration\Common\Contract\ReadableConfigInterface;
use Wvandenhaak\Configuration\Config\Model\Config;
use Wvandenhaak\Configuration\Setup\Model\Group\GroupCollection;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;

/**
 * Description of Setup
 *
 * @author Wesley van den haak
 */
class Setup implements ReadableConfigInterface
{

    private Config $config;
    private OptionCollection $options;
    private GroupCollection $groups;

    /**
     * @param OptionCollection $options
     * @param GroupCollection $groups
     * @param Config $config
     */
    public function __construct(
        OptionCollection $options,
        GroupCollection $groups,
        Config $config
    )
    {
        $this->options = $options;
        $this->groups = $groups;
        $this->config = $config;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->options->findOption($key)?->getDefaultValue();
    }

    /**
     * @return OptionCollection
     */
    public function getOptions(): OptionCollection
    {
        return $this->options;
    }

    /**
     * @return GroupCollection
     */
    public function getGroups(): GroupCollection
    {
        return $this->groups;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

}
