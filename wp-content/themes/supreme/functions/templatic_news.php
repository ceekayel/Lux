<?php
add_action( 'wp_dashboard_setup', 'TemplaticDashboardWidgetSetup');
function TemplaticDashboardWidgetSetup() {
	add_meta_box( 'templatic_dashboard_news_widget', 'News From Templatic', 'TemplaticDashboardWidgetFunction', 'dashboard', 'normal', 'high' );
}

function TemplaticDashboardWidgetFunction() {
	//error_reporting(E_ALL);
	?>
	<div class="table table_tnews">
    <p class="sub"><strong><?php _e('Templatic News','supreme'); ?></strong></p>
    <div class="trss-widget">
	<?php
	$items = get_transient('templatic_dashboard_news');

    if (empty($items)) {
	include_once(ABSPATH . WPINC . '/class-simplepie.php');
    $trss = new SimplePie();
	$trss->set_timeout(5);
    $trss->set_feed_url('http://feeds.feedburner.com/Templatic');
    $trss->strip_htmltags(array_merge($trss->strip_htmltags, array('h1', 'a')));
    $trss->enable_cache(false);
    $trss->init();
    $items = $trss->get_items(0, 3);
	$cached = array();
	
    foreach ($items as $item) { 
        preg_match('/(.{128}.*?)\b/', $item->get_content(), $matches);
        $cached[] = array(
            'url' => $item->get_permalink(),
            'title' => $item->get_title(),
            'date' => $item->get_date("d M Y"),
            'content' => rtrim($matches[1]) . '...'
        );
    }
	 $items = $cached;
    set_transient('templatic_dashboard_news', $cached, 60 * 60 * 24);
	}
   
	?>
	<ul class="news">
            <?php 
                foreach ($items as $item) {
            ?>
            
                <li class="post">
                    <a href="<?php echo $item['url']; ?>" class="rsswidget"><?php echo $item['title']; ?></a>
                    <span class="rss-date"><?php echo $item['date']; ?></span>
                    <div class="rssSummary"><?php echo strip_tags($item['content']); ?></div>
                </li>
    <?php
                } 
            
            ?>
    </ul>
	</div>
	</div>
	<div class="t_theme">
		<div class="t_thumb">
        <?php		
			//$lastTheme = file_get_contents('http://templatic.com/latest-theme/');		
			$lastTheme='';
			$cache_key = 'dash_templatic_latest_theme';
			if ( false !== ( $lastTheme = get_transient( $cache_key ) ) ) {
				echo $lastTheme;	
			}else{	
				$raw_response = wp_remote_post( 'http://templatic.com/latest-theme/');
				if(! is_wp_error( $raw_response ) ) {			
					$lastTheme=$raw_response['body'];
				}
				if ($lastTheme){
					echo $lastTheme; 
				}
				set_transient( $cache_key, $lastTheme, 12 * HOUR_IN_SECONDS ); // Default lifetime in cache of 12 hours (same as the feeds)
			}
		?>

		</div>
    <div class="clearfix"></div>
  
	</div>
    <div class="clearfix"></div>
	<?php
}
?>