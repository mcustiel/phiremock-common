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

namespace Mcustiel\Phiremock\Test\Unit\Common\Utils;

use Mcustiel\Phiremock\Common\Utils\ArrayToConditionsConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator;
use Mcustiel\Phiremock\Factory;
use PHPUnit\Framework\TestCase;

class JsonConvertTest extends TestCase
{
    private const EMPTY_CONFIG = '{}';
    private const EMPTY_REQUEST = '{"request": {}, "response": {"statusCode": 200}}';
    private const EMPTY_RESPONSE = '{"request": {"method": "GET"}, "response": {}}';
    private const JSON_CONDITION = '{"request": {"method": "GET", "body": {"isSameJsonObject": "{\"Tomato\":\"Potat\"}"}}, "response": {}}';
    private const BASIC_CONFIG = '{"request": {"method": "GET"}, "response": {"status": 200}}';
    private const FULL_CONFIG = '{
    	"scenarioName": "potato",
    	"scenarioStateIs": "Scenario.START",
    	"newScenarioState": "tomato",
    	"request": {
    		"method": "GET",
    		"url": {
    			"isEqualTo": "/some/thing"
    		},
    		"headers": {
    			"Content-Type": {
    				"isEqualTo": "text/plain"
    			}
    		}
    	},
    	"response": {
    		"statusCode": 200,
    		"body": "Hello world!",
    		"headers": {
    			"Content-Type": "text/plain"
    		}
    	}
    }';

    /** @var ArrayToExpectationConverter */
    private $converter;

    protected function setUp(): void
    {
        $factory = new Factory();
        $this->converter = new ArrayToExpectationConverter(
            new ArrayToConditionsConverterLocator($factory),
            new ArrayToResponseConverterLocator($factory)
        );
    }

    public function configProvider(): array
    {
        return [
            'base config'       => [self::BASIC_CONFIG],
            'json body request' => [self::JSON_CONDITION],
            'full config'       => [self::FULL_CONFIG],
        ];
    }

    /** @dataProvider configProvider */
    public function testConvertsConfig(string $config)
    {
        $this->assertNotNull($this->converter->convert(json_decode($config, true)));
    }
}
