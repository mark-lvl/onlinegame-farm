<style>
    .boxy-inner {height: 135px!important;overflow:auto;}
    .main-content{height:135px!important}
    .attention{vertical-align: middle;margin-left:10px}
</style>
<script>

    Boxy.confirm("<?= $lang[$params['action']."Confirm"] ?>", function() {

        var params = {};
        params['farm_id'] = <?= $params['farm_id'] ?>;
        params['confirmAccept'] = true;
        params['viewer_id'] = "<?= $params['viewer_id'] ?>";
	params['viewer_name'] = "<?= $params['viewer_name'] ?>";
        params['viewer_farm_id'] = "<?= $params['viewer_farm_id'] ?>";

        ajax_request('#ajaxHolder','<?= base_url() ?>farmtransactions/<?= $params[action] ?>',params,moneyCalculate) }, {title: '<?= $lang['becareful'] ?>'});
</script>
