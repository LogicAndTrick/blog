<?php

include __DIR__.'/BlogData.php';

    
/*
 * Data access
 */

// Get a post. Returns an object with: text, date, title, category, tags, and anything else that's set in the post metadata.
function get_post($id) {
	$file = __DIR__.'/../posts/'.$id.'.md';
	if (file_exists($file)) {
		$post = file($file);
		$c = count($post);
		$i = -1;
		for ($j = 0; $j < $c; $j++) {
			if (trim($post[$j]) == '') {
				$i = $j;
				break;
			} 
		}
		if ($i > -1) {
			$meta = json_decode(implode('', array_slice($post, 0, $i)));
			$meta->id = $id;
			$text = implode('', array_slice($post, $i));
			if ($meta !== null && strlen($text) > 0) {
				$meta->text = $text;
				return $meta;
			}
		}
	}
	return null;
}

// Get a list of unique tags
function get_tags() {
	global $tagData;
	return $tagData;
}

// Get a list of unique categories
function get_categories() {
	global $catData;
	return $catData;
}

// Get a list of posts, sorted by date descending. Can filter by category or tag.
function get_posts($cat = null, $tag = null) {
	global $blogData;
	return array_filter($blogData, function($post) use ($cat, $tag) {
		return (!$cat || $cat == $post->category) && (!$tag || array_search($tag, $post->tags) !== false);
	});
}

function get_posts_by_category($cat = null, $tag = null) {
	$cats = [];
	$posts = get_posts($cat, $tag);
	foreach ($posts as $p) {
		if (!array_key_exists($p->category, $cats)) $cats[$p->category] = [];
		$cats[$p->category][] = $p;
	}
	ksort($cats);
	return $cats;
}