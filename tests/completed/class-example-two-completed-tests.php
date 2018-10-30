<?php
/**
 * Complete Example Two tests.
 *
 * @package wordcamp_tdd/tests/completed.
 */

namespace wordcamp_tdd\includes\completed;

/**
 * Example Two tests.
 */
class Example_Two_Completed_Tests extends \WP_UnitTestCase {

    /**
     * Step One: write a functional test for the plugin that ensures that the author gets 50 points.
     * 
     * @group completed
     */
    public function test_that_most_important_thing_happens() {

        // Create a User.
        $user_id = $this->factory->user->create();

        // Add 50 points.
        update_user_meta( $user_id, 'author_points', 50 );

        // Add a post for user.
        $this->factory->post->create( [
            'post_status'   => 'publish',
            'post_author'   => $user_id,
        ] );

        // Assert.
        $this->assertEquals(
            100,
            get_user_meta( $user_id, 'author_points', true ),
            'User points not updated on publish.'
        );
    }

    /**
     * Step Two: extend the functional test using a DataProvider to test all scenarios.
     */
    public function post_status_provider() {

        return [
            // Publish.
            [ 'draft', 'publish', 100 ],
            [ 'pending', 'publish', 100 ],
            [ 'auto-draft', 'publish', 100 ],
            [ 'inherit', 'publish', 100 ],
            // Non-Publish.
            [ 'draft', 'pending', 50 ],
            [ 'draft', 'auto-draft', 50 ],
            [ 'draft', 'inherit', 50 ],
            [ 'pending', 'draft', 50 ],
            [ 'pending', 'auto-draft', 50 ],
            [ 'pending', 'inherit', 50 ],
            [ 'auto-draft', 'draft', 50 ],
            [ 'auto-draft', 'pending', 50 ],
            [ 'auto-draft', 'inherit', 50 ],
            [ 'inherit', 'draft', 50 ],
            [ 'inherit', 'pending', 50 ],
            [ 'inherit', 'auto-draft', 50 ],
            // No change.
            [ 'draft', 'draft', 50 ],
            [ 'pending', 'pending', 50 ],
            [ 'auto-draft', 'auto-draft', 50 ],
            [ 'inherit', 'inherit', 50 ],
            [ 'publish', 'publish', 100 ], // This would be 150 if it wasnt working correctly.
        ];
    }

    /**
     * Using a dataProvider.
     *
     * @param string  $old_status Previous post_status.
     * @param string  $new_status New post_status.
     * @param integer $points     Points the user should have after post update.
     * @dataProvider post_status_provider
     * @group completed
     */
    public function test_that_the_most_important_thing_happens_only_when_it_should( $old_status, $new_status, $points ) {

        // Create a User.
        $user_id = $this->factory->user->create();

        // Add 50 points.
        update_user_meta( $user_id, 'author_points', 50 );

        // Add a post for user.
        $post_id = $this->factory->post->create( [
            'post_status'   => $old_status,
            'post_author'   => $user_id,
        ] );

        // Update.
        $this->factory->post->update_object( $post_id, [
            'post_status'   => $new_status,
        ] );

        // Assert.
        $this->assertEquals(
            $points,
            get_user_meta( $user_id, 'author_points', true ),
            'User points not being correctly handled.'
        );
    }

    /**
     * Step Three: write integration tests to improve the original code.
     * Try and move dependencies out to separate methods giving us more control when testing.
     */

     /**
      * Creates a user, a post authored by the user and returns all.
      *
      * @return array User ID, Post ID, WP_Post object.
      */
    public function create_user_and_post_for_user() {

        $user_id = $this->factory->user->create();
        $post_id = $this->factory->post->create( [
            'post_author'   => $user_id,
        ] );
        $post    = get_post( $post_id );

        return [
            'user_id'   => $user_id,
            'post_id'   => $post_id,
            'post'      => $post,
        ];
    }
    
    /**
     * Given that we have a WP_Post object,
     * the author ID is correctly set from the object.
     * 
     * @group completed
     */
    public function test_that_author_id_is_set_from_post_object() {

        $data = $this->create_user_and_post_for_user();

        $example_two_completed = new Example_Two_Completed();

        $example_two_completed->set_author_id( $data['post'] );

        $this->assertEquals(
            $data['user_id'],
            $example_two_completed->get_author_id(),
            'Author ID not being correctly set from WP_Post object.'
        );
    }

