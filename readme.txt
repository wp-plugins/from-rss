=== Plugin Name ===
Contributors: joostdevalk
Donate link: http://www.joostdevalk.nl/donate/
Tags: rss
Requires at least: 2.3
Tested up to: 2.3.1
Stable tag: 1.0

Adds a tag to your permalinks from RSS, and 301 redirects them to the correct URL while dropping a cookie, giving you the opportunity to treat your RSS readers differently. Adds a function to check whether a user came from an RSS feed.

== Description ==

Adds `?source=rss` to your permalinks from RSS, and 301 redirects them to the correct URL while dropping a cookie, giving you the opportunity to treat your RSS readers differently. Use `from_rss();` to check whether a user came from an RSS feed.

* [From RSS?](http://www.joostdevalk.nl/wordpress/from-rss/).
* Other [Wordpress plugins](http://www.joostdevalk.nl/wordpress/) by the same author.
* Hire the author to code plugins for you: [WordPress plugins](http://www.altha.co.uk/wordpress/plugins/).

== Installation ==

1. Upload `from-rss.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php from_rss() ?>` in the appropriate loops in your templates