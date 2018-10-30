<?php
/**
 * Conversion_Tests that could have saved some money.
 *
 * @package wordcamp_tdd/tests/completed.
 */

namespace wordcamp_tdd\includes;

/**
 * Conversion test cases.
 */
class Example_One_Completed_Tests extends \WP_UnitTestCase {

    /**
     * NASA are $125m better off.
     * https://www.wired.com/2010/11/1110mars-climate-observer-report/
     * Ok it wasnt an error converting km, but Im not getting into Newtons and Pounds.
     * 
     * @group completed
     */
    public function test_that_kilometers_are_correctly_converted_to_miles() {

        $example_one = new Example_One();
        $outcome     = $example_one->converts_kilometers_to_miles( 1.6 );

        $this->assertEquals(
            1,
            $outcome,
            'Kilometers are not being correctly converted to miles.'
        );
    }
}
