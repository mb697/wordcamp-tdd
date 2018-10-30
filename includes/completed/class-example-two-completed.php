<?php
/**
 * Testing legacy code.
 *
 * @package wordcamp_tdd/includes/completed.
 */

namespace wordcamp_tdd\includes\completed;

/**
 * Testing legacy code.
 */
class Example_Two_Completed {

    /**
     * Post author ID.
     *
     * @var integer.
     */
    private $author_id = 0;

    /**
     * Sets $author_id.
     *
     * @param object $post WP_Post.
     * @internal test_that_author_id_is_set_from_post_object
     */
    public function set_author_id( $post ) {
        $this->author_id = $post->post_author;
    }

    /**
     * Getter for $author_id.
     *
     * @return integer Post author ID.
     */
    public function get_author_id() {
        return $this->author_id;
    }

    /**
     * Current amount of points for post author.
     *
     * @var integer.
     */
    private $author_points = 0;

    /**
     * Sets current points value for the author.
     * 
     * @internal test_that_author_points_are_correctly_set.
     * @internal test_that_author_points_are_correctly_set_with_double.
     */
    public function set_author_points() {
        $author_id = $this->get_author_id();
        $this->author_points = (int) get_user_meta( $author_id, 'author_points', true );
    }

    /**
     * Increases the points for the author.
     *
     * @param integer $increase Amount to increase by.
     * @internal test_that_author_points_increase_correctly.
     */
    public function increase_author_points( $increase ) {
        $this->author_points += (int) $increase;
    }

    /**
     * Getter for $author_points.
     *
     * @return integer Current amount of points for post author.
     */
    public function get_author_points() {
        return $this->author_points;
    }

    /**
     * DateTime object.
     *
     * @var object.
     */
    private $datetime = null;

	/**
	 * Setter for $datetime.
	 */
	public function set_datetime() {
        $this->datetime = new \DateTime();
    }

    /**
     * Getter for $datetime.
     *
     * @return object DateTime object.
     */
    public function get_datetime() {
        return $this->datetime;
    }

    /**
	 * Init the plugin.
	 */
	public function init() {
        add_action( 'transition_post_status', [ $this, 'update_author' ], 10, 3 );
	}

    /**
     * Updates the post authors points by 50 if this is a newly published post and stores the date of last publish.
     * Publishing done via an interface that does not allow setting future post dates, private posts or post deletion.
     * Once a post is published, it cannot have its post_status reset.
     * E.g. 'draft', 'pending', 'auto-draft', and 'inherit' are the only post statuses we are concerned with.    
     *
     * @param string $new_status New post_status.
     * @param string $old_status Old post_status.
     * @param object $post       The post object.
     */
    public function update_author( $new_status, $old_status, $post ) {

        // If we are't publishing, we aren't doing anything.
        if ( 'publish' !== $new_status ) {
            return;
        }

        // This hook is deceptive as its triggered when statuses remain the same.
        if ( 'publish' === $old_status ) {
            return;
        }
        
        // Set author ID.
        $this->set_author_id( $post );

        // Set author points.
        $this->set_author_points();

        // Increment.
        $this->increase_author_points( 50 );

        // Set DateTime object.
        $this->set_datetime();

        // Update.
        $this->update_meta( $post );
    }

    /**
     * Updates all related user meta.
     *
     * @param object $post WP_Post.
     * @internal test_that_meta_updates.
     * @internal test_that_meta_updates_with_double.
     */
    public function update_meta( $post ) {

        $points = $this->get_author_points();
        $date   = $this->payout_month_year();

        $this->update_single_meta_field( 'author_points', $points );
        $this->update_single_meta_field( 'payout_' . $post->ID, $date );     
    }

    /**
     * Wraps update_user_meta.
     *
     * @param string $key   Meta key.
     * @param string $value Meta value.
     * @internal test_that_single_meta_fields_update.
     * @internal test_that_single_meta_fields_update_with_double.
     */
    public function update_single_meta_field( $key, $value ) {
        update_user_meta( $this->get_author_id(), $key, $value );
    }

    /**
     * Returns a month-year value for 6 months time.
     *
     * @return string m-Y.
     * @internal test_payout_month_year.
     * @internal test_payout_month_year_with_double.
     * @internal test_payout_month_year_bug.
     */
    public function payout_month_year() {

        $date = $this->get_datetime();
        $date->modify( "+6 months" );

        return $date->format( 'm-Y' );
    }
}
