<center>
        <div class="header_bg">
        </div>
        <div class="container">
                <div class="container_header">
                    <div class="renault_home">
                    </div>
                        <?php
                                $this->load->module('login');
                                $this->login->method(array("user" => $user, "lang" => $lang));
                        ?>
                </div>
                <p style="text-align: center">
                    <a class="little_link" href="<?= base_url() ?>registration/">
				        <?= $lang['registration_title'] ?>
                    </a>
                  </p>
        </div>
        <?php
                $this->load->module('footer');
                $this->footer->method(array("lang" => $lang));
        ?>
</center>
	
