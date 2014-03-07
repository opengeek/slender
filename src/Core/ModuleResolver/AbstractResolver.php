<?php
/**
 * Slender - Slim, but with a bit more meat
 *
 * @author      Alan Pich <alan.pich@gmail.com>
 * @copyright   2014 Alan Pich
 * @link        http://alanpich.github.io/slender
 * @license     https://github.com/alanpich/slender/blob/develop/LICENSE
 * @version     0.0.0
 * @package     Slender
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Slender\Core\ModuleResolver;

use Slender\Interfaces\ConfigFileParserInterface;
use Slender\Interfaces\ModuleResolverInterface;

abstract class AbstractResolver implements ModuleResolverInterface
{
    /**
     * @var ConfigFileParserInterface
     */
    protected $parser;

    protected $cache = array(
            'paths' => array(),
            'configs' => array()
        );

    /**
     * Sets the Parser to use on config files
     *
     * @param  ConfigFileParserInterface $parser
     * @return mixed
     */
    public function setConfigParser(ConfigFileParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Return parsed config file for module
     *
     * @param $module
     * @return mixed
     */
    public function getConfig($module)
    {
        if (!$this->cache['paths'][$module]) {
            $path = $this->getPath($module);
            $file = $path.DIRECTORY_SEPARATOR.'slender.yml';
            $parsed = $this->parser->parseFile($file);
            $this->cache['paths'][$module] = $parsed;
        }

        return $this->cache['paths'][$module];
    }

}
