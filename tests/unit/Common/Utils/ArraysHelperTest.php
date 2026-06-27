<?php

declare(strict_types=1);

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArraysHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ArraysHelper::class)]
class ArraysHelperTest extends TestCase
{
    public function testArrayIsContainedChecksNestedArraysPartially(): void
    {
        $expected = ['user' => ['roles' => ['admin' => true]]];
        $actual = ['user' => ['name' => 'potato', 'roles' => ['admin' => true, 'editor' => true]]];

        $this->assertTrue(ArraysHelper::arrayIsContained($expected, $actual));
    }

    public function testArrayIsContainedFailsWhenNestedExpectedKeyIsMissing(): void
    {
        $expected = ['user' => ['roles' => ['admin' => true, 'editor' => true]]];
        $actual = ['user' => ['name' => 'potato', 'roles' => ['admin' => true]]];

        $this->assertFalse(ArraysHelper::arrayIsContained($expected, $actual));
    }

    public function testAreRecursivelyEqualsStillRequiresNestedArraysToBeExact(): void
    {
        $array1 = ['user' => ['name' => 'potato']];
        $array2 = ['user' => ['name' => 'potato', 'enabled' => true]];

        $this->assertFalse(ArraysHelper::areRecursivelyEquals($array1, $array2));
    }
}
