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

class ScopeTest extends \PHPUnit_Framework_TestCase
{
    public function testScope()
    {
        $s = new Scope("read write foo");
        $this->assertFalse($s->isEmpty());
        $this->assertTrue($s->hasScope(new Scope("read")));
        $this->assertTrue($s->hasScope(new Scope("write")));
        $this->assertTrue($s->hasScope(new Scope("foo")));
        $this->assertTrue($s->hasAnyScope(new Scope("foo bar")));
        $this->assertTrue($s->isEqual(new Scope(array("foo", "write", "read"))));
        $this->assertFalse($s->isEqual(new Scope("read write")));
        $this->assertFalse($s->isEqual(new Scope("bar foo read write")));
        $this->assertFalse($s->hasAnyScope(new Scope(array("bar", "baz"))));
    }

    public function testEmptyScope()
    {
        $s = new Scope();
        $this->assertTrue($s->isEmpty());
        $this->assertTrue($s->isEqual(new Scope()));
        $this->assertFalse($s->hasScope(new Scope("foo")));
        $this->assertTrue($s->hasScope(new Scope()));
        $this->assertTrue($s->hasAnyScope(new Scope()));
    }

    /**
     * @expectedException fkooman\OAuth\Common\Exception\ScopeException
     * @expectedExceptionMessage invalid scope token 'François'
     */
    public function testInvalidScopeToken()
    {
        $s = new Scope("François");
    }

    /**
     * @expectedException fkooman\OAuth\Common\Exception\ScopeException
     * @expectedExceptionMessage scope token must be a non-empty string
     */
    public function testEmptyArrayScope()
    {
        $s = new Scope(array("foo", "", "bar"));
    }

    /**
     * @expectedException fkooman\OAuth\Common\Exception\ScopeException
     * @expectedExceptionMessage scope token must be a non-empty string
     */
    public function testEmptyStringScope()
    {
        $s = new Scope("foo  bar");
    }

    /**
     * @expectedException fkooman\OAuth\Common\Exception\ScopeException
     * @expectedExceptionMessage scope must be string or array
     */
    public function testNonStringOrArrayParam()
    {
        $s = new Scope(5);
    }

    public function testSerialize()
    {
        $s = new Scope("foo bar baz");
        $data = serialize($s);
        $t = unserialize($data);
        $this->assertTrue($t->isEqual($s));
    }
}