    /**
     * Given that we have a user,
     * and that user has some points,
     * these points are correctly set.
     * 
     * @group completed
     */
    public function test_that_author_points_are_correctly_set() {

        $data = $this->create_user_and_post_for_user();

        update_user_meta( $data['user_id'], 'author_points', 1000 );

        $example_two_completed = new Example_Two_Completed();

        $example_two_completed->set_author_id( $data['post'] );
        $example_two_completed->set_author_points();

        $this->assertEquals(
            1000,
            $example_two_completed->get_author_points(),
            'Author points not being correctly set.'
        );
    }

    /**
     * Given that we have increase a users points by 50,
     * this is reflected in the $author_points property.
     * 
     * @group completed
     */
    public function test_that_author_points_increase_correctly() {

        $example_two_completed = new Example_Two_Completed();

        $example_two_completed->increase_author_points( 50 );
        $example_two_completed->increase_author_points( 50 );
        $example_two_completed->increase_author_points( 20 );

        $this->assertEquals(
            120,
            $example_two_completed->get_author_points(),
            'Author points not being correctly increased.'
        );
    }

    /**
     * Given that we attempt to update all related user meta,
     * the meta is correctly updated.
     * 
     * @group completed
     */
    public function test_that_meta_updates() {

        $post                  = new \stdClass();
        $post->ID              = 123;
        $data                  = $this->create_user_and_post_for_user();
        $example_two_completed = new Example_Two_Completed();

        $example_two_completed->set_datetime();
        $example_two_completed->set_author_id( $data['post'] );
        $example_two_completed->increase_author_points( 50 );
        $example_two_completed->update_meta( $post );

        $this->assertEquals(
            50,
            get_user_meta( $data['user_id'], 'author_points', true ),
            'User meta not being correctly updated.'
        );

        // See test_payout_month_year - this will fail when its WordCamp.
        $this->assertEquals(
            '04-2019',
            get_user_meta( $data['user_id'], 'payout_123', true ),
            'User meta not being correctly updated.'
        );
    }

    /**
     * Given that we attempt to update a single user meta field,
     * the field is updated.
     * 
     * @group completed
     */
    public function test_that_single_meta_fields_update() {

        $data                  = $this->create_user_and_post_for_user();
        $example_two_completed = new Example_Two_Completed();

        $example_two_completed->set_author_id( $data['post'] );

        $example_two_completed->update_single_meta_field( 'foo', 'bar' );

        $this->assertEquals(
            'bar',
            get_user_meta( $data['user_id'], 'foo', true ),
            'Single user meta field not updating.'
        );
    }

    /**
     * Test for month and years,
     * I wrote this test in October,
     * WordCamp is in November,
     * can you see why its going to fail?
     * 
     * @group completed
     */
    public function test_payout_month_year() {

        $example_two_completed = new Example_Two_Completed();

        // Set DateTime.
        $example_two_completed->set_datetime();

        // October 2018 + 6 months = April 2019.
        $this->assertEquals(
            '04-2019',
            $example_two_completed->payout_month_year(),
            'Current date plus six months month/year combinations not being correctly returned.'
        );
    }

    /**
     * Step Four: use test doubles to improve your integration tests and write pure unit tests.
     */

