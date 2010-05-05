<style>
    .boxy-inner {height: <?= $params['height'] ?>px !important;}
    </style>
<script>
    new Boxy('<div style=\'text-align:center\'><?= $params['message'] ?></div>', {title: "<?= $lang['notice'] ?>",modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/close.png\" />"});
</script>