<script>
    Boxy.alert("<?php echo str_replace(array('__PRICE__','__MONEY__'),
                                       array($params['price'],$params['money']),
                                       $lang['money']['body'])  ?>",
               null,
               {title : "<?= $lang['money']['title'] ?>"});
</script>
