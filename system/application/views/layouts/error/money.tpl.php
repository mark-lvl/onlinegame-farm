<style>
    .boxy-inner {height: <?= $params['height'] ?>px!important;overflow:auto;}
    .main-content{height:<?= $params['height'] ?>px!important}
    .attention{vertical-align: middle;margin-left:10px}
</style>
<script>
    new Boxy("<div style=\"float:right\"><img src=\"<?= $base_img ?>attention.png\" class=\"attention\"/></div><div style=\"float:right\"><?php echo str_replace(array('__PRICE__','__MONEY__'),
                                                                                                           array($params['price'],$params['money']),
                                                                                                           $lang['money']['body'])  ?></div>",
             {title: "<?= $lang['money']['title'] ?>",modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/close.png\" />"});
</script>
