<?php

include __DIR__.'/Parsedown.php';
include __DIR__.'/ParsedownExtra.php';

function templ_date($date) {
	$t = strtotime($date);
	return date('M j, Y', $t);
}
	
function templ_wrap($str, $cls) {
	return '<div class="' . $cls . '">' . $str . '</div>';
}

function templ_index($posts_by_category, $cat_filter, $tag_filter) {
	$s = '';
	if ($tag_filter || $cat_filter) {
		$s .= '<div class="filter"><a class="tag" href="/">&times;</a> Filtering by';
		$s .= ($tag_filter ? ' tag: ' . $tag_filter : '');
		$s .= ($cat_filter ? ' category: ' . $cat_filter : '');
		$s .= '</div>';
	} else {
		$s .= '<div class="info">';
		$s .= 'Hello! I try to keep this blog "timeless", in the sense that any post should be relevant ';
		$s .= 'in some way - even long after the original post is made. With that in mind, I may occasionally ';
		$s .= 'update or delete posts if I don\'t like them anymore. This blog is open source, you can ';
		$s .= 'check it out (along with all my other projects) from the Github link at the top of the page. ';
		$s .= '<br/><em>(I used to have a lot more content, but I removed a lot of it because it wasn\'t very good. Hopefully my writing can improve!)</em>';
		$s .= '</div>';
	}
	
	foreach ($posts_by_category as $cat => $posts) {
		$s .= '<div class="category"><h2>' . $cat . '</h2><ul>';
		foreach ($posts as $post) {
			$s .= '<li><a href="/post/' . $post->id . '">' . htmlspecialchars($post->title) . '</a>';
			foreach ($post->tags as $tag) {
				$s .= ' <a class="tag" href="/index/tag:' . $tag . '">' . $tag . '</a>';
			}
            if (isset($post->unpublished)) {
                $s .= ' <a class="tag unpublished" href="#">unpublished</a>';
            }
			$s .= '</li>';
		}
		$s .= '</ul></div>';
	}
	
	return templ_wrap($s, 'index');
}

function templ_post($post) {
	$pd = new ParsedownExtra();
	
	$s = '<h1>' . $post->title . '</h1>';
	$s .= '<h3>First posted on ' . templ_date($post->date) . ' in ' . $post->category . '</h3><div>';
	$s .= $pd->text($post->text);
	if (isset($post->log)) {
		$s .= '<hr/><h3>Changelog</h3>';
		$s .= '<ul>';
		$s .= '<li>' . $post->date . ' - Initial post</li>';
		foreach ($post->log as $log) $s .= '<li>' . $log . '</li>';
		$s .= '</ul>';
	}
	$s .= '</div>';
	$dsq_id = $post->id;
	if (isset($post->disqus_id)) {
		$dsq_id = $post->disqus_id;
	}
	
    if (!isset($post->unpublished)) {
        $s .= '<hr/><h2>Comments <small>(via Disqus)</small></h2>';
        $s .= "<div id=\"disqus_thread\"></div>
        <script type=\"text/javascript\">
            var disqus_shortname = 'logicandtrick';
            var disqus_identifier = '" . $dsq_id . "';
            var disqus_url = 'https://logic-and-trick.com/post/" . $post->id . "';
            var disqus_title = '" . $post->title . "';
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'https://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>";
    }
	
	return templ_wrap($s, 'post');
}