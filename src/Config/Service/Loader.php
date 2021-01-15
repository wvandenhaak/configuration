<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Config\Service;

use Wvandenhaak\Configuration\Common\Contract\DataSourceInterface;
use Wvandenhaak\Configuration\Config\Model\Config;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{

    private Parser $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param DataSourceInterface $dataSource
     * @return Config
     */
    public function load(DataSourceInterface $dataSource): Config
    {
        $dataSource->validate();

        // Load data
        $data = $dataSource->load();

        return $this->parser->parse($data);
    }

}
