<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12" style="padding: 0px;">
                <div class="page-content clearfix contract-details-view pb0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contract-title-section">
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <div>
                                            <div class="title-button-group mr0">
                                                <?php echo form_open(admin_url("sketchboard/save"), array("id" => "sketchboard-form", "class" => "general-form dashed-row", "role" => "form"), ['id' => $board_info['id'] ?? '', 'board_data' => $board_info['board_data'] ?? '']); ?>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="root"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script src="<?= module_dir_url('sketchboard', 'assets/js/main.bundle.js') ?>"></script>
<script type="text/javascript">
    "use strict";
    $(document).ready(function() {
        // if you want to hide library button
        //$(".layer-ui__wrapper__top-right").remove();

        // if you want to hide help button
        //$(".layer-ui__wrapper__footer-right").empty();

        // if you want to hide embeddable option
        //$('.Island dropdown-menu-container button[data-testid="toolbar-embeddable"]').hide();
    });
</script>