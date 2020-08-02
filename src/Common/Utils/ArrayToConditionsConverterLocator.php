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

namespace Mcustiel\Phiremock\Common\Utils;

use Mcustiel\Phiremock\Domain\Version;
use Mcustiel\Phiremock\Factory;

class ArrayToConditionsConverterLocator
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function locate(Version $version): ArrayToRequestConditionConverter
    {
        switch ($version->asString()) {
            case '1':
                return  $this->factory->createArrayToRequestConditionConverter();
            case '2':
                return $this->factory->createArrayToRequestConditionV2Converter();
        }
        throw new \LogicException('Unimplemented config version');
    }
}
