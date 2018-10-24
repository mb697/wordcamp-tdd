<?php
/**
 * Conversion_Tests that could have saved some money.
 *
 * @package wordcamp_tdd/tests.
 */

namespace wordcamp_tdd\includes;

/**
 * Conversion test cases.
 */
class Completed_Conversion_Tests extends \WP_UnitTestCase {

    /**
     * NASA are $125m better off.
     * https://www.wired.com/2010/11/1110mars-climate-observer-report/
     * Ok it wasnt an error converting km, but Im not getting into Newtons and Pounds.
     * 
     * @group nasafail
     */
    public function test_that_kilometers_are_correctly_converted_to_miles() {

        $conversion = new Conversion();

        $this->assertEquals(
            1,
            $conversion->converts_kilometers_to_miles( 1.6 ),
            'We arent converting miles to kilometers properly which is going to result in the cliamte orbiter '
        );
    }
}
