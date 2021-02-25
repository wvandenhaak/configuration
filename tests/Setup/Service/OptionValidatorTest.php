<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Service;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Exception\ValidationException;
use Wvandenhaak\Configuration\Common\Value\Option\ArrayType;
use Wvandenhaak\Configuration\Common\Value\Option\StringType;
use wvandenhaak\configuration\Setup\Service\OptionValidator;
use Wvandenhaak\Configuration\Tests\data\classes\CustomOptionProvider;
use Wvandenhaak\Configuration\Tests\data\classes\InvalidCustomOptionProvider;

/**
 * Description of OptionValidatorTest
 *
 * @author Wesley van den haak
 */
class OptionValidatorTest extends TestCase
{

    private OptionValidator $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new OptionValidator();
    }

    /**
     * Test if the validator can validate a complete array of options
     * @return void
     */
    public function testCanValidate(): void
    {
        $optionsArray1 = ['key' => 'key_1', 'choices' => [], 'type' => StringType::class];
        $optionsArray2 = ['key' => 'key_2', 'choices' => ['a', 'b', 'c'], 'type' => ArrayType::class, 'default' => ['d']];

        $this->assertNull($this->subject->validate($optionsArray1));
        $this->assertNull($this->subject->validate($optionsArray2));
    }

    /**
     * Test if the validator can validate a array of options with a provider
     * @return void
     */
    public function testCanValidateProvider(): void
    {
        $optionsArray = ['key' => 'key_3', 'provider' => CustomOptionProvider::class];
        $this->assertNull($this->subject->validateProvider($optionsArray));
    }

    /**
     * Test if the class throws ValidationException(s) upon receiving invalid data
     * @dataProvider dataProviderInvalidOptionContents
     * @param array $data
     * @param string $message
     * @return void
     */
    public function testThrowingValidationExceptionsOnOption(
        array $data,
        string $message
    ): void
    {
        $this->expectException(ValidationException::class);

        $this->subject->validate($data);
    }

    /**
     * A dataProvider which holds different invalid values in order to test the loader if exceptions will be thrown
     * @return array
     */
    public function dataProviderInvalidOptionContents(): array
    {
        return [
            ["data" => [],                                                                           "message" => "Missing 'key' key"],
            ["data" => ['key' => 'key_1'],                                                           "message" => "Missing 'type' key"],
            ["data" => ['key' => 'key_1', 'type' => StringType::class, 'choices' => 'not_an_array'], "message" => "'choices' key must be an array"],
            ["data" => ['key' => 'key_1', 'type' => 'Not\Existing\ClassName'],                       "message" => "Given class for type does not exist"],
        ];
    }

    /**
     * Test if the class throws ValidationException(s) upon receiving invalid data
     * @dataProvider dataProviderInvalidOptionProviderContents
     * @param array $data
     * @param string $message
     * @return void
     */
    public function testThrowingValidationExceptionsOnOptionProvider(
        array $data,
        string $message
    ): void
    {
        $this->expectException(ValidationException::class);

        $this->subject->validateProvider($data);
    }

    /**
     * A dataProvider which holds different invalid values in order to test the loader if exceptions will be thrown
     * @return array
     */
    public function dataProviderInvalidOptionProviderContents(): array
    {
        return [
            ["data" => ['provider' => 'Not\Existing\ClassName'],                                     "message" => "Missing 'key' key for provider option"],
            ["data" => ['key' => 'key_2', 'provider' => ''],                                         "message" => "'provider' key may not be empty"],
            ["data" => ['key' => 'key_2', 'provider' => 'Not\Existing\ClassName'],                   "message" => "Given class for provider does not exist"],
            ["data" => ['key' => 'key_2', 'provider' => InvalidCustomOptionProvider::class],         "message" => "Provider class does not implement required interface"],
        ];
    }
}