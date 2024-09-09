<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="tw-flex tw-justify-between tw-items-center">
                            <h4 class="tw-my-0 tw-font-semibold">
                                <?php echo _l('sketch_board'); ?>
                            </h4>
                            <div>
                                <?php if (staff_can('create', 'sketchboard')) { ?>
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#sketchboard_model" id="addSketchBoard">
                                        <?php echo _l('create_new_sketch_board'); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-separator">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-table-full">
                                    <?php $table_data = [
                                        _l('the_number_sign'),
                                        _l('title'),
                                        _l('description'),
                                        _l('shared_with'),
                                        _l('actions'),
                                    ];
                                    ?>
                                    <?php echo render_datatable($table_data, "sketchboard_table", []) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="sketchboard_model" tabindex="-1" role="dialog">
                        <?php echo form_open("", ["id" => "sketch_board_form"], ['id' => '']) ?>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"><?php echo _l('sketch_board_details'); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo render_input("title", "title") ?>
                                    <?php echo render_textarea("description", "description"); ?>
                                    <?php echo render_select('shared_to[]', $staff, ['staffid', ['firstname', 'lastname']], _l('shared_to'), '', ['data-width' => '100%', 'data-actions-box' => true, 'multiple' => true], [], 'no-mbot', '', false); ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                                    <button type="submit" class="btn btn-primary"><?php echo _l("save") ?></button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(document).ready(function() {
        $('button[type="submit"]').prop('disabled', false);
        appValidateForm($('#sketch_board_form'), {
            title: "required",
        }, submitHandlar);

        initDataTable(".table-sketchboard_table", admin_url + 'sketchboard/get_table_data', [3], [3]);

        function submitHandlar(form) {
            $('button[type="submit"]').prop('disabled', true);
            var formData = $(form).serialize();
            $.ajax({
                url: `${admin_url}sketchboard/save`,
                type: 'post',
                data: formData,
                dataType: 'json',
            }).done(function(response) {
                alert_float(response.type, response.message);
                $('#sketchboard_model').modal('hide');
                $('button[type="submit"]').prop('disabled', false);
                $('.table-sketchboard_table').DataTable().ajax.reload();
            });
        }

        $("#addSketchBoard").on("click", function() {
            $('select[name="shared_to[]"]').val('').selectpicker("refresh");
            $('#sketch_board_form').trigger("reset");
            $('input[name=id]').val('');
        })

        $(document).on("click", ".update", function() {
            $("input[name=id]").val($(this).data('id'));
            $("input[name=title]").val($(this).data('title'));
            $("textarea[name=description]").val($(this).data('description'));
            $('select[name="shared_to[]"]').val($(this).data('shared_to')).selectpicker("refresh");
            init_selectpicker();
            $('#sketchboard_model').modal('show');
        });
    });
</script>
