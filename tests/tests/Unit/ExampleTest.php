<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Http\Controllers\TestController;
use DTApi\Repository\UserRepository;

class ExampleTest extends TestCase
{
    public function testWillExpireAtWithin90Hours()
    {
        $dueTime = '2023-01-01 12:00:00';
        $createdAt = '2022-12-31 12:00:00';

        $result = TestController::willExpireAt($dueTime, $createdAt);

        $this->assertEquals($dueTime, $result);
    }

    public function testWillExpireAtWithin24Hours()
    {
        $dueTime = '2023-01-01 12:00:00';
        $createdAt = '2023-01-01 09:30:00';

        $result = TestController::willExpireAt($dueTime, $createdAt);

        $expectedTime = (new DateTime($createdAt))->add(new \DateInterval('PT90M'))->format('Y-m-d H:i:s');

        $this->assertEquals($expectedTime, $result);
    }

    public function testWillExpireAtWithin72Hours()
    {
        $dueTime = '2023-01-01 12:00:00';
        $createdAt = '2022-12-30 12:00:00';

        $result = TestController::willExpireAt($dueTime, $createdAt);

        $expectedTime = (new DateTime($createdAt))->add(new \DateInterval('PT16H'))->format('Y-m-d H:i:s');

        $this->assertEquals($expectedTime, $result);
    }

    public function testWillExpireAtMoreThan72Hours()
    {
        $dueTime = '2023-01-01 12:00:00';
        $createdAt = '2022-12-25 12:00:00';

        $result = TestController::willExpireAt($dueTime, $createdAt);

        $expectedTime = (new DateTime($dueTime))->sub(new \DateInterval('PT48H'))->format('Y-m-d H:i:s');

        $this->assertEquals($expectedTime, $result);
    }

    public function testCreateOrUpdateWithValidData()
    {
        // Mock the request data
        $request = [
            'role' => 'some_role',
            'name' => 'John Doe',
            // ... add other required fields here
        ];

        // Mock the User model
        $userModelMock = $this->createMock(User::class);
        $userModelMock->method('save')->willReturn(true);

        // Mock the UserMeta model
        $userMetaModelMock = $this->createMock(UserMeta::class);
        $userMetaModelMock->method('save')->willReturn(true);

        // Mock other necessary models as needed

        // Mock the findOrFail method
        User::method('findOrFail')->willReturn($userModelMock);

        // Call the function
        $result = UserRepository::createOrUpdate(null, $request);

        // Assert that the result is a User instance or false
        $this->assertInstanceOf(User::class, $result);
    }
}
