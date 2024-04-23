

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary border0 mb0 margesection">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search"></i>  <?php echo $this->lang->line('attendance') . " " . $this->lang->line('report') ?></h3>

            </div>
            <div class="">

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Details</th>
                            <th>Reason</th>
                            <th>Cancelled By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reports as $key => $val){ ?>
                            <tr>
                                <td><?php echo $val->id; ?></td>
                                <td>
                                    <?php $detail = json_decode($val->details); ?>
                                    <strong>Amount: </strong> <?php echo $detail->amount; ?><br />
                                    <strong>Invoice No: </strong> <?php echo $detail->invoice_no; ?><br />
                                    <strong>Description: </strong> <?php echo $detail->description; ?><br />
                                </td>
                                <td><?php echo $val->reason; ?></td>
                                <td><?php echo $val->added_by; ?></td>
                                <td><?php echo $val->date_added; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
              
            </div>
        </div>
    </div>
</div> 