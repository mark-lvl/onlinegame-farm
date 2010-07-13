<style>
    #content{background: #536229;}
    .helpContainer{width: 210px;}
</style>
<div id="homeWrapper">
    <div class="genericPage">
        <div class="genericContainer">
            <div class="helpContainer">
                    <h1 style="text-align: center">
                        <?= $m_title ?>
                    </h1>
                    <?= $m_body ?>
                    <p style="text-align: center">
                        <a class="linkToHome"  href="<?= base_url() ?>">
                                            <?= $lang['home'] ?>
                        </a>
                    </p>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout("reloadPage()", 5000)
    function reloadPage()
    {
        window.location.replace("<?= base_url() ?>")
    }
</script>