<style>
    .boxy-inner {height: 135px!important;overflow:auto;}
    .main-content{height:135px!important}
    .attention{vertical-align: middle;margin-left:10px}
</style>
<script>

    Boxy.confirm("<?= $lang['moneyHelpConfirm'] ?>", function() { 
        var params = {};
	params['goal_farm'] = <?= $params['goal_farm'] ?>;
	params['off_farm'] = <?= $params['off_farm'] ?>;
	params['user_id'] = <?= $params['user_id'] ?>;
	params['acc_id'] = 0;
	params['type'] = 3;
	params['details'] = 3;
        ajax_request('#ajaxHolder','<?= base_url() ?>farmtransactions/add',params,moneyCalculate) }, {title: '<?= $lang['becareful'] ?>'});


</script>
