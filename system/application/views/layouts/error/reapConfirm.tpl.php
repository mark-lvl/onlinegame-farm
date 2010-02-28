<script>
    Boxy.alert("<?php echo str_replace(array('__FARMCAPACITY__',
                                             '__TYPENAME__',
                                             '__HEALTH__',
                                             '__AMOUNTPRODUCT__',
                                             '__MISAMOUNT__',
                                             '__TOTALCOST__',
                                             '__BONUS__',
                                             '__MISDEADLINE__',
                                             '__REAPTIME__',
                                             '__LEVEL__'),

                                       array($params['farmCapacity'],
                                             $params['typeName'],
                                             $params['health'],
                                             $params['amountProduct'],
                                             $params['misAmount'],
                                             $params['totalCost'],
                                             $params['bonus'],
                                             convert_number(fa_strftime("%d %B %Y %H:%M:%S", date("Y-m-d H:i:s",$params['misDeadline']) . "")),
                                             convert_number(fa_strftime("%d %B %Y %H:%M:%S", date("Y-m-d H:i:s",$params['reapTime']) . "")),
                                             $params['level']),

                                       $lang['reapConfirm']['body'])  ?>",
               null,
               {title : "<?= $lang['reapConfirm']['title'] ?>",afterHide: function() {
          location.reload();
        }
});
</script>