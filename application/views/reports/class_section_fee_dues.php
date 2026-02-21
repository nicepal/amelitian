<?php
$currency_symbol = isset($currency_symbol) ? $currency_symbol : $this->customlib->getSchoolCurrencyFormat();
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> Class Section Fee Dues <small> Fee dues by class and section</small>
        </h1>
    </section>
    <section class="content">
        <?php $this->load->view('reports/_finance'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('report/class_section_fee_dues'); ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?> <small class="req">*</small></label>
                                        <select id="class_id" name="class_id" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php foreach ($classlist as $c): ?>
                                                <option value="<?php echo $c['id']; ?>" <?php echo (isset($class_id) && $class_id == $c['id']) ? 'selected' : ''; ?>><?php echo $c['class']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?> <small class="req">*</small></label>
                                        <select id="section_id" name="section_id" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php if (!empty($section_list)): ?>
                                                <?php foreach ($section_list as $s): ?>
                                                    <option value="<?php echo $s['section_id']; ?>" <?php echo (isset($section_id) && $section_id == $s['section_id']) ? 'selected' : ''; ?>><?php echo $s['section']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if (isset($class_id) && $class_id && isset($section_id) && $section_id): ?>
                    <div class="box-body table-responsive" id="reportTable">
                        <div class="download_label">Class Section Fee Dues Report</div>
                        <a class="btn btn-default btn-xs pull-right" id="printBtn" onclick="printDiv()"><i class="fa fa-print"></i> Print</a>
                        <button class="btn btn-default btn-xs pull-right" id="excelBtn" onclick="fnExcelReport()"><i class="fa fa-file-excel-o"></i> Excel</button>
                        <table class="table table-striped table-bordered table-hover" id="headerTable">
                            <thead>
                                <tr>
                                    <th class="text-left"><?php echo $this->lang->line('student_name'); ?></th>
                                    <th class="text-left"><?php echo $this->lang->line('admission_no'); ?></th>
                                    <th class="text-right">Total Dues <span>(<?php echo $currency_symbol; ?>)</span></th>
                                    <?php foreach ($fee_columns as $fc): ?>
                                        <th class="text-center" colspan="3"><?php echo htmlspecialchars($fc); ?></th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <?php foreach ($fee_columns as $fc): ?>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">Paid</th>
                                        <th class="text-right">Balance</th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($students)): ?>
                                    <tr><td colspan="<?php echo 3 + count($fee_columns) * 3; ?>" class="text-center">No students found.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($students as $row): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['admission_no']); ?></td>
                                            <td class="text-right"><?php echo number_format($row['total_dues'], 2); ?></td>
                                            <?php foreach ($fee_columns as $fc): ?>
                                                <?php
                                                $ft = isset($row['by_type'][$fc]) ? $row['by_type'][$fc] : array('total' => 0, 'paid' => 0, 'balance' => 0);
                                                ?>
                                                <td class="text-right"><?php echo number_format($ft['total'], 2); ?></td>
                                                <td class="text-right"><?php echo number_format($ft['paid'], 2); ?></td>
                                                <td class="text-right"><?php echo number_format($ft['balance'], 2); ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('change', '#class_id', function () {
        var class_id = $(this).val();
        $('#section_id').html('<option value=""><?php echo $this->lang->line("select"); ?></option>');
        if (!class_id) return;
        var base_url = '<?php echo base_url(); ?>';
        $.ajax({
            type: "GET",
            url: base_url + "sections/getByClass",
            data: { class_id: class_id },
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj) {
                    $('#section_id').append('<option value="' + obj.section_id + '">' + obj.section + '</option>');
                });
            }
        });
    });
});
function printDiv() {
    document.getElementById("printBtn").style.display = "none";
    document.getElementById("excelBtn").style.display = "none";
    var divElements = document.getElementById('reportTable').innerHTML;
    var oldPage = document.body.innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
    window.print();
    document.body.innerHTML = oldPage;
    document.getElementById("printBtn").style.display = "inline-block";
    document.getElementById("excelBtn").style.display = "inline-block";
}
function fnExcelReport() {
    var tab = document.getElementById('headerTable');
    var tab_text = "<table border='2px'>" + tab.innerHTML + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
    tab_text = tab_text.replace(/<img[^>]*>/gi, "");
    var sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    return sa;
}
</script>
