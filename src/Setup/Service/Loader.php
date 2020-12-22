<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Service;

use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use IceCake\AppConfigurator\Setup\Model\Setup;
use IceCake\AppConfigurator\Setup\Service\GroupParser;
use IceCake\AppConfigurator\Setup\Service\OptionParser;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{

    private GroupParser $groupParser;
    private OptionParser $optionParser;

    /**
     * @param GroupParser $groupParser
     * @param OptionParser $optionParser
     */
    public function __construct(
        GroupParser $groupParser,
        OptionParser $optionParser
    )
    {
        $this->groupParser = $groupParser;
        $this->optionParser = $optionParser;
    }

    /**
     * @param YamlDataSource $dataSource
     * @return Setup
     */
    public function load(YamlDataSource $dataSource): Setup
    {
        // Load
        $dataSource->validate();
        $setupArray = $dataSource->load();

        // @todo validate $setupArray

        $options = $this->optionParser->parse($setupArray['options']);
        $groups = $this->groupParser->parse($options, $setupArray['groups']);

        return new Setup($options, $groups);
    }
}
