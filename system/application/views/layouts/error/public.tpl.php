<style>
    .boxy-inner {height: <?= $params['height'] ?>px!important;overflow:auto;}
    .main-content{height:<?= $params['height'] ?>px!important}
    .attention{vertical-align: middle;margin-left:10px}
</style>
<script>
    new Boxy("<span><img src=\"<?= $base_img ?>attention.png\" class=\"attention\"/><?= $lang['error'][$params['message']] ?></span>",
             {title: "<?= $lang['public']['title'] ?>",modal: true ,unloadOnHide:true, closeText:"<img src=\"<?= $base_img ?>/popup/boxy/close.png\" />"<?php
                                                                                                                                                         if($params['afterHide'] && ($params['afterHide'] == 'reloadPage')): ?>
                                                                                                                                                         ,afterHide: function() {location.reload();}<?php endif; ?>
                                                                                                                                                         });
</script>
