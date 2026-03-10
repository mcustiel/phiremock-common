<?php

namespace Mcustiel\Phiremock\Tests\Unit\Domain\Condition;

use Mcustiel\Phiremock\Domain\Condition\Pattern;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class PatternTest extends TestCase
{
    /**
     * @dataProvider correctPatternDataProvider
     */
    public function testCorrectPattern(string $regex): void
    {
        $this->assertInstanceOf(
            Pattern::class,
            new Pattern($regex)
        );
    }

    /**
     * @return array<array<string, string>>
     */
    public static function correctPatternDataProvider(): array
    {
        return [
            'any_string_no_modifier' => ['/.*/'],
            'any_string_with_modifier' => ['/.*/i'],
            'any_string_no_modifier_custom_escape' => ['@.*@'],
            'any_string_with_modifier_custom_escape' => ['@.*@i'],
        ];
    }

    /**
     * @dataProvider incorrectPatternDataProvider
     */
    public function testIncorrectPattern(string $regex): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Pattern($regex);
    }

    /**
     * @return array<array<string, string>>
     */
    public static function incorrectPatternDataProvider(): array
    {
        return [
            'empty' => [''],
            'no_closing_char' => ['/.*'],
            'no_opening_char' => ['.*/'],
        ];
    }
}
