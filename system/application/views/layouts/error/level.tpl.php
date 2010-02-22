<script>
    Boxy.alert("<?php echo str_replace(array('__NEEDLEVEL__','__LEVEL__','__ACCESSORY__'),
                                       array($params['needLevel'],$params['yourLevel'],$params['accessory']),
                                       $lang['level']['body'])  ?>",
               null,
               {title : "<?= $lang['level']['title'] ?>"});
</script>
