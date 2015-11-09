<?php

    include 'php/DataAccess.php';
    include 'php/Templates.php';
    
    /*
     * Who needs MVC frameworks when you can just do everything manually?
     */
    
    // Index action. Valid parameter values: cat:{cat}, tag:{tag}
    function action_index($parameter) {
        $cat = null;
        $tag = null;
        if (strlen($parameter) > 4) {
            if (substr($parameter, 0, 4) == 'cat:') $cat = substr($parameter, 4);
            if (substr($parameter, 0, 4) == 'tag:') $tag = substr($parameter, 4);
        }
        $pbc = get_posts_by_category($cat, $tag);
        return [
            'title' => $cat == '' ? ($tag == '' ? '' : 'Tag: ' . $tag) : 'Category: ' . $cat,
            'content' => templ_index($pbc, $cat, $tag)
        ];
    }
    
    // Post action. Valid parameter values: {post}
    function action_post($parameter) {
        $post = get_post($parameter);
        
        $title = '';
        $content = '';
        
        if ($post === null) {
            header ("HTTP/1.1 404 Not Found");
            $title = 'Not Found';
            $content = '<h2>404 Not Found</h2> Sorry, this post doesn\'t exist!';
        } else {
            $title = $post->title;
            $content = templ_post($post);
        }
        return [
            'title' => $title,
            'content' => $content
        ];
    }
    
    /*
     * Very simple routes: {action}/{parameter}
     * Implemented actions: index, post
     */
	$rt = isset($_REQUEST['rt']) ? $_REQUEST['rt'] : '';
	
	$parts = explode('/', $rt);
	if (empty($parts)) $parts[] = '';
    if (count($parts) < 2) $parts[] = ''; 
	
    $result = null;
    $title = '';
	$content = '';
	
	switch ($parts[0]) {
		case '':
        case 'index':
			$result = action_index($parts[1]);
            $title = $result['title'];
            $content = $result['content'];
			break;
		case 'post';
			$result = action_post($parts[1]);
            $title = $result['title'];
            $content = $result['content'];
			break;
        default:
            header ("HTTP/1.1 404 Not Found");
            $title = 'Not Found';
            $content = '<h2>404 Not Found</h2> This page doesn\'t exist!';
            break;
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title == '' ? '' : $title . ' - '; ?>Logic &amp; Trick</title>
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="stylesheet" type="text/css" href="/css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/css/default.css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <a class="logo" href="/">
                    <img src="/img/lnt_logo_2013.png" alt="Logic &amp; Trick" />
                </a>
            </div>
            <div class="footer">
                &copy; Logic & Trick <?php echo date('Y') ?>
                <span class="splitter">&bull;</span>
                <a href="http://github.com/LogicAndTrick">Github</a>
                <span class="splitter">&bull;</span>
                <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/">
                    <img alt="Creative Commons License" src="http://i.creativecommons.org/l/by-nc-nd/3.0/80x15.png">
                </a>
            </div>
            <div class="content">
                <?php echo $content; ?>
            </div>
        </div>
    </body>
</html>
