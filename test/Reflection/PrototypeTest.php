<?php

/**
 * @see       https://github.com/laminas/laminas-server for the canonical source repository
 * @copyright https://github.com/laminas/laminas-server/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-server/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Server\Reflection;

use Laminas\Server\Reflection;
use Laminas\Server\Reflection\Exception\InvalidArgumentException;
use Laminas\Server\Reflection\ReflectionReturnValue;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Test case for \Laminas\Server\Reflection\Prototype
 *
 * @group      Laminas_Server
 */
class PrototypeTest extends TestCase
{
    /**
     * @var \Laminas\Server\Reflection\Prototype
     */
    protected $r;

    /**
     * @var array
     * @psalm-var array<array-key, \ReflectionParameter>
     */
    protected $parametersRaw;

    /**
     * @var array
     * @psalm-var list<Reflection\ReflectionParameter>
     */
    protected $parameters;

    /**
     * Setup environment
     */
    public function setUp(): void
    {
        $class = new ReflectionClass('\Laminas\Server\Reflection');
        $method = $class->getMethod('reflectClass');
        $parameters = $method->getParameters();
        $this->parametersRaw = $parameters;

        $fParameters = [];
        foreach ($parameters as $p) {
            $fParameters[] = new Reflection\ReflectionParameter($p);
        }
        $this->parameters = $fParameters;

        $this->r = new Reflection\Prototype(new Reflection\ReflectionReturnValue('void', 'No return'));
    }

    /**
     * Teardown environment
     */
    public function tearDown(): void
    {
        unset($this->r);
        unset($this->parameters);
        unset($this->parametersRaw);
    }

    /**
     * __construct() test
     *
     * Call as method call
     *
     * Expects:
     * - return:
     * - params: Optional;
     *
     * Returns: void
     *
     * @return void
     */
    public function testConstructWorks(): void
    {
        $this->assertSame('void', $this->r->getReturnType());
    }

    /**
     * getReturnType() test
     *
     * Call as method call
     *
     * Returns: string
     *
     * @return void
     */
    public function testGetReturnType(): void
    {
        $this->assertEquals('void', $this->r->getReturnType());
    }

    /**
     * getReturnValue() test
     *
     * Call as method call
     *
     * Returns: \Laminas\Server\Reflection\ReflectionReturnValue
     *
     * @return void
     */
    public function testGetReturnValue(): void
    {
        $this->assertInstanceOf(ReflectionReturnValue::class, $this->r->getReturnValue());
    }

    /**
     * getParameters() test
     *
     * Call as method call
     *
     * Returns: array
     *
     * @return void
     */
    public function testGetParameters(): void
    {
        $r = new Reflection\Prototype($this->r->getReturnValue(), $this->parameters);
        $p = $r->getParameters();

        $this->assertEquals($this->parameters, $p);
    }
}
