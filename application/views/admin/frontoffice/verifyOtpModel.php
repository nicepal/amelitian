<div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>OTP Verification</h4>
                </div>
                <div class="card-body">
                    <form id="otpForm">
                        <div class="form-group">
                            <label for="otp">Enter OTP</label>
                            <input type="text" class="form-control" id="otpInput" name="otp" required>
                            <input type="hidden" name="id" value="<?php echo $visitor_id; ?>">
                        </div>
                        <button type="submit" id="verifyBtn" class="btn btn-primary">Verify</button>
                        <button type="button" class="btn btn-secondary" id="resendBtn">Resend OTP</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Attach a click event handler to the "Verify" button

  

    $('#verifyBtn').click(function() {
        // Prevent the default form submission
        event.preventDefault();

        // Get the form data
        var formData = $('#otpForm').serialize();
        if($("#otpInput").val() == ""){
            toastr.error('Kindly insert valid OTP!');
            return false;
        }
        // Send an AJAX request
        $.ajax({
            type: 'POST', // or 'GET' depending on your server
            url: '<?php echo base_url(); ?>admin/visitors/submitVerifyOtp/<?php echo $visitor_id; ?>', // Replace with your server endpoint
            data: formData,
            success: function(response) {
                // Handle the response from the server
                if (response === 'success') {
                    // Display a success message or perform further actions
                    toastr.success('OTP VErified successfully!');
                    setTimeout(function(){
                        location.reload();
                    },1000)
                } else {
                    // Display an error message or perform other error handling
                    toastr.error('OTP verification failed');
                }
            },
            error: function() {
                // Handle AJAX error, if any
                toastr.error('An error occurred during verification');
            }
        });
    });

    // Attach a click event handler to the "Resend" button
    $('#resendBtn').click(function() {
        // Send an AJAX request for resending OTP
        $.ajax({
            type: 'POST', // or 'GET' depending on your server
            url: '<?php echo base_url(); ?>admin/visitors/resendOTP/<?php echo $visitor_id; ?>/<?php echo $data['guardian_phone'] ?>', // Replace with your server resend endpoint
            success: function(response) {
                // Handle the resend response
                if (response === 'success') {
                    toastr.success('New OTP sent successfully');
                } else {
                    toastr.error(response);
                }
            },
            error: function() {
                alert('An error occurred while resending OTP');
            }
        });
    });

});
</script>
