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
use PHPUnit_Framework_TestCase;

class EntitlementTest extends PHPUnit_Framework_TestCase
{
    public function testEntitlement()
    {
        $s = new Entitlement(array("read", "write", "foo"));
        $this->assertFalse($s->isEmpty());
        $this->assertTrue($s->hasEntitlement(new Entitlement(array("read"))));
        $this->assertTrue($s->hasEntitlement(new Entitlement(array("write"))));
        $this->assertTrue($s->hasEntitlement(new Entitlement(array("foo"))));
        $this->assertTrue($s->hasAnyEntitlement(new Entitlement(array("foo", "bar"))));
        $this->assertTrue($s->equals(new Entitlement(array("foo", "write", "read"))));
        $this->assertFalse($s->equals(new Entitlement(array("read", "write"))));
        $this->assertFalse($s->equals(new Entitlement(array("bar", "foo", "read", "write"))));
        $this->assertFalse($s->hasAnyEntitlement(new Entitlement(array("bar", "baz"))));
        $this->assertEquals("foo read write", $s->toString());
        $this->assertEquals("foo read write", $s->__toString());
        $this->assertEquals("foo,read,write", $s->toString(","));
    }

    public function testEmptyEntitlement()
    {
        $s = new Entitlement();
        $this->assertTrue($s->isEmpty());
        $this->assertTrue($s->equals(new Entitlement()));
        $this->assertFalse($s->hasEntitlement(new Entitlement(array("foo"))));
        $this->assertTrue($s->hasEntitlement(new Entitlement()));
        $this->assertTrue($s->hasAnyEntitlement(new Entitlement()));
    }

    public function testEntitlementFromString()
    {
        $s = Entitlement::fromString("foo bar");
        $this->assertEquals(array("bar", "foo"), $s->toArray());
    }

    public function testEntitlementFromStringCommaSeparated()
    {
        $s = Entitlement::fromString("foo,bar", ",");
        $this->assertEquals(array("bar", "foo"), $s->toArray());
    }

    public function testHasOnlyEntitlement()
    {
        $entitlement = new Entitlement(array("foo", "bar"));
        $this->assertTrue($entitlement->hasOnlyEntitlement(new Entitlement(array("foo", "bar", "baz"))));
        $this->assertFalse($entitlement->hasOnlyEntitlement(new Entitlement(array("foo"))));
        $this->assertFalse($entitlement->hasOnlyEntitlement(new Entitlement()));
        $entitlementTwo = new Entitlement();
        $this->assertTrue($entitlementTwo->hasOnlyEntitlement(new Entitlement(array("foo"))));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage invalid entitlement token
     */
    public function testInvalidEntitlementToken()
    {
        $s = new Entitlement(array("François"));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage entitlement token must be a non-empty string
     */
    public function testEmptyArrayEntitlement()
    {
        $s = new Entitlement(array("foo", "", "bar"));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage entitlement must be string
     */
    public function testNonStringFromString()
    {
        $s = Entitlement::fromString(5);
    }

    public function testNullFromString()
    {
        $s = Entitlement::fromString(null);
        $this->assertTrue($s->isEmpty());
    }

    public function testEmptyStringFromString()
    {
        $s = Entitlement::fromString("");
        $this->assertTrue($s->isEmpty());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage invalid entitlement token
     */
    public function testEmptyStringEntitlement()
    {
        $s = new Entitlement(array("foo ", "bar"));
    }

    public function testSerialize()
    {
        $s = new Entitlement(array("foo", "bar", "baz"));
        $t = new Entitlement($s->toArray());
        $this->assertTrue($t->equals($s));
    }
}
