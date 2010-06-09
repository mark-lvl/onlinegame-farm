<style>
    .boxy-inner{height:400px!important}
    .main-content{height:400px!important}
    #ajaxAlertBox
    {
        background: url(<?= $base_img ?>attention.png) top right no-repeat;
        padding-right: 40px;
        float: right;
        margin:8px 12px 0 0;
        width:100px;
        height: 30px;
        display:block;
        display: none;
    }
</style>
<script>
    $('#ajaxAlertBox').html('<?php echo str_replace(array('__PRICE__','__MONEY__'),array($params['price'],$params['money']),$lang['money']['body'])  ?>').fadeIn('slow');
</script>
