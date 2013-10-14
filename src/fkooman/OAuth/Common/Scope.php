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

use fkooman\OAuth\Common\Exception\ScopeException;

class Scope
{
    /** @var array */
    private $scope;

    public function __construct(array $scope = array())
    {
        foreach ($scope as $s) {
            if (!$this->validateScopeToken($s)) {
                throw new ScopeException(sprintf("invalid scope token '%s'", $s));
            }
        }
        $this->scope = array_values($scope);
    }

    public function isEmpty()
    {
        return 0 === count($this->scope);
    }

    public function hasScope(Scope $scope)
    {
        foreach ($scope->toArray() as $s) {
            if (!in_array($s, $this->scope)) {
                return false;
            }
        }

        return true;
    }

    public function hasAnyScope(Scope $scope)
    {
        if ($scope->isEmpty()) {
            return true;
        }

        foreach ($scope->toArray() as $s) {
            if (in_array($s, $this->scope)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Compare Scope to other Scope
     *
     * @param  Scope $that the Scope to compare with
     * @return -1    if that scope misses scopes from this scope, 1 if this scope
     *         misses scopes from that scope, 0 if the scopes are equal
     */
    public function compareTo(Scope $that)
    {
        $thisScope = $this->toArray();
        $thatScope = $that->toArray();

        foreach ($thisScope as $s) {
            if (!in_array($s, $thatScope)) {
                return -1;
            }
        }

        foreach ($thatScope as $s) {
            if (!in_array($s, $thisScope)) {
                return 1;
            }
        }

        return 0;
    }

    public function toArray()
    {
        return $this->scope;
    }

    public function toString()
    {
        return implode(" ", $this->scope);
    }

    public function __toString()
    {
        return $this->toString();
    }

    private function validateScopeToken($scopeToken)
    {
        if (!is_string($scopeToken) || 0 >= strlen($scopeToken)) {
            throw new ScopeException("scope token must be a non-empty string");
        }
        $scopeTokenRegExp = '/^(?:\x21|[\x23-\x5B]|[\x5D-\x7E])+$/';
        $result = preg_match($scopeTokenRegExp, $scopeToken);

        return 1 === $result;
    }
}
