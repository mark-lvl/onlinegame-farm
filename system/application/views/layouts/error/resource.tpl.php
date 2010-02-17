<script>
    Boxy.alert("<?php echo str_replace(array('__RESOURCE__','__FARMRESOURCE__','__NEED__'),
                                       array($params['resource'],$params['farm_resource'],$params['need']),
                                       $lang['resource']['body'])  ?>",
               null,
               {title : "<?= $lang['resource']['title'] ?>"});
</script>
