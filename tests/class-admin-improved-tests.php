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
class Admin_Improved_Tests extends \WP_UnitTestCase {

    /**
     * DataProvider for test_that_months_and_years_are_correctly_returned.
     *
     * @return array $datetime, $expected.
     */
    public function month_year_provider() {

        return [
            [
                new \DateTime( '2018-10-01' ),
                [
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
                ],
            ],
            [
                new \DateTime( '2018-10-31' ),
                [
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
                ],
            ],
        ];
    }

    /**
     * Improved test for month and years,
     * still has a weakness though.
     * 
     * @dataProvider month_year_provider
     */
    public function test_that_months_and_years_are_correctly_returned( $datetime, $expected ) {

        // Double Admin Improved class.
		$admin = $this->getMockBuilder( __NAMESPACE__ . '\\Admin_Improved' )
			->setMethods( [ 'get_datetime' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Return our date object.
		$admin->expects( $this->once() )
			->method( 'get_datetime' )
			->will( $this->returnValue( $datetime ) );

        $this->assertEquals(
            $expected,
            $admin->month_year(),
            'Next 12 months of month/year combinations not being correctly returned.'
        );
    }
}
