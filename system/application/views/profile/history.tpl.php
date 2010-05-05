<style>
  #centerContainer {
    background: url(<?= $base_img ?>profile/search_bg.gif) no-repeat top center;
    height: 395px;
    width: 464px;
    display: block;
    margin-top: 2px;
}
</style>
<div id="centerContainer">
<div id="searchContainer">
    <div id="searchHeader">
        <span class="title"><?= $lang['search'] ?></span>
        <span class="body"><?= str_replace(array('__COUNT__','__PARSE__'), array($cnt,$parse), $lang['searchResult']) ?></span>
    </div>
    <div id="searchAjaxHolder">
        <?php $this->load->view("$controllerName/search-inner.tpl.php", $items); ?>
    </div>
</div>

</div>