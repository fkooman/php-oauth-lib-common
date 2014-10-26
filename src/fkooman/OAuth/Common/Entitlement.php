<?php

/**
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace fkooman\OAuth\Common;

use InvalidArgumentException;

class Entitlement
{
    /** @var array */
    private $entitlement;

    public function __construct(array $entitlement = array())
    {
        foreach ($entitlement as $s) {
            if (!$this->validateEntitlementToken($s)) {
                throw new InvalidArgumentException("invalid entitlement token");
            }
        }
        sort($entitlement, SORT_STRING);
        $this->entitlement = array_values(array_unique($entitlement, SORT_STRING));
    }

    public static function fromString($entitlement, $separator = " ")
    {
        if (null === $entitlement) {
            return new self();
        }
        if (!is_string($entitlement)) {
            throw new InvalidArgumentException("entitlement must be string");
        }
        if (0 === strlen($entitlement)) {
            return new self();
        }
        if (!is_string($separator)) {
            throw new InvalidArgumentException("separator must be string");
        }

        return new self(explode($separator, $entitlement));
    }

    public function isEmpty()
    {
        return 0 === count($this->entitlement);
    }

    public function hasEntitlement(Entitlement $that)
    {
        foreach ($that->toArray() as $s) {
            if (!in_array($s, $this->toArray())) {
                return false;
            }
        }

        return true;
    }

    public function hasAnyEntitlement(Entitlement $that)
    {
        if ($that->isEmpty()) {
            return true;
        }

        foreach ($that->toArray() as $s) {
            if (in_array($s, $this->toArray())) {
                return true;
            }
        }

        return false;
    }

    public function hasOnlyEntitlement(Entitlement $that)
    {
        if ($this->isEmpty()) {
            return true;
        }

        foreach ($this->toArray() as $s) {
            if (!in_array($s, $that->toArray())) {
                return false;
            }
        }

        return true;
    }

    public function equals(Entitlement $that)
    {
        $thisEntitlement = $this->toArray();
        $thatEntitlement = $that->toArray();

        foreach ($thisEntitlement as $s) {
            if (!in_array($s, $thatEntitlement)) {
                return false;
            }
        }

        foreach ($thatEntitlement as $s) {
            if (!in_array($s, $thisEntitlement)) {
                return false;
            }
        }

        return true;
    }

    public function toArray()
    {
        return $this->entitlement;
    }

    public function toString($separator = " ")
    {
        if (!is_string($separator)) {
            throw new InvalidArgumentException("separator must be string");
        }

        return implode($separator, $this->entitlement);
    }

    public function __toString()
    {
        return $this->toString();
    }

    private function validateEntitlementToken($entitlementToken)
    {
        if (!is_string($entitlementToken) || 0 >= strlen($entitlementToken)) {
            throw new InvalidArgumentException("entitlement token must be a non-empty string");
        }
        $entitlementTokenRegExp = '/^(?:\x21|[\x23-\x5B]|[\x5D-\x7E])+$/';
        $result = preg_match($entitlementTokenRegExp, $entitlementToken);

        return 1 === $result;
    }
}
