<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            @font-face {font-family: 'IBM Plex Mono', monospace;}
            body { font-family:'IBM-Plex-Mono', monospace; font-size: 170%; }
            a:visited { color: #a3bcd1; }
        </style>
    </head>
    <body>
<div class="container">
    <h1>Omni News</h1>
            <div class="row">	
                <div class="col-md-8" >
                <?php

                    function getContent() {
                        //Thanks to https://davidwalsh.name/php-cache-function for cache idea
                        $file = "";
                        $current_time = time();
                        $expire_time = 5 * 60;
                        $file_time = filemtime($file);

                        if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
                            return file_get_contents($file);
                        }
                        else {
                            $content = getFreshContent();
                            file_put_contents($file, $content);
                            return $content;
                        }
                    }
		    function getFreshContent() {
                        $html = "";
			$newsSource = array( 
                            array(
                                "title" => "The New York Times",
                                "url" => "https://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml"
			    ),
						  
			    array(
                                "title" => "Techmeme",
                                "url" => "https://www.techmeme.com/feed.xml"
                            ),
			    
			    array(
                                "title" => "ESPN Top Headlines",
                                "url" => "https://www.espn.com/espn/rss/news"
                            ),
			    
			    array(
                                "title" => "Hacker News",
                                "url" => "https://news.ycombinator.com/rss"
                            ),
			    
			    array(
				"title" => "Fox News",
				"url" => "http://feeds.foxnews.com/foxnews/latest"
			    ),
			    
			    array(
				"title" => "CNN",
				"url" => "http://rss.cnn.com/rss/cnn_latest.rss"
			    ),
			    
			    array(
				"title" => "aljazeera",
				"url" => "http://aljazeera.com/xml/rss/all.xml"
			    ),
			    
			    array(
				"title" => "Defence Blog",
				"url" => "http://defence-blog.com/feed"
			    ),
			    
			    array(
				"title" => "E-International Relations",
				"url" => "http://e-ir.info/category/blogs/feed"
			    ),
				
			    array(
				"title" => "The Cipher Brief",
				"url" => "http://thecipherbrief.com/feed"
			    ),
				
			    array(
				"title" => "The Guardian",
				"url" => "http://theguardian.com/world/rss"
			    ),	

		        );


                        foreach($newsSource as $source) {
                            $html .= '<h2>'.$source["title"].'</h2>';
                            $html .= getFeed($source["url"]);
                        }
                        return $html;
                    }
			
			function getFeed($url){
                            $html = "";
                            $rss = simplexml_load_file($url);
                            $html .= '<ul>';
                            foreach($rss->channel->item as $item) {
                                $html .= '<li><a href="'.htmlspecialchars($item->link).'">'.htmlspecialchars($item->title).'</a></li>';
                            }
                            $html .= '</ul>';
                            return $html;
                        }
		?>
		  
                	<div class="bg-info">  
                		<?php print getContent(); ?>
                	</div>
                </div>  
            </div>
        </div>
    </body>
</html>
