<?php
namespace system\Core;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 15, 2016
 */
class Benchmark
{

    /**
     *
     * @tutorial List of all benchmark markers
     * @var array
     */
    public static $marker = array();

    /**
     *
     * @tutorial Set a benchmark marker, multiple calls to this function can be made so that several execution points can be timed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/09/2015}
     * @param string $name            
     */
    public static function mark($name)
    {
        self::$marker[$name] = microtime(TRUE);
    }

    /**
     *
     * @tutorial Elapsed time Calculates the time difference between two marked points.
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/09/2015}
     * @param string $point1            
     * @param string $point2            
     * @param number $decimals            
     * @return string
     */
    public static function elapsedTime($point1 = '', $point2 = '', $decimals = 4)
    {
        if ($point1 === '') {
            return '{elapsed_time}';
        }
        if (! isset(self::$marker[$point1])) {
            return '';
        }
        if (! isset(self::$marker[$point2])) {
            self::$marker[$point2] = microtime(TRUE);
        }
        return number_format(self::$marker[$point2] - self::$marker[$point1], $decimals);
    }

    /**
     *
     * @tutorial Memory Usage Simply returns the {memory_usage} marker.
     *           This permits it to be put it anywhere in a template
     *           without the memory being calculated until the end.
     *           The output class will swap the real value for this variable.
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {13/09/2015}
     * @return string
     */
    public static function memoryUsage()
    {
        return '{memory_usage}';
    }
}