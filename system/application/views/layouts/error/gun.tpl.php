<script>
    Boxy.alert("<?php echo str_replace(array('__ACCESSORY__',
                                             '__AFFECTTIME__',
                                             '__DECWEIGHT__'),
                                       array($params['accessory'],
                                             $params['affectTime'],
                                             $params['decWeight']
                                             ),
                                       $lang['gunDeffence']['body'])  ?>",
               null,
               {title : "<?= $lang['gunDeffence']['title'] ?>",afterHide: function() {
          location.reload();
        }
});
</script>