<?php
/**
 * Is testing worthwhile?
 *
 * @package wordcamp_tdd/includes.
 */

namespace wordcamp_tdd\includes;

/**
 * Conversion class.
 * Handles converting imperial units to metric.
 */
class Example_One {

    /**
     * Takes a value in kilometers and converts it to miles.
     *
     * @param  float $km A kilometer value.
     * @return float     A mile value.
     */
    public function converts_kilometers_to_miles( $km ) {
        return $km / 1.675;
    }
}
