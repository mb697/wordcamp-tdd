# Plugin for WordCamp Test Driven Development talk.

You will need:
1. A local install of WordPress
2. PHPUnit installed
3. WordPress Test Suite installed
4. This repo cloned to your plugins folder

I recommend using [Vagrant](https://www.vagrantup.com/) and [Varying Vagrant Vagrants](https://github.com/Varying-Vagrant-Vagrants/VVV) as this will take care of a local WordPress install, PHPUnit and the WordPress test suite.

Alternatively, you can follow these instructions on [WordPress.Org](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/)

To test that you have everything ready to go, cd into this plugin's directory, on my local install this would be:
```
cd /srv/www/wordpress-default/public_html/wp-content/plugins/wordcamp-tdd
```
and run: 
```
phpunit tests/class-test-install.php
```

All being well you will see a cheesy message from me and:
OK (1 test, 1 assertion)

## WP Unit Syntax 

### Add a User
```
$user_id = $this->factory->user->create();
```

### Add a User with params
You can insert a user with defined values.
See [WordPress Codex](https://codex.wordpress.org/Function_Reference/wp_insert_user) for available params.
```
$user_id = $this->factory->user->create( [
    'display_name'  => 'Matt',
] );
```

### Add a Post
```
$post_id = $this->factory->post->create();
```

### Add a Post with params
See [WordPress Codex](https://developer.wordpress.org/reference/functions/wp_insert_post/) for available params.
```
$this->factory->post->create( [
    'post_status'   => 'publish',
    'post_author'   => $user_id,
] );
```

### Update a Post
See [WordPress Codex](https://developer.wordpress.org/reference/functions/wp_insert_post/) for available params.
```
$this->factory->post->update_object( $post_id, [
    'post_status'   => 'publish',
    'post_author'   => $user_id,
] );
```

See [WP Unit Factories Source Code](https://github.com/rnagle/wordpress-unit-tests/blob/master/includes/factory.php) for more examples.

## PHPUnit Syntax

### Assert that two values match
```
$this->assertEquals(
    $expected_value,
    $actual_value,
    'A relevant message about the test being run that displays if the test fails'
);
```

### DataProvider example
```
/**
 * DataProvider for test_value_match.
 *
 * @return array $value_one, $value_two, $expects.
 */
public function our_data_provider() {

    return [
        [ 1, 1, true ],
        [ 1, 2, false ],
        [ 1, '1', false ],
    ];
}

/**
 * Tests with a DataProvider.
 *
 * @param mixed   $value_one First value
 * @param mixed   $value_two Value to compare with first value.
 * @param boolean $expects   If values match.
 * @dataProvider our_data_provider
 */
public function test_value_match( $value_one, $value_two, $expects ) {

    $this->assertSame(
        $expects,
        $value_one === $value_two,
        'Values not being correctly evaluated.'
    );
}
```

### Test Double example
```
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
```
