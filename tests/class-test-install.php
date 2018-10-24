<?php
/**
 * Test that we have our installation setup correctly.
 *
 * @package wordcamp_tdd/tests.
 */

namespace wordcamp_tdd\tests;

/**
 * Install test cases.
 */
class Install_Tests extends \WP_UnitTestCase {

    /**
     * If this test passes, you are ready to go.
     */
    public function test_that_we_are_ready_for_wordcamp_capetown_2018() {
        echo "\n\n" . 'You are ready to go, see you at WordCamp Cape Town 2018 :)';
        $this->assertTrue( true );
    }
}
