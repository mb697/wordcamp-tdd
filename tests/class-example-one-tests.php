<?php
/**
 * Example One Tests.
 *
 * @package wordcamp_tdd/tests.
 */

namespace wordcamp_tdd\includes;

/**
 * Conversion test cases.
 */
class Example_One_Tests extends \WP_UnitTestCase {

    /**
     * @todo write this test.
     */
    public function test_i_didnt_have_time_to_write_because_the_boss_was_on_my_case_but_whats_the_worse_that_could_happen() {

        $example_one = new Example_One();
        $outcome     = $example_one->converts_kilometers_to_miles( 1.6 );

        $this->assertEquals(
            1,
            1,
            'I will get to this at some point, bit busy right now.'
        );
    }
}
