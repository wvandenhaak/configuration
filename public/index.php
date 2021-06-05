<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../vendor/autoload.php';

////////////////////////

use Wvandenhaak\Configuration\Common\DataSource\DataSourceFactory;
use Wvandenhaak\Configuration\Common\DataStore\DataStoreFactory;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

use Wvandenhaak\Configuration\Config\Service\Loader;
use Wvandenhaak\Configuration\Config\Service\Merger;
use Wvandenhaak\Configuration\Config\Service\Parser;
use Wvandenhaak\Configuration\Config\Service\Writer;

use Wvandenhaak\Configuration\Setup\Service\GroupParser;
use Wvandenhaak\Configuration\Setup\Service\Loader as SetupLoader;
use Wvandenhaak\Configuration\Setup\Service\OptionParser;

$start = microtime(true);

$parser = new Parser();
$loader = new Loader($parser);
$merger = new Merger();
$writer = new Writer();
$dateStoreFactory = new DataStoreFactory();
$dataSourceFactory = new DataSourceFactory();

// Load PHP array CONFIG
$arrayFilePath = new FilePathValue('configuration.php');
$arrayDataSource = $dataSourceFactory->createArrayDataSource($arrayFilePath);

$arrayConfig = $loader->load($arrayDataSource);

$eind = microtime(true);
echo '<h1>Array Config LOAD:</h1>';
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec <br />');


// Load YAML CONFIG
$yamlFilePath = new FilePathValue('configuration.yaml');
$yamlDataSource = $dataSourceFactory->createYamlDataSource($yamlFilePath);

$yamlConfig = $loader->load($yamlDataSource);

$eind = microtime(true);
echo '<h1>YAML Config LOAD:</h1>';
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec <br />');


// Merge configs
$mergedConfig = $merger->merge($arrayConfig, $yamlConfig);

$eind = microtime(true);
echo '<h1>Array+Yaml Config merge:</h1>';
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec <br />');


// Write configs
$basePath = dirname(__DIR__) . '/public/files';
$arrayDataStoreFilePath = new FilePathValue($basePath.'/test_array.php');
$yamlDataStoreFilePath = new FilePathValue($basePath.'/test_yaml.yaml');

$arrayDataStore = $dateStoreFactory->createArrayDataStore($arrayDataStoreFilePath);
$yamlDataStore = $dateStoreFactory->createYamlDataStore($yamlDataStoreFilePath);

//$writer->save($arrayConfig, $arrayDataStore);
//$writer->save($yamlConfig, $yamlDataStore);

$eind = microtime(true);
echo '<h1>Total time all above:</h1>';
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec <br />');


// GET AND PARSE FULL CONFIG
$groupParser = new GroupParser();
$optionParser = new OptionParser();
$setupLoader = new SetupLoader($groupParser, $optionParser);

$setupFilepath = new FilePathValue('package-config.yaml');
$setupDataSource = $dataSourceFactory->createYamlDataSource($setupFilepath);
$setup = $setupLoader->load($setupDataSource);

// Dump PEAK USAGE IN MB's

$eind = microtime(true);
echo '<h1>Setup loading and parsing:</h1>';
echo 'Memory Usage: ' . (memory_get_peak_usage(true) / 1024) / 1024 . ' MB <br />';
echo($eind - $start . ' sec <br />');

?>
<html lang="en">
<head>
    <title>App Configurator</title>
</head>
<body>
    <pre>
    <?= var_dump($arrayConfig); ?>

    <?= var_dump($yamlConfig); ?>

    <?= var_dump($mergedConfig); ?>
    </pre>

    <h1>Groepen</h1>
    <?php foreach ($setup->getGroups() as $group): ?>
        <fieldset>
            <legend><?= $group->getName(); ?></legend>
            <?php foreach ($group->getOptions() as $option): ?>
                <h3>KEY: <?= $option->getKey(); ?></h3>
                <ul>
                    <li>DEFAULT: <?= var_dump($option->getDefaultValue()); ?></li>
                    <li>CHOICES:
                        <ul>
                            <?php foreach ($option->getChoices() as $choice): ?>
                                <li>Choice: <?= var_dump($choice) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            <?php endforeach; ?>
        </fieldset>
    <?php endforeach; ?>
</body>
</html>