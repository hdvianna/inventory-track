<?php

namespace hdvianna\InventoryTrack\Tests\UseCases;

use Faker\Factory;
use Faker\Generator;
use hdvianna\InventoryTrack\Adapters\InventoryAdapter;
use hdvianna\InventoryTrack\Entities\Inventory;
use hdvianna\InventoryTrack\Repositories\InventoryRepository;
use hdvianna\InventoryTrack\UseCases\ManageInventory;
use hdvianna\InventoryTrack\UseCases\Result;
use hdvianna\InventoryTrack\UseCases\ResultStatus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

class ManageInventoryTest extends TestCase
{

    private static Generator $faker;

    /**
     * @covers hdvianna\InventoryTrack\UseCases\ManageInventory
     * @covers hdvianna\InventoryTrack\UseCases\Result
     * @covers hdvianna\InventoryTrack\Entities\Inventory
     * @dataProvider givenTestState
     * @param $givenAdapter
     * @param $givenRepository
     * @param $expectedResult
     * @return void
     */
    public function testCreateInventory(InventoryAdapter $givenAdapter, InventoryRepository $givenRepository, Result $expectedResult): void
    {
        $actualResult = $this->whenCreatingInventory($givenAdapter, $givenRepository);
        $this->thenResultInCreationSuccess($expectedResult, $actualResult);
    }

    private function givenTestState(): array
    {
        self::$faker = Factory::create();
        $numberOfTests = 2;
        $serialNumbers = $this->makeSerialNumbers($numberOfTests);
        $newInventories = $this->makeInventories($numberOfTests, $serialNumbers);
        $oldInventories = $this->makeInventories($numberOfTests, $serialNumbers);
        return [
            [
                $this->makeInventoryAdapterDouble($newInventories[0]),
                $this->makeInventoryRepositoryDouble(null, $newInventories[0], $serialNumbers[0], 1),
                new Result(true, ResultStatus::CreationSuccess, $newInventories[0])
            ], [
                $this->makeInventoryAdapterDouble($newInventories[1]),
                $this->makeInventoryRepositoryDouble($oldInventories[1], $newInventories[1], $serialNumbers[1], 0),
                new Result(false, ResultStatus::CreationFailedInventoryAlreadyExists, null)
            ]
        ];
    }

    /**
     * @param int $size
     * @return string[]
     */
    private function makeSerialNumbers(int $size): array
    {
        $serialNumbers = [];
        for ($i = 0; $i < $size; $i++) {
            $serialNumbers[] = self::$faker->regexify("[A-Z0-9]{5}\-[A-Z0-9]{3}");
        }
        return $serialNumbers;
    }

    /**
     * @param array $serialNumbers
     * @return Inventory[]
     */
    private function makeInventories(int $size, array $serialNumbers): array
    {
        $inventories = [];
        for ($i = 0; $i < $size; $i++) {
            $inventories[] = new Inventory(self::$faker->word(), $serialNumbers[$i], self::$faker->randomFloat());
        }
        return $inventories;
    }

    private function makeInventoryAdapterDouble(Inventory $inventory): Stub
    {
        $stub = $this->createStub(InventoryAdapter::class);
        $stub->method("getName")
            ->willReturn($inventory->name);
        $stub->method("getSerialNumber")
            ->willReturn($inventory->serialNumber);
        $stub->method("getValue")
            ->willReturn($inventory->value);
        return $stub;
    }

    private function makeInventoryRepositoryDouble(?Inventory $oldInventory, Inventory $newInventory, string $serialNumber, int $numberOfInsertCalls): MockObject
    {
        $mock = $this->createMock(InventoryRepository::class);
        $mock->expects($this->once())
            ->method("findBySerialNumber")
            ->with($serialNumber)
            ->willReturn($oldInventory);
        $mock->expects($this->exactly($numberOfInsertCalls))
            ->method("insert")
            ->with($newInventory);
        return $mock;
    }

    private function whenCreatingInventory(InventoryAdapter $adapter, InventoryRepository $repository): Result
    {
        $manageInventory = new ManageInventory($repository);
        return $manageInventory->create($adapter);
    }

    private function thenResultInCreationSuccess(Result $expectedResult, Result $actualResult): void
    {
        $this->assertEquals($expectedResult, $actualResult);
    }


}
