<?php
/**
 * Testing Legacy Code.
 *
 * @package wordcamp_tdd/includes.
 */

namespace wordcamp_tdd\includes;

/**
 * Some legacy code to test.
 */
class Example_Two {

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
        
        // Establish user ID.
        $author_id = $post->post_author;

        // Get users current points.
        $author_points = (int) get_user_meta( $author_id, 'author_points', true );

        // Increment.
        $author_points += 50;

        // Update.
        update_user_meta( $author_id, 'author_points', $author_points );

        // Log payout data.
        update_user_meta( $author_id, 'payout_' . $post->ID, $this->payout_month_year() );
    }

    /**
     * Returns a month-year value for 6 months time.
     *
     * @return string m-Y.
     */
    public function payout_month_year() {

        $date = new \DateTime();
        $date->modify( "+6 months" );

        return $date->format( 'm-Y' );
    }
}
