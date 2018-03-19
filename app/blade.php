<?php
Blade::extend(function($view){

  return preg_replace('/\@define(.+)/', '<?php ${1}; ?>', $view);
  
});

Blade::extend(function($view) {
	
	return preg_replace('/\@function(.+)/', '<?php function ${1}{ ?>', $view);

});

Blade::extend(function($value, $compiler) {
	$pattern = $compiler->createPlainMatcher('endfunction');

	$replace = '<?php }; ?>';

	return preg_replace($pattern, '$1'.$replace, $value);
});

\Shortcode::register('galeri', function($shortcode, $content, $compiler, $name){
	
	if($shortcode->lightbox){
		\Theme::asset()->usePath()->add('fancybox-css', 'fancybox/jquery.fancybox.css');
		\Theme::asset()->usePath()->add('fancybox-js', 'fancybox/jquery.fancybox.pack.js');
		
		\Theme::asset()->usePath()->add('fancybox-thumbnail-css', 'fancybox/helpers/jquery.fancybox-thumbs.css');
		\Theme::asset()->usePath()->add('fancybox-thumbnail-js', 'fancybox/helpers/jquery.fancybox-thumbs.js');

		\Helper::writeScript('fancybox-script', "
			jQuery(document).ready(function($){
				$('.thumbnail').fancybox({
					prevEffect:'none',
					nextEffect:'none',
					helpers:{
						title:{
							type:'outside'
						},
						thumbs:{
							width:50,
							height:50
						}
					},
					tpl: {
						next     : '<a class=\"fancybox-nav fancybox-next arrows\" href=\"javascript:;\"><div class=\"arrow\"><i class=\"fa fa-chevron-right\"></i></div></a>',
						prev     : '<a class=\"fancybox-nav fancybox-prev arrows\" href=\"javascript:;\"><div class=\"arrow\"><i class=\"fa fa-chevron-left\"></i></div></a>',
					}
				});
			});");
	}
	
	$gallery = \Helper::gallery($shortcode->id);
	$count = $shortcode->count ? 12 / $shortcode->count : 6;
	$return = "<div class='gallery'>";
	$return.= "<div class='row'>";
	
	foreach ($gallery as $item) {
		$return.= "<div class='col s6 col m{$count}'>";
		if ($shortcode->lightbox)
			$return.= "<a href='".asset($item->full_url)."' class='thumbnail' rel='fancybox-thumb-{$shortcode->id}'>";
		else
			$return.= "<a href='".asset($item->full_url)."' class='thumbnail' target='_blank'>";
		$return.= "<div class='image {$shortcode->class}'>";
		$return.= "<img src='".\Helper::thumb($item->full_url,[250,250])->image."' alt='".$item->title."' />";
		$return.= "</div>";
		$return.= "</a>";
		$return.= "</div>";
	}
	$return.="</div></div>";

	return $return;
});

\Shortcode::register('ortaklar', function($shortcode, $content, $compiler, $name){

	$gallery = \Helper::gallery($shortcode->id);
	$count = $shortcode->count ? 12 / $shortcode->count : 6;
	$return = "<div class='supporters'>";
	$return.= "<div class='row'>";
	
	foreach ($gallery as $item) {
		$return.= "<div class='col s6 col m{$count}'>";
		$return.= "<div class='supporter'>";
		$return.= "<div class='image' style=\"background-image:url('".\Helper::thumb($item->full_url,[250,250])->image."')\"></div>";
		if($item->title)
			$return.= "<div class='caption'>{$item->title}</div>";
		$return.= "</div></div>";
	}
	$return.="</div></div>";

	return $return;
});