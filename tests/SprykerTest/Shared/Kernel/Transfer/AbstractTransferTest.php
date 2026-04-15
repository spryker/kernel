<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Shared\Kernel\Transfer;

use ArrayObject;
use Codeception\Test\Unit;
use InvalidArgumentException;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use SprykerTest\Shared\Kernel\Transfer\Fixtures\AbstractTransfer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Shared
 * @group Kernel
 * @group Transfer
 * @group AbstractTransferTest
 * Add your own group annotations below this line
 */
class AbstractTransferTest extends Unit
{
    public function testFromArrayShouldReturnInstanceWithSetDefaultTypes(): void
    {
        $data = [
            'string' => 'string',
            'int' => 1,
            'bool' => true,
            'array' => [],
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data);

        $this->assertSame('string', $transfer->getString());
        $this->assertSame(1, $transfer->getInt());
        $this->assertTrue($transfer->getBool());
        $this->assertIsArray($transfer->getArray());
    }

    public function testFromArrayShouldReturnInstanceWithSetTransferObject(): void
    {
        $data = [
            'transfer' => new AbstractTransfer(),
            'transferCollection' => [
                new AbstractTransfer(),
            ],
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data);

        $this->assertInstanceOf(TransferInterface::class, $transfer->getTransfer());
        $this->assertInstanceOf(ArrayObject::class, $transfer->getTransferCollection());
        $this->assertCount(1, $transfer->getTransferCollection());
    }

    public function testFromArrayShouldWorkForGivenTransferAndInnerTransfers(): void
    {
        $data = [
            'string' => 'foo',
            'int' => 1,
            'transfer' => [
                'string' => 'foo',
                'int' => 1,
            ],
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data);

        $this->assertInstanceOf(TransferInterface::class, $transfer->getTransfer());
    }

