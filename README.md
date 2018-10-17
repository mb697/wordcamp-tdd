# Plugin for WordCamp Test Driven Development talk.

You will need:
1. A local install of WordPress
2. PHPUnit installed
3. WordPress Test Suite installed
4. This repo cloned to your plugins folder

I recommend using [Vagrant](https://www.vagrantup.com/) and [Varying Vagrant Vagrants](https://github.com/Varying-Vagrant-Vagrants/VVV) as this will take care of a local WordPress install, PHPUnit and the WordPress test suite.

Alternatively, you can follow these instructions on [WordPress.Org](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/)

To test that you have everything ready to go, cd into this plugin's directory, on my local install this would be:
`cd /srv/www/wordpress-default/public_html/wp-content/plugins/wordcamp-tdd`
and run: `phpunit`

All being well you will see:
OK (1 test, 1 assertion)
