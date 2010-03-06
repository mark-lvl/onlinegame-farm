<script>
    Boxy.alert("<?php echo str_replace(array('__ACCESSORY__',
                                             '__AFFECTTIME__',
                                             '__DECHEALTH__'),
                                       array($params['accessory'],
                                             $params['affectTime'],
                                             $params['decHealth']
                                             ),
                                       $lang['farmNotNeedSpray']['body'])  ?>",
               null,
               {title : "<?= $lang['farmNotNeedSpray']['title'] ?>",afterHide: function() {
          location.reload();
        }
});
</script>