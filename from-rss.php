<?php
/*
Plugin Name: From RSS
Plugin URI: http://www.joostdevalk.nl/wordpress/from-rss/
Description: Adds <code>?source=rss</code> to your permalinks from RSS, and 301 redirects them to the correct URL while dropping a cookie, giving you the opportunity to treat your RSS readers differently. Use <code>from_rss();</code> to check whether a user came from an RSS feed.
Author: Joost de Valk
Version: 1.0
Author URI: http://www.joostdevalk.nl/
*/

if (!function_exists('add_rss_suffix')) {
	function add_rss_suffix($output) {
		if (strpos($output,"?")) {
			return $output . "&source=rss";
		} else {
			return $output . "?source=rss";	
		}
	}

	function redirect_rss() {
		global $onlinerssreaders;
		$strict = false;
		
		// Check if the source was an rss feed
		if (substr($_SERVER['REQUEST_URI'],-10) == "source=rss") {
			$expire = time() + 2592000;
			if (!$strict || $_SERVER['HTTP_REFERER'] == "" || ($strict && in_array($_SERVER['HTTP_REFERER'], $onlinerssreaders))) {
				setcookie(RSS_COOKIE, true, $expire, COOKIEPATH, COOKIE_DOMAIN);
			}
			// Remove the source parameter by 301 redirecting to the new page
			wp_redirect( substr($_SERVER['REQUEST_URI'], 0, (strlen($_SERVER['REQUEST_URI'])-11) ), 301 );
		}
	}
	
	function from_rss() {
		if ( !empty($_COOKIE[RSS_COOKIE]) ) {
			return true;
		}
		return false;
	}
	
	function parse_link($matches) {
		global $origin;
		if ((strpos($matches[2],$origin)) !== false) {
			if (strpos($matches[2],"?") !== false) {
				$suffix = "&source=rss";
			} else {
				$suffix = "?source=rss";
			}
		} else {
			$suffix = "";
		}
		return '<a href="' . $matches[2] . $suffix . '"' . $matches[1] . $matches[3] . '>' . $matches[4] . '</a>';
	}
	
	function add_rss_suffix_content($output) {
		// Loop through the content of a post and add ?source=rss to all links inside the blog.
		if (is_feed()) {
			$anchorPattern = '/<a (.*?)href="(.*?)"(.*?)>(.*?)<\/a>/i';
			$output = preg_replace_callback($anchorPattern,'parse_link',$output);
		}
		return $output;
	}

	$origin = get_bloginfo('wpurl');
	$onlinerssreaders = array(
		"NewsGator" => "http://www.newsgator.com/", 
		"My Yahoo" => "http://my.yahoo.com/", 
		"Google Reader" => "http://www.google.com/reader/", 
		"Rojo" => "http://www.rojo.com/", 
		"Excite MIX" => "http://mix.excite.co.uk/", 
		"iTunes" => "http://www.apple.com/itunes/", 
		"PodNova" => "http://www.podnova.com/", 
		"Newsburst" => "http://www.newsburst.com/", 
		"WINKsite" => "http://winksite.com/", 
		"Hubdog" => "http://www.hubdog.com/", 
		"BUZmob" => "http://www.buzmob.com/", 
		"Feedalot" => "http://www.feedalot.com/", 
		"NewsIsFree" => "http://www.newsisfree.com/", 
		"KlipFolio" => "http://www.klipfolio.com/klipfolio", 
		"MyHommy" => "http://www.myhommy.com/", 
		"NETime Channel" => "http://www.netimechannel.com/", 
		"Feed Mailer" => "http://www.feedmailer.net/", 
		"Rocket RSS Reader" => "http://reader.rocketinfo.com/", 
		"FireAnt" => "http://getfireant.com/", 
		"Sofomo" => "http://www.sofomo.com/", 
		"Newshutch" => "http://newshutch.com/", 
		"My Hosted reBlog" => "http://my.reblog.org/", 
		"FeedMarker" => "http://www.feedmarker.com/", 
		"FeedBucket" => "http://www.feedbucket.com/", 
		"FeedBlitz" => "http://www.feedblitz.com/", 
		"Bloglines" => "http://www.bloglines.com/", 
		"Windows Live" => "http://www.live.com/", 
		"Protopage News Feeds" => "http://www.protopage.com/", 
		"My AOL" => "http://feeds.my.aol.com/", 
		"TheFreeDictionary" => "http://www.thefreedictionary.com/", 
		"Webwag" => "http://www.webwag.com/", 
		"Daily Rotation" => "http://www.dailyrotation.com/", 
		"Bitty Browser Preview" => "http://www.bitty.com/", 
		"LiteFeeds" => "http://www.litefeeds.com/", 
		"Gritwire" => "http://www.gritwire.com/", 
		"FeedLounge" => "http://www.feedlounge.com/", 
		"FeedReader" => "http://www.feedreader.net/", 
		"FeedOnSite" => "http://www.feedonsite.com/", 
		"i metaRSS" => "http://i.metarss.com/", 
		"RssFwd" => "http://www.rssfwd.com/", 
		"Cheetah News" => "http://www.cheetah-news.com/", 
		"SimplyHeadlines" => "http://www.simplyheadlines.com/", 
		"Zhua Xia" => "http://www.zhuaxia.com/", 
		"IzyNews" => "http://izynews.com/", 
		"mobilerss" => "http://www.mobilerss.net/", 
		"Fyuze" => "http://www.fyze.com/", 
		"Google Toolbar" => "http://toolbar.google.com/", 
		"Blox0r" => "http://www.bloxor.com/", 
		"Netvibes" => "http://www.netvibes.com/", 
		"Pageflakes" => "http://www.pageflakes.com/", 
		"My MSN" => "http://my.msn.com/", 
		"Odeo" => "http://odeo.com/", 
		"My EarthLink" => "http://reader.earthlink.net/", 
		"RapidFeeds " => "http://reader.earthlink.net/", 
		"Miro" => "http://www.getmiro.com/", 
		"ZapTXT" => "http://zaptxt.com/", 
		"Newgie" => "http://newgie.com/", 
		"NewsAlloy" => "http://www.newsalloy.com/", 
		"Plusmo" => "http://www.plusmo.com/", 
		"Eskobo" => "http://www.eskobo.com/", 
		"FeedNut" => "http://feednut.com/", 
		"Alesti" => "http://www.alesti.org/", 
		"Rasasa" => "http://www.rasasa.com/", 
		"AvantGo" => "http://my.avantgo.com/", 
		"Newscabby" => "http://www.newscabby.com/", 
		"FeedHugger" => "http://www.feedhugger.com/", 
		"FeedShow" => "http://www.feedshow.com/", 
		"2RSS" => "http://www.2rrs.com/", 
		"Waggr" => "http://www.waggr.com/", 
		"Aggregato" => "http://www.aggregato.com/", 
		"NewsMob" => "http://www.newsmob.com/", 
		"FeedFeeds" => "http://www.feedfeeds.com/", 
		"Toppica" => "http://www.toppica.com/");

	add_filter('the_content','add_rss_suffix_content');
	add_filter('the_permalink_rss','add_rss_suffix');
	add_action('get_header','redirect_rss');
}

?>