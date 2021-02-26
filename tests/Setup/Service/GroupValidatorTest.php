<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Service;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Exception\ValidationException;
use Wvandenhaak\Configuration\Setup\Service\GroupValidator;

/**
 * Description of GroupValidatorTest
 */
class GroupValidatorTest extends TestCase
{

    private GroupValidator $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new GroupValidator();
    }

    /**
     * Test if the validator can validate an array
     * @return void
     */
    public function testCanValidate(): void
    {
        $groupsArray = ['name' => 'Name of Group 1', 'keys' => ['key_2']];

        $this->assertNull($this->subject->validateGroup($groupsArray));
    }

    /**
     * Test if the class throws ValidationException(s) upon receiving invalid data
     * @dataProvider dataProviderInvalidSetupContents
     * @param array $data
     * @param string $message
     * @return void
     */
    public function testThrowingValidationExceptions(
        array $data,
        string $message
    ): void
    {
        $this->expectException(ValidationException::class);

        $this->subject->validateGroup($data);
    }

    /**
     * A dataProvider which holds different invalid values in order to test the loader if exceptions will be thrown
     * @return array
     */
    public function dataProviderInvalidSetupContents(): array
    {
        return [
            ["data" => [],                                                  "message" => "Missing 'name' key"],
            ["data" => ['name' => 'GroupName'],                             "message" => "Missing 'keys' key"],
            ["data" => ['name' => 'GroupName', 'keys' => 'not_an_array'],   "message" => "Key 'keys' must be an array"]
        ];
    }
}