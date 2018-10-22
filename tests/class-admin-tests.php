<?php
/**
 * Class Admin_Tests.
 *
 * @package wordcamp_tdd/tests.
 */

namespace wordcamp_tdd\includes;

/**
 * Admin test cases.
 */
class Admin_Tests extends \WP_UnitTestCase {

    /**
     * Improved test for month and years,
     * still has a weakness though.
     */
    public function test_that_months_and_years_are_correctly_returned() {

        // Set DateTime.
        $date = new \DateTime( '2018-10-01' );

        // Double Admin class.
		$admin = $this->getMockBuilder( __NAMESPACE__ . '\\Admin' )
			->setMethods( [ 'get_datetime' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Return our date object.
		$admin->expects( $this->once() )
			->method( 'get_datetime' )
			->will( $this->returnValue( $date ) );
            
        $expected = [
            '10-2018',
            '11-2018',
            '12-2018',
            '01-2019',
            '02-2019',
            '03-2019',
            '04-2019',
            '05-2019',
            '06-2019',
            '07-2019',
            '08-2019',
            '09-2019',
        ];

        $this->assertEquals(
            $expected,
            $admin->month_year(),
            'Next 12 months of month/year combinations not being correctly returned.'
        );
    }
}
