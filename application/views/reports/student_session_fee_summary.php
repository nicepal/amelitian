<?php
$currency_symbol = isset($currency_symbol) ? $currency_symbol : $this->customlib->getSchoolCurrencyFormat();
$fmt = function ($n) use ($currency_symbol) {
    return $currency_symbol . ' ' . number_format((float) $n, 2);
};
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo htmlspecialchars($title); ?>
            <small> <?php echo $this->lang->line('session'); ?>, <?php echo $this->lang->line('class'); ?> &amp; <?php echo $this->lang->line('section'); ?></small>
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
                    <form action="<?php echo site_url('report/student_session_fee_summary'); ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('session'); ?> <small class="req">*</small></label>
                                        <select id="session_id" name="session_id" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php if (!empty($sessionlist)) { ?>
                                                <?php foreach ($sessionlist as $s) { ?>
                                                    <option value="<?php echo $s['id']; ?>" <?php echo (isset($session_id) && (string) $session_id === (string) $s['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($s['session']); ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('session_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?> <small class="req">*</small></label>
                                        <select id="class_id" name="class_id" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php foreach ($classlist as $c) { ?>
                                                <option value="<?php echo $c['id']; ?>" <?php echo (isset($class_id) && (string) $class_id === (string) $c['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['class']); ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?> <small class="req">*</small></label>
                                        <select id="section_id" name="section_id" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php if (!empty($section_list)) { ?>
                                                <?php foreach ($section_list as $sec) { ?>
                                                    <option value="<?php echo $sec['section_id']; ?>" <?php echo (isset($section_id) && (string) $section_id === (string) $sec['section_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($sec['section']); ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if (!empty($error_message)) { ?>
                        <div class="box-body">
                            <div class="alert alert-warning"><?php echo htmlspecialchars($error_message); ?></div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($report) && !empty($report['rows'])) { ?>
                        <div class="box-body table-responsive" id="reportTable">
                            <div class="download_label"><?php echo htmlspecialchars($title); ?></div>
                            <a class="btn btn-default btn-xs pull-right" id="printBtn" onclick="printDiv()"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></a>
                            <button type="button" class="btn btn-default btn-xs pull-right" id="excelBtn" onclick="fnExcelReport()"><i class="fa fa-file-excel-o"></i> Excel</button>

                            <h4 class="text-bold" style="margin-top: 0;"><?php echo $this->lang->line('summary'); ?> — <?php echo htmlspecialchars($report['session_label']); ?></h4>
                            <table class="table table-striped table-bordered table-hover" id="headerTable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                        <th>Class / <?php echo $this->lang->line('section'); ?></th>
                                        <th class="text-right">Tuition <?php echo $this->lang->line('fees'); ?> (Assigned)</th>
                                        <th class="text-right">Tuition <?php echo $this->lang->line('fees'); ?> (Paid)</th>
                                        <th class="text-right">Tuition <?php echo $this->lang->line('fees'); ?> (Balance)</th>
                                        <th class="text-right">Mess <?php echo $this->lang->line('fees'); ?> (Assigned)</th>
                                        <th class="text-right">Mess <?php echo $this->lang->line('fees'); ?> (Paid)</th>
                                        <th class="text-right">Mess <?php echo $this->lang->line('fees'); ?> (Balance)</th>
                                        <th class="text-right">Total Assigned</th>
                                        <th class="text-right">Total Paid</th>
                                        <th class="text-right">Total Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($report['rows'] as $r) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($r['student_name']); ?></td>
                                            <td><?php echo htmlspecialchars($r['admission_no']); ?></td>
                                            <td><?php echo htmlspecialchars($r['class_section']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['tuition']['assigned']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['tuition']['paid']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['tuition']['balance']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['mess']['assigned']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['mess']['paid']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['mess']['balance']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['totals']['assigned']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['totals']['paid']); ?></td>
                                            <td class="text-right"><?php echo $fmt($r['totals']['balance']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php if (!empty($report['breakdown_rows'])) { ?>
                            <h4 class="text-bold">Breakdown by student and fee type</h4>
                            <table class="table table-striped table-bordered table-hover" id="breakdownTable">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                        <th>Fee type</th>
                                        <th class="text-right">Assigned</th>
                                        <th class="text-right">Paid</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($report['breakdown_rows'] as $br) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($br['student_name']); ?></td>
                                            <td><?php echo htmlspecialchars($br['admission_no']); ?></td>
                                            <td><?php echo htmlspecialchars($br['fee_type']); ?></td>
                                            <td class="text-right"><?php echo $fmt($br['assigned']); ?></td>
                                            <td class="text-right"><?php echo $fmt($br['paid']); ?></td>
                                            <td class="text-right"><?php echo $fmt($br['balance']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function getSectionByClass(class_id, section_id, onDone) {
        if (!class_id) {
            if (typeof onDone === 'function') {
                onDone();
            }
            return;
        }
        $('#section_id').html("");
        var base_url = '<?php echo base_url(); ?>';
        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "GET",
            url: base_url + "sections/getByClass",
            data: { class_id: class_id },
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj) {
                    var sel = (String(section_id) === String(obj.section_id)) ? 'selected' : '';
                    div_data += '<option value="' + obj.section_id + '" ' + sel + '>' + obj.section + '</option>';
                });
                $('#section_id').append(div_data);
                if (typeof onDone === 'function') {
                    onDone();
                }
            }
        });
    }

    $(document).ready(function () {
        $(document).on('change', '#class_id', function () {
            var class_id = $(this).val();
            getSectionByClass(class_id, '', function () {
            });
        });

        var init_class = $('#class_id').val();
        var init_section = '<?php echo isset($section_id) ? htmlspecialchars((string) $section_id, ENT_QUOTES, 'UTF-8') : ''; ?>';
        if (init_class) {
            getSectionByClass(init_class, init_section, function () {
            });
        }
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
        if (!tab) {
            return;
        }
        var tab_text = "<table border='2px'>" + tab.innerHTML + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
        tab_text = tab_text.replace(/<img[^>]*>/gi, "");
        var bd = document.getElementById('breakdownTable');
        if (bd) {
            tab_text += "<br/><table border='2px'>" + bd.innerHTML + "</table>";
        }
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    }
</script>
