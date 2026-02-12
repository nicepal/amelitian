<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">
    <section class="content-header"></section>
    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('reports/_finance'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                    <div class="box-header ">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>

                    <form role="form" action="<?php echo site_url('report/all_fee') ?>" method="post" class="">
                        <div class="box-body row">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="col-sm-3 col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('from') . " " . $this->lang->line('date'); ?><small class="req"> *</small></label>
                                    <input type="text" class="form-control date" name="from_date" value="<?php echo isset($from_date) ? $from_date : ''; ?>" required>
                                    <span class="text-danger"><?php echo form_error('from_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('to') . " " . $this->lang->line('date'); ?><small class="req"> *</small></label>
                                    <input type="text" class="form-control date" name="to_date" value="<?php echo isset($to_date) ? $to_date : ''; ?>" required>
                                    <span class="text-danger"><?php echo form_error('to_date'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if (isset($payments) && !empty($payments)) { ?>
                        <div class="">
                            <div class="box-header ptbnull"></div>
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"><i class="fa fa-money"></i> All Fee Report - <?php echo isset($label) ? $label : ''; ?></h3> 
                            </div>
                            <div class="box-body table-responsive" id="transfee">
                                <div class="download_label">All Fee Report<br>
                                    <?php echo isset($label) ? $label : ''; ?>
                                </div>
                                <form method="post" action="<?php echo site_url('report/all_fee') ?>" style="display: inline;">
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <input type="hidden" name="from_date" value="<?php echo isset($from_date) ? $from_date : ''; ?>">
                                    <input type="hidden" name="to_date" value="<?php echo isset($to_date) ? $to_date : ''; ?>">
                                    <input type="hidden" name="export_excel" value="1">
                                    <button type="submit" class="btn btn-default btn-xs pull-right" id="btnExport"><i class="fa fa-file-excel-o"></i> <?php echo $this->lang->line('excel'); ?></button>
                                </form>
                                <table class="table table-striped table-hover" id="headerTable">
                                    <thead class="header">
                                        <tr>
                                            <th><?php echo $this->lang->line('date'); ?> of Transaction</th>
                                            <th>Student ID</th>
                                            <th>Class Name</th>
                                            <th>Section</th>
                                            <th>Student Name</th>
                                            <th>Amount Collected</th>
                                            <th>Details linked to the receipt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_amount = 0;
                                        foreach ($payments as $payment) {
                                            $total_amount += isset($payment['amount_collected']) ? $payment['amount_collected'] : 0;
                                            ?>
                                            <tr>
                                                <td><?php echo isset($payment['date']) ? date($this->customlib->getSchoolDateFormat(), strtotime($payment['date'])) : ''; ?></td>
                                                <td><?php echo isset($payment['student_id']) ? htmlspecialchars($payment['student_id']) : ''; ?></td>
                                                <td><?php echo isset($payment['class_name']) ? htmlspecialchars($payment['class_name']) : ''; ?></td>
                                                <td><?php echo isset($payment['section']) ? htmlspecialchars($payment['section']) : ''; ?></td>
                                                <td><?php echo isset($payment['student_name']) ? htmlspecialchars($payment['student_name']) : ''; ?></td>
                                                <td><?php echo isset($payment['amount_collected']) ? $currency_symbol . ' ' . number_format($payment['amount_collected'], 2) : $currency_symbol . ' 0.00'; ?></td>
                                                <td><?php echo isset($payment['receipt_details']) ? htmlspecialchars($payment['receipt_details']) : ''; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr style="font-weight: bold;">
                                            <td colspan="5" align="right">Total:</td>
                                            <td><?php echo $currency_symbol . ' ' . number_format($total_amount, 2); ?></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else if (isset($payments)) { ?>
                        <div class="box-body">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No payments found for the selected date range.
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('.date').datepicker({
            format: date_format,
            autoclose: true
        });
    });
</script>
