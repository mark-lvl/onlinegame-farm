<style>
    .boxy-inner {height: <?= $params['height'] ?>px !important;}
</style>
<?php
($params['title'])?$title = $params['title']:$title = $lang['notice'];
?>
<script>
    new Boxy('<div style=\'text-align:center\'><?= $params['message'] ?></div>', {title: "<?= $title ?>",modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/close.png\" />"});
</script>