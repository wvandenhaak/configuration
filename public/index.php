<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../vendor/autoload.php';

////////////////////////

use IceCake\AppConfigurator\Config\Model\Config\Config;
use IceCake\AppConfigurator\Config\Service\Loader\{
    DataSource\ArrayDataSource,
    DataSource\YamlDataSource,
    Loader
};
use IceCake\AppConfigurator\Config\Service\Merger;
use IceCake\AppConfigurator\Config\Service\Parser;
use IceCake\AppConfigurator\Config\Service\Writer\{
    DataStore\ArrayDataStore,
    DataStore\YamlDataStore,
    Writer
};

use IceCake\AppConfigurator\Setup\Model\Setup;
use IceCake\AppConfigurator\Setup\Loader as SetupLoader;

$start = microtime(true);

$loader = new Loader();
$parser = new Parser();
$merger = new Merger();

$projectRootFolder = dirname(__DIR__);
$writer = new Writer($projectRootFolder);


// Load PHP array CONFIG
$arrayFilePath = 'configuration.php';
$arrayDataSource = new ArrayDataSource($arrayFilePath);

$arrayData = $loader->load($arrayDataSource);

$arrayConfig = $parser->parse($arrayData);


// Load YAML CONFIG
$yamlFilePath = 'configuration.yaml';
$yamlDataSource = new YamlDataSource($yamlFilePath);

$yamlData = $loader->load($yamlDataSource);

$yamlConfig = $parser->parse($yamlData);


// Merge configs
$mergedConfig = $merger->merge($yamlConfig, $arrayConfig);


// Write configs
$arrayDataStore = new ArrayDataStore($arrayConfig, 'test_array.php');
$yamlDataStore = new YamlDataStore($yamlConfig, 'test_yaml.yaml');

//$writer->save($arrayDataStore);
//$writer->save($yamlDataStore);

$eind = microtime(true);
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec');


// GET AND PARSE FULL CONFIG

$setupLoader = new SetupLoader();
$setup = $setupLoader->load($projectRootFolder . '/package-config.yaml');

// Dump PEAK USAGE IN MB's

$eind = microtime(true);
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec');

?>
<html>
    <head>
    </head>
    <body>
        <h1>SUP</h1>
        <pre>
        <?= var_dump($arrayConfig); ?>
        <?= var_dump($yamlConfig); ?>
        <?= var_dump($mergedConfig); ?>
        <?= var_dump($setup); ?>
        </pre>
    </body>
</html>