<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Serializer
 * @subpackage Adapter
 */

namespace Zend\Serializer\Adapter;

use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\Serializer\Adapter\AdapterInterface as SerializationAdapter,
    Zend\Serializer\Exception\InvalidArgumentException;

/**
 * @category   Zend
 * @package    Zend_Serializer
 * @subpackage Adapter
 */
abstract class AbstractAdapter implements SerializationAdapter
{
    /**
     * Serializer options
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * @param  array|Traversable $options Serializer options
     */
    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    /**
     * Set serializer options
     *
     * @param  array|Traversable $options Serializer options
     * @return AbstractAdapter
     */
    public function setOptions($options)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } else {
            $options = (array) $options;
        }

        foreach ($options as $k => $v) {
            $this->setOption($k, $v);
        }
        return $this;
    }

    /**
     * Set a serializer option
     *
     * @param  string $name Option name
     * @param  mixed $value Option value
     * @return AbstractAdapter
     */
    public function setOption($name, $value) 
    {
        $this->_options[(string) $name] = $value;
        return $this;
    }

    /**
     * Get serializer options
     *
     * @return array
     */
    public function getOptions() 
    {
        return $this->_options;
    }

    /**
     * Get a serializer option
     *
     * @param  string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getOption($name) 
    {
        $name = (string) $name;
        if (!array_key_exists($name, $this->_options)) {
            throw new InvalidArgumentException("Unknown option '{$name}'");
        }

        return $this->_options[$name];
    }
}
