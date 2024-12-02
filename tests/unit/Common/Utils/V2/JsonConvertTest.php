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

namespace Mcustiel\Phiremock\Tests\Unit\Common\Utils\V2;

use Mcustiel\Phiremock\Common\Utils\ArrayToExpectationConverterLocator;
use Mcustiel\Phiremock\Common\Utils\ExpectationToArrayConverterLocator;
use Mcustiel\Phiremock\Factory;
use PHPUnit\Framework\TestCase;

class JsonConvertTest extends TestCase
{
    private const EMPTY_EXPECTATION = '{
        "version": "2"
    }';
    private const EMPTY_EXPECTATION_EXPECTED = '{
        "version": "2",
        "scenarioName": null,
        "on": {
            "scenarioStateIs": null,
            "method": null,
            "url":null,
            "body": null,
            "headers" : null,
            "formData": null,
            "jsonPath": null
        },
        "then": {
            "delayMillis": null,
            "newScenarioState": null,
            "proxyTo": null,
            "response": {
                "statusCode": 200,
                "body": null,
                "headers": null
            }
        },
        "priority": 0
    }';
    private const EMPTY_REQUEST_AND_RESPONSE = '{
        "version": "2",
        "on": {
        },
        "then" :{
            "response": {}
        }
    }';
    private const EMPTY_REQUEST_AND_RESPONSE_EXPECTED = '{
        "version": "2",
        "scenarioName": null,
        "on": {
            "scenarioStateIs": null,
            "method": null,
            "url":null,
            "body": null,
            "headers" : null,
            "formData": null,
            "jsonPath": null
        },
        "then": {
            "delayMillis": null,
            "newScenarioState": null,
            "proxyTo": null,
            "response": {
                "statusCode": 200,
                "body": null,
                "headers": null
            }
        },
        "priority": 0
    }';
    private const JSON_CONDITION = '{
        "version": "2",
        "on": {
            "method": {"isSameString": "GET"},
            "body": {"isSameJsonObject": "{\"Tomato\":\"Potat\"}"}
        },
        "then" :{
            "response": {}
        }
    }';
    private const JSON_CONDITION_EXPECTED = '{
        "version": "2",
        "scenarioName": null,
        "on": {
            "scenarioStateIs": null,
            "method": {"isSameString": "GET"},
            "url":null,
            "body": {
                "isSameJsonObject": "{\"Tomato\":\"Potat\"}"
            },
            "headers" : null,
            "formData": null,
            "jsonPath": null
        },
        "then": {
            "delayMillis": null,
            "newScenarioState": null,
            "proxyTo": null,
            "response": {
                "statusCode": 200,
                "body": null,
                "headers": null
            }
        },
        "priority": 0
    }';
    private const BASIC_CONFIG = '{
        "version": "2",
        "on": {
            "method": {"isSameString": "GET"}
        },
        "then": {
            "response": {
                "statusCode": 200
            }
        }
    }';
    private const BASIC_CONFIG_EXPECTED = '{
        "version": "2",
        "scenarioName": null,
        "on": {
            "scenarioStateIs": null,
            "method": {
                "isSameString": "GET"
            },
            "url":null,
            "body": null,
            "headers" : null,
            "formData": null,
            "jsonPath": null
        },
        "then": {
            "delayMillis": null,
            "newScenarioState": null,
            "proxyTo": null,
            "response": {
                "statusCode": 200,
                "body": null,
                "headers": null
            }
        },
        "priority": 0
    }';
    private const FULL_CONFIG = '{
        "version": "2",
    	"scenarioName": "potato",
    	"on": {
            "scenarioStateIs": "Scenario.START",
    		"method": {
    			"isSameString": "GET"
    		},
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
    		},
            "jsonPath": {
                "user.id": {
                    "isEqualTo": "123"
                }
            }
    	},
    	"then": {
            "newScenarioState": "tomato",
            "response": {
        		"statusCode": 200,
        		"body": "Hello world!",
        		"headers": {
        			"Content-Type": "text/plain"
        		}
            },
            "delayMillis": 1000
    	},
        "priority": 3
    }';
    private const FULL_CONFIG_EXPECTED = '{
        "version": "2",
    	"scenarioName": "potato",
    	"on": {
            "scenarioStateIs": "Scenario.START",
    		"method": {
    			"isSameString": "GET"
    		},
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
    		},
            "jsonPath": {
                "user.id": {
                    "isEqualTo": "123"
                }
            }
    	},
    	"then": {
            "delayMillis": 1000,
            "newScenarioState": "tomato",
            "proxyTo": null,
        	"response": {
                "statusCode": 200,
        		"body": "Hello world!",
        		"headers": {
        			"Content-Type": "text/plain"
        		}
            }
    	},
        "priority": 3
    }';
    private const JSON_PATH_CONDITION = '{
        "version": "2",
        "on": {
            "jsonPath": {
                "store.book[0].price": {
                    "isEqualTo": 10
                },
                "store.bicycle.color": {
                    "matches": "/^(red|blue)$/"
                },
                "store.basket.items.length": {
                    "isEqualTo": 3
                }
            }
        },
        "then": {
            "response": {"statusCode": 200}
        }
    }';
    private const JSON_PATH_CONDITION_EXPECTED = '{
        "version": "2",
        "scenarioName": null,
        "on": {
            "scenarioStateIs": null,
            "method": null,
            "url": null,
            "body": null,
            "headers": null,
            "formData": null,
            "jsonPath": {
                "store.book[0].price": {
                    "isEqualTo": 10
                },
                "store.bicycle.color": {
                    "matches": "/^(red|blue)$/"
                },
                "store.basket.items.length": {
                    "isEqualTo": 3
                }
            }
        },
        "then": {
            "delayMillis": null,
            "newScenarioState": null,
            "proxyTo": null,
            "response": {
                "statusCode": 200,
                "body": null,
                "headers": null
            }
        },
        "priority": 0
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
            'empty expectation'          => [self::EMPTY_EXPECTATION, self::EMPTY_EXPECTATION_EXPECTED],
            'empty request and response' => [self::EMPTY_REQUEST_AND_RESPONSE, self::EMPTY_REQUEST_AND_RESPONSE_EXPECTED],
            'base config'                => [self::BASIC_CONFIG, self::BASIC_CONFIG_EXPECTED],
            'json body request'          => [self::JSON_CONDITION, self::JSON_CONDITION_EXPECTED],
            'full config'                => [self::FULL_CONFIG, self::FULL_CONFIG_EXPECTED],
            'json path condition'        => [self::JSON_PATH_CONDITION, self::JSON_PATH_CONDITION_EXPECTED],
        ];
    }

    /** @dataProvider configProvider */
    public function testConvertsConfig(string $config, string $expected)
    {
        $configArray = json_decode($config, true);
        if (json_last_error() !== \JSON_ERROR_NONE) {
            $this->fail(json_last_error_msg());
        }
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
