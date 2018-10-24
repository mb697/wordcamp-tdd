<?php
/**
 * Is testing worthwhile?
 * Is $125m a lot of money?
 *
 * @package wordcamp_tdd/includes.
 */

namespace wordcamp_tdd\includes;

/**
 * Conversion class.
 * Handles converting imperial units to metric.
 */
class Conversion {

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
