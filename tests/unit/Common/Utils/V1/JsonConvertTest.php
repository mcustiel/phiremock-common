<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils\V1;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverterLocator;
use Mcustiel\Phiremock\Factory;
use PHPUnit\Framework\TestCase;

class JsonConvertTest extends TestCase
{
    private const JSON_CONDITION = '{"request": {"method": "GET", "body": {"isSameJsonObject": "{\"Tomato\":\"Potat\"}"}}, "response": {}}';
    private const JSON_CONDITION_EXPECTED = '{"scenarioName": null, "scenarioStateIs": null, "newScenarioState": null, "request": {"method": "GET", "url":null, "body": {"isSameJsonObject": "{\"Tomato\":\"Potat\"}"}, "headers" : null, "formData": null}, "response": {"statusCode": 200,"body": null, "headers": null, "delayMillis": null}, "proxyTo" : null, "priority": 0, "scenarioName": null, "scenarioStateIs": null, "newScenarioState": null}';
    private const BASIC_CONFIG = '{"request": {"method": "GET"}, "response": {"statusCode": 200}}';
    private const BASIC_CONFIG_EXPECTED = '{"scenarioName": null, "scenarioStateIs": null, "newScenarioState": null, "request": {"method": "GET", "url":null, "body": null, "headers" : null, "formData": null}, "response": {"statusCode": 200, "body": null, "headers": null, "delayMillis": null}, "proxyTo" : null, "priority": 0, "scenarioName": null, "scenarioStateIs": null, "newScenarioState": null}';
    private const FULL_CONFIG = '{
    	"scenarioName": "potato",
    	"scenarioStateIs": "Scenario.START",
    	"newScenarioState": "tomato",
    	"request": {
    		"method": "GET",
    		"url": {
    			"isEqualTo": "/some/thing"
    		},
            "body": {
                "matches": "/^something$/"
            },
    		"headers": {
    			"Content-Type": {
    				"isEqualTo": "text/plain"
    			}
    		},
            "formData": {
    			"name": {
    				"isEqualTo": "potato"
    			}
    		}
    	},
    	"response": {
    		"statusCode": 200,
    		"body": "Hello world!",
    		"headers": {
    			"Content-Type": "text/plain"
    		},
            "delayMillis": 1000
    	},
        "proxyTo" : null,
        "priority": 3
    }';
    private const FULL_CONFIG_EXPECTED = '{
    	"scenarioName": "potato",
    	"scenarioStateIs": "Scenario.START",
    	"newScenarioState": "tomato",
    	"request": {
    		"method": "GET",
    		"url": {
    			"isEqualTo": "/some/thing"
    		},
            "body": {
                "matches": "/^something$/"
            },
    		"headers": {
    			"Content-Type": {
    				"isEqualTo": "text/plain"
    			}
    		},
            "formData": {
    			"name": {
    				"isEqualTo": "potato"
    			}
    		}
    	},
    	"response": {
    		"statusCode": 200,
    		"body": "Hello world!",
    		"headers": {
    			"Content-Type": "text/plain"
    		},
            "delayMillis": 1000
    	},
        "proxyTo" : null,
        "priority": 3
    }';

    /** @var ArrayToExpectationConverterLocator */
    private $arrayToExpectationConverterLocator;
    /** @var ExpectationToArrayConverterLocator */
    private $expectationToArrayConverterLocator;

    protected function setUp(): void
    {
        $factory = new Factory();
        $this->arrayToExpectationConverterLocator = $factory->createArrayToExpectationConverterLocator();
        $this->expectationToArrayConverterLocator = $factory->createExpectationToArrayConverterLocator();
    }

    public function configProvider(): array
    {
        return [
            'base config'       => [self::BASIC_CONFIG, self::BASIC_CONFIG_EXPECTED],
            'json body request' => [self::JSON_CONDITION, self::JSON_CONDITION_EXPECTED],
            'full config'       => [self::FULL_CONFIG, self::FULL_CONFIG_EXPECTED],
        ];
    }

    /** @dataProvider configProvider */
    public function testConvertsConfig(string $config, string $expected)
    {
        $configArray = json_decode($config, true);
        $expectation = $this->arrayToExpectationConverterLocator
            ->locate($configArray)
            ->convert($configArray);
        $expectedArray = json_decode($expected, true);
        $this->assertSame(
            $expectedArray,
            $this->expectationToArrayConverterLocator
                ->locate($expectation)
                ->convert($expectation)
        );
        $expectation = $this->arrayToExpectationConverterLocator
            ->locate($expectedArray)
            ->convert($expectedArray);
        $this->assertSame(
            $expectedArray,
            $this->expectationToArrayConverterLocator
                ->locate($expectation)
                ->convert($expectation)
        );
    }
}