    public function testFromArrayWithIgnoreMissingPropertyFalseShouldThrowExceptionIfPropertyIsInArrayButNotInObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $data = [
            'not existing property key' => '',
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data);
    }

    public function testFromArrayWithIgnoreMissingPropertyTrueShouldNotThrowExceptionIfPropertyIsInArrayButNotInObject(): void
    {
        $data = [
            'not existing property key' => '',
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data, true);
    }

    public function testFromArrayWithNestedTransferCollectionShouldReturnValidDataFromEmbeddedTransferObjects(): void
    {
        $data = [
            'string' => 'level1',
            'int' => 1,
            'transfer_collection' => [
                [
                    'string' => 'level2',
                    'int' => 1,
                ], [
                    'string' => 'level2',
                    'int' => 2,
                    'transfer_collection' => [
                        [
                            'string' => 'level3',
                            'int' => 1,
                        ], [
                            'string' => 'level3',
                            'int' => 2,
                        ],
                    ],
                ],
            ],
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data);

        $this->assertSame('level1', $transfer->getString());
        $this->assertSame('level2', $transfer->getTransferCollection()[0]->getString());
        $this->assertSame('level3', $transfer->getTransferCollection()[1]->getTransferCollection()[0]->getString());
    }

    public function testToArrayShouldReturnArrayWithAllPropertyNamesAsKeysAndNullValuesWhenNoPropertyWasSet(): void
    {
        $transfer = new AbstractTransfer();
        $given = $transfer->toArray();
        $expected = [
            'string' => null,
            'int' => null,
            'bool' => null,
            'array' => [],
            'transfer' => null,
            'transfer_collection' => new ArrayObject(),
        ];

        $this->assertEquals($expected, $given);
    }

    public function testToArrayShouldReturnArrayWithAllPropertyNamesAsKeysAndNullValuesWhenNoPropertyWasSetCamelCased(): void
    {
        $transfer = new AbstractTransfer();
        $given = $transfer->toArray(true, true);
        $expected = [
            'string' => null,
            'int' => null,
            'bool' => null,
            'array' => [],
            'transfer' => null,
            'transferCollection' => new ArrayObject(),
        ];

        $this->assertEquals($expected, $given);
    }

    public function testToArrayShouldReturnArrayWithAllPropertyNamesAsKeysAndFilledValuesCamelCasedAndRecursived(): void
    {
        $transfer = (new AbstractTransfer())
            ->setInt(100)
            ->setTransfer(
                (new AbstractTransfer())
                    ->setInt(200),
            )
            ->setTransferCollection(new ArrayObject([
                (new AbstractTransfer())
                    ->setInt(300),
            ]));

        $given = $transfer->toArray(true, true);
        $expected = [
            'string' => null,
            'int' => 100,
            'bool' => null,
            'array' => [],
            'transfer' => [
                'string' => null,
                'int' => 200,
                'bool' => null,
                'array' => [],
                'transfer' => null,
                'transferCollection' => new ArrayObject(),
            ],
            'transferCollection' => [
                [
                    'string' => null,
                    'int' => 300,
                    'bool' => null,
                    'array' => [],
                    'transfer' => null,
                    'transferCollection' => new ArrayObject(),
                ],
            ],
        ];

        $this->assertEquals($expected, $given);
    }

    public function testManyWaysToAccessAProperty(): void
    {
        $transfer = (new AbstractTransfer())
            ->setInt(100)
            ->setTransferCollection(new ArrayObject());

        //Method call
        $this->assertSame(100, $transfer->getInt());
        $this->assertEquals(new ArrayObject(), $transfer->getTransferCollection());

        //Transfer to array
        $this->assertSame(100, $transfer->toArray()['int']);
        $this->assertEquals(new ArrayObject(), $transfer->toArray()['transfer_collection']);

        //Transfer to array with camelcase
        $this->assertSame(100, $transfer->toArray(true, true)['int']);
        $this->assertEquals(new ArrayObject(), $transfer->toArray(true, true)['transferCollection']);

        //ArrayAccess
        $this->assertSame(100, $transfer['int']);
        $this->assertEquals(new ArrayObject(), $transfer['transferCollection']);
    }

    public function testToArrayShouldReturnArrayWithAllPropertyNamesAsKeysAndFilledValues(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);

        $given = $transfer->toArray();
        $expected = [
            'string' => 'foo',
            'int' => 2,
            'bool' => null,
            'array' => [],
            'transfer' => null,
            'transfer_collection' => new ArrayObject(),
        ];

        $this->assertEquals($expected, $given);
    }

    public function testToArrayWithRecursiveTrueShouldReturnArrayWithAllPropertyNamesAsKeysAndFilledValuesAndRecursiveFilledInnerObjects(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);

        $innerTransfer = new AbstractTransfer();
        $innerTransfer->setString('bar');
        $innerTransfer->setInt(3);

        $transfer->setTransfer($innerTransfer);

        $given = $transfer->toArray();
        $expected = [
            'string' => 'foo',
            'int' => 2,
            'bool' => null,
            'array' => [],
            'transfer' => [
                'string' => 'bar',
                'int' => 3,
                'bool' => null,
                'array' => [],
                'transfer' => null,
                'transfer_collection' => new ArrayObject(),
            ],
            'transfer_collection' => new ArrayObject(),
        ];

        $this->assertEquals($expected, $given);
    }

    public function testToArrayWithRecursiveFalseShouldReturnArrayWithAllPropertyNamesAsKeysAndWithoutRecursiveFilledInnerObjects(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);

        $innerTransfer = new AbstractTransfer();
        $innerTransfer->setString('bar');
        $innerTransfer->setInt(3);

        $transfer->setTransfer($innerTransfer);

        $given = $transfer->toArray(false);
        $expected = [
            'string' => 'foo',
            'int' => 2,
            'bool' => null,
            'array' => [],
            'transfer' => $innerTransfer,
            'transfer_collection' => new ArrayObject(),
        ];

        $this->assertEquals($expected, $given);
    }

    public function testModifiedToArrayShouldReturnArrayOnlyWithModifiedProperty(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);

        $given = $transfer->modifiedToArray();
        $expected = [
            'string' => 'foo',
            'int' => 2,
        ];

        $this->assertEquals($expected, $given);
    }

    public function testModifiedToArrayWithRecursiveTrueShouldReturnArrayWithAllPropertyNamesAsKeysAndFilledValuesAndRecursiveFilledInnerObjectsWhichWhereModified(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);
        $transfer->setArray([]);

        $innerTransfer = new AbstractTransfer();
        $innerTransfer->setString('bar');
        $innerTransfer->setInt(3);

        $transfer->setTransfer($innerTransfer);

        $given = $transfer->modifiedToArray(true);
        $expected = [
            'string' => 'foo',
            'int' => 2,
            'array' => [],
            'transfer' => [
                'string' => 'bar',
                'int' => 3,
            ],
        ];

        $this->assertEquals($expected, $given);
    }

    public function testSerializeAndUnSerializeShouldReturnUnSerializedInstance(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);

        $serialized = serialize($transfer);
        $unSerialized = unserialize($serialized);

        $given = $unSerialized->toArray();
        $expected = [
            'string' => 'foo',
            'int' => 2,
            'bool' => null,
            'array' => [],
            'transfer' => null,
            'transfer_collection' => new ArrayObject(),
        ];

        $this->assertEquals($expected, $given);
    }

    public function testSerializeTransferAffectsModifiedDataOnly(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');

        $serialized = serialize($transfer);
        $unserialized = unserialize($serialized);

        $expected = [
            'string' => 'foo',
        ];

        $this->assertEquals($expected, $unserialized->modifiedToArray());
    }

    public function testTransferUnserializationIsIdempotent(): void
    {
        $transfer = new AbstractTransfer();
        $transfer
            ->setString('foo')
            ->setTransfer((new AbstractTransfer())->setInt(123))
            ->setTransferCollection(new ArrayObject([
                (new AbstractTransfer())->setBool(false),
                (new AbstractTransfer())->setBool(true),
            ]));

        $serialized = $transfer->serialize();
        $unserializedTransfer = new AbstractTransfer();
        $unserializedTransfer->unserialize($serialized);

        $this->assertEquals($transfer, $unserializedTransfer);
    }

    public function testCloneShouldReturnFullClonedObject(): void
    {
        $transfer = new AbstractTransfer();
        $transfer->setString('foo');
        $transfer->setInt(2);
        $transfer->setTransfer(new AbstractTransfer());

        $clonedTransfer = clone $transfer;

        $this->assertEquals($transfer, $clonedTransfer);
    }

    public function testFromArrayShouldWorkWithCyclicReferences(): void
    {
        $transfer = new AbstractTransfer();

        $data = [
            'string' => 'foo',
            'transfer' => [
                'string' => 'bar',
                'transfer' => $transfer,
            ],
        ];

        $transfer->fromArray($data);

        $this->assertSame('foo', $transfer->getString());
        $this->assertSame('bar', $transfer->getTransfer()->getString());
        $this->assertSame('foo', $transfer->getTransfer()->getTransfer()->getString());
        $this->assertSame('bar', $transfer->getTransfer()->getTransfer()->getTransfer()->getString());
    }

    public function testFromArrayToArrayConversionShouldWorkWithEmptyDataForTheSameTransferType(): void
    {
        $transfer1 = new AbstractTransfer();
        $transfer2 = new AbstractTransfer();

        $transfer1->fromArray($transfer2->toArray());
    }

    public function testFromArrayToArrayConversionShouldWorkForTheSameTransferType(): void
    {
        $transfer1 = new AbstractTransfer();
        $data = [
            'string' => 'foo',
            'transfer' => [
                'string' => 'bar',
            ],
        ];
        $transfer1->fromArray($data);

        $transfer2 = new AbstractTransfer();
        $transfer2->fromArray($transfer1->toArray());

        $this->assertSame('foo', $transfer2->getString());
        $this->assertSame('bar', $transfer2->getTransfer()->getString());
    }

    public function testSetTransferCollectionWithArrayObject(): void
    {
        $transfer = new AbstractTransfer();
        $collection = new ArrayObject([
            new AbstractTransfer(),
            new AbstractTransfer(),
        ]);
        $transfer->setTransferCollection($collection);

        $this->assertCount(2, $transfer->getTransferCollection());
    }

    /**
     * Regression: when a collection element is already a TransferInterface (not an array),
     * processArrayObject must preserve the existing object instead of replacing it with an empty instance.
     */
    public function testFromArrayShouldPreserveDataWhenCollectionElementIsAlreadyATransferObject(): void
    {
        $innerTransfer = (new AbstractTransfer())->setInt(42);

        $data = [
            'transfer_collection' => [
                $innerTransfer,
            ],
        ];

        $transfer = new AbstractTransfer();
        $transfer->fromArray($data);

        $this->assertSame(42, $transfer->getTransferCollection()[0]->getInt());
    }

    /**
     * Regression: toArray(false) returns the raw ArrayObject for collection properties.
     * A subsequent fromArray() call must round-trip the collection data without data loss.
     */
    public function testFromArrayToArrayNonRecursiveRoundTripShouldPreserveCollectionData(): void
    {
        $source = (new AbstractTransfer())
            ->setTransferCollection(new ArrayObject([
                (new AbstractTransfer())->setInt(42),
            ]));

        $target = new AbstractTransfer();
        $target->fromArray($source->toArray(false));

        $this->assertSame(42, $target->getTransferCollection()[0]->getInt());
    }
}