    /**
     * Given that we have a user,
     * and that user has some points,
     * these points are correctly set.
     * 
     * @group completed
     */
    public function test_that_author_points_are_correctly_set_with_double() {

        // Add user.
        $user_id = $this->factory->user->create();

        update_user_meta( $user_id, 'author_points', 1000 );

        // Double class.
		$example_two_completed = $this->getMockBuilder( __NAMESPACE__ . '\\Example_Two_Completed' )
			->setMethods( [ 'get_author_id' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Return User ID.
		$example_two_completed->expects( $this->once() )
			->method( 'get_author_id' )
            ->will( $this->returnValue( $user_id ) );        

        $example_two_completed->set_author_points();

        $this->assertEquals(
            1000,
            $example_two_completed->get_author_points(),
            'Author points not being correctly set.'
        );
    }

    /**
     * Given that we attempt to update all related user meta,
     * the correct methods are called with the correct parameters.
     * 
     * @group completed1
     */
    public function test_that_meta_updates_with_double() {

        // NB. You could improve this further using a property, setter and getter for $post.
        $post     = new \stdClass();
        $post->ID = 123;

        // Double class.
		$example_two_completed = $this->getMockBuilder( __NAMESPACE__ . '\\Example_Two_Completed' )
			->setMethods( [ 'get_author_points', 'payout_month_year', 'update_single_meta_field' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Step 0: Return User points.
		$example_two_completed->expects( $this->once() )
			->method( 'get_author_points' )
            ->will( $this->returnValue( 1000 ) );   
            
		// Step 1: Return Payout month and year.
		$example_two_completed->expects( $this->once() )
			->method( 'payout_month_year' )
            ->will( $this->returnValue( '04-2019' ) );

        // Step 2: Update author points.
		$example_two_completed->expects( $this->at( 2 ) )
            ->method( 'update_single_meta_field' )
            ->with(
                $this->equalTo( 'author_points' ),
                $this->equalTo( 1000 )
            );

        // Step 3: Update payout date.
		$example_two_completed->expects( $this->at( 3 ) )
            ->method( 'update_single_meta_field' )
            ->with(
                $this->equalTo( 'payout_123' ),
                $this->equalTo( '04-2019' )
            );

        // Act (after assertions in this case which is slightly contradictory).
        $example_two_completed->update_meta( $post );
    }

    /**
     * Given that we attempt to update a single user meta field,
     * the field is updated.
     *
     * @group completed
     */
    public function test_that_single_meta_fields_update_with_double() {

        // Add user.
        $user_id = $this->factory->user->create();

        // Double class.
		$example_two_completed = $this->getMockBuilder( __NAMESPACE__ . '\\Example_Two_Completed' )
			->setMethods( [ 'get_author_id' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Return User ID.
		$example_two_completed->expects( $this->once() )
			->method( 'get_author_id' )
            ->will( $this->returnValue( $user_id ) );  

        $example_two_completed->update_single_meta_field( 'foo', 'bar' );

        $this->assertEquals(
            'bar',
            get_user_meta( $user_id, 'foo', true ),
            'Single user meta field not updating.'
        ); 
    }

    /**
     * Given that we know the current date,
     * we get a month-year pair that is 6 months in the future from that date.
     *
     * @group completed
     */
    public function test_payout_month_year_with_double() {

        // Create a DateTime object.
        $datetime = new \DateTime( '2018-10-01' );

        // Double class.
		$example_two_completed = $this->getMockBuilder( __NAMESPACE__ . '\\Example_Two_Completed' )
			->setMethods( [ 'get_datetime' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Return our date object.
		$example_two_completed->expects( $this->once() )
			->method( 'get_datetime' )
			->will( $this->returnValue( $datetime ) );

        $this->assertEquals(
            '04-2019',
            $example_two_completed->payout_month_year(),
            'Current date plus six months month/year combinations not being correctly returned.'
        );
    }

    /**
     * Step Five: fix a bug by writing a test that will expose the bug and then fixing the code.
     */

    /**
     * Given we get a reported error where a post made on 31st Oct has an incorrect payout date,
     * we will control the DateTime and try and replicate the error in order to fix it.
     */
    public function test_payout_month_year_bug() {
        
        // Create a DateTime object.
        $datetime = new \DateTime( '2018-10-31' );

        // Double class.
		$example_two_completed = $this->getMockBuilder( __NAMESPACE__ . '\\Example_Two_Completed' )
			->setMethods( [ 'get_datetime' ] )
			->disableOriginalConstructor()
            ->getMock();
            
		// Return our date object.
		$example_two_completed->expects( $this->once() )
			->method( 'get_datetime' )
			->will( $this->returnValue( $datetime ) );

        $this->assertEquals(
            '04-2019',
            $example_two_completed->payout_month_year(),
            'Current date plus six months month/year combinations not being correctly returned.'
        );
    }
}
