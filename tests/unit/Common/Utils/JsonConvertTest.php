<?php
namespace Mcustiel\Phiremock\Test\Unit\Common\Utils;

use PHPUnit\Framework\TestCase;
use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToRequestConditionConverter;
use Mcustiel\Phiremock\Common\Utils\ArrayToResponseConverterLocator;
use Mcustiel\Phiremock\Factory;
use Mcustiel\Phiremock\Common\Utils\ArrayToConditionsConverterLocator;

class JsonConvertTest extends TestCase
{
    private const EMPTY_CONFIG = '{}';
    private const EMPTY_REQUEST = '{"request": {}, "response": {"statusCode": 200}}';
    private const EMPTY_RESPONSE = '{"request": {"method": "GET"}, "response": {}}';
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

    public function testConvertsABasicConfig()
    {
        $this->converter->convert(json_decode(self::BASIC_CONFIG, true));
    }

    public function testConvertsAFullConfig()
    {
        $this->converter->convert(json_decode(self::FULL_CONFIG, true));
    }
}
