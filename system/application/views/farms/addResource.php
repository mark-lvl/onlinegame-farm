<script>
if(<?= $placeHolder ?> == 1)
	$('#waterAmount').html($('#waterAmount').text() - 1);
else
	$('#muckAmount').html($('#muckAmount').text() - 1);	



var remainTime = <?= $consumeTime ?>*3600;
$('#resourceCounter<?= $placeHolder ?>').countdown('change',{until: remainTime,
				<?php if(!isset($partner)): ?>
                                onExpiry: resourceExipre<?= $placeHolder ?> ,
				<?php endif; ?>
				layout: '<div class="image{d10}"></div><div class="image{d1}"></div>' +
                                        '<div class="imageDay"></div><div class="imageSpace"></div>' +
                                        '<div class="image{h10}"></div><div class="image{h1}"></div>' +
                                        '<div class="imageSep"></div>' +
                                        '<div class="image{m10}"></div><div class="image{m1}"></div>' +
                                        '<div class="imageSep"></div>' +
                                        '<div class="image{s10}"></div><div class="image{s1}"></div>'
                                    });
</script>
