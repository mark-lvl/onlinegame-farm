<style>
    .boxy-inner {height: 135px!important;overflow:auto;}
    .main-content{height:135px!important}
</style>
<script>
    Boxy.alert("<?php echo str_replace(array('__ACCESSORY__',
                                             '__AFFECTTIME__',
                                             '__DECWEIGHT__'),
                                       array($lang[$params['accessory']],
                                             $params['affectTime'],
                                             $params['decWeight']." ".$lang['kilogram']
                                             ),
                                       $lang['gunDeffence']['body'])  ?>",
               null,
               {title : "<?= $lang['gunDeffence']['title'] ?>",afterHide: function() {
          location.reload();
        }
});
</script>