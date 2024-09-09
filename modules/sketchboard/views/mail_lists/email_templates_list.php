<div class="col-md-12">
    <h4 class="bold well email-template-heading">
        <?php echo _l('sketchboard'); ?>
        <?php if ($hasPermissionEdit) { ?>
            <a href="<?php echo admin_url('emails/disable_by_type/sketchboard'); ?>" class="pull-right mleft5 mright25"><small><?php echo _l('disable_all'); ?></small></a>
            <a href="<?php echo admin_url('emails/enable_by_type/sketchboard'); ?>" class="pull-right"><small><?php echo _l('enable_all'); ?></small></a>
        <?php } ?>

    </h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo _l('email_templates_table_heading_name'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sketchboard as $sketchboard) { ?>
                    <tr>
                        <td class="<?php if (0 == $sketchboard['active']) {
                                        echo 'text-throught';
                                    } ?>">
                            <a href="<?php echo admin_url('emails/email_template/' . $sketchboard['emailtemplateid']); ?>"><?php echo $sketchboard['name']; ?></a>
                            <?php if (ENVIRONMENT !== 'production') { ?>
                                <br /><small><?php echo $sketchboard['slug']; ?></small>
                            <?php } ?>
                            <?php if ($hasPermissionEdit) { ?>
                                <a href="<?php echo admin_url('emails/' . ('1' == $sketchboard['active'] ? 'disable/' : 'enable/') . $sketchboard['emailtemplateid']); ?>" class="pull-right"><small><?php echo _l(1 == $sketchboard['active'] ? 'disable' : 'enable'); ?></small></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
