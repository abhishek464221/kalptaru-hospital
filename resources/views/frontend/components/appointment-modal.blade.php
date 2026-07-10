<!-- ========================================== -->
<!-- APPOINTMENT MODAL - FIXED CENTERED DESIGN  -->
<!-- ========================================== -->
<style>
    /* === MODAL OVERLAY FIX === */
    .modal {
        background: rgba(0, 0, 0, 0.6) !important;
        z-index: 9999 !important;
    }
    
    .modal-backdrop {
        z-index: 9998 !important;
    }
    
    /* === MODAL DIALOG CENTER FIX === */
    .modal-dialog {
        margin: 30px auto !important;
        max-width: 700px !important;
        width: 95% !important;
        position: relative !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        justify-content: center !important;
    }
    
    /* === MODAL CONTENT === */
    .modal-content {
    border-radius: 16px !important;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4) !important;
    border: none !important;
    max-height: 95vh !important;
    overflow: hidden !important;
    width: 100% !important; /* Ensure full width of dialog */
}
    
    /* === MODAL HEADER === */
    .modal-header {
        background: linear-gradient(135deg, #1a8cff, #0056b3) !important;
        color: #fff !important;
        border-radius: 16px 16px 0 0 !important;
        padding: 22px 30px !important;
        border-bottom: none !important;
        flex-shrink: 0 !important;
    }
    
    .modal-header .close {
        color: #fff !important;
        opacity: 0.8 !important;
        font-size: 32px !important;
        margin-top: -8px !important;
        padding: 0 !important;
    }
    
    .modal-header .close:hover {
        opacity: 1 !important;
    }
    
    .modal-header-icon {
        width: 48px;
        height: 48px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .modal-header-icon i {
        font-size: 22px;
        color: #fff;
    }
    
    .modal-header-title h4 {
        font-weight: 600;
        font-size: 20px;
        margin: 0;
        color: #fff;
    }
    
    .modal-header-title p {
        margin: 0;
        font-size: 13px;
        opacity: 0.85;
        color: #fff;
    }
    
    /* === MODAL BODY - SCROLLABLE === */
    .modal-body {
    padding: 25px 30px !important;
    overflow-y: auto !important;
    max-height: calc(95vh - 160px) !important;
    background: #fff !important;
    width: 100% !important; /* Prevent expansion */
    box-sizing: border-box !important;
}
    
    /* === FORM STYLES === */
    #appointmentForm .form-group {
        margin-bottom: 16px !important;
    }
    
    #appointmentForm label {
        font-weight: 500 !important;
        color: #333 !important;
        font-size: 13px !important;
        margin-bottom: 5px !important;
        display: block !important;
    }
    
    #appointmentForm label i {
        color: #1a8cff !important;
        margin-right: 6px !important;
        width: 16px !important;
    }
    
    #appointmentForm .form-control {
        border-radius: 8px !important;
        padding: 11px 14px !important;
        border: 2px solid #e8ecf1 !important;
        transition: all 0.3s ease !important;
        font-size: 14px !important;
        width: 100% !important;
        background: #fafbfc !important;
        height: auto !important;
    }
    
    #appointmentForm .form-control:focus {
        border-color: #1a8cff !important;
        box-shadow: 0 0 0 4px rgba(26, 140, 255, 0.12) !important;
        background: #fff !important;
    }
    
    #appointmentForm textarea.form-control {
        resize: vertical !important;
        min-height: 80px !important;
    }
    
    #appointmentForm select.form-control {
        appearance: auto !important;
        -webkit-appearance: auto !important;
    }
    
    /* === SUBMIT BUTTON === */
    #appointmentForm .btn-submit {
        background: linear-gradient(135deg, #1a8cff, #0056b3) !important;
        border: none !important;
        padding: 14px 20px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        width: 100% !important;
        color: #fff !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 20px rgba(26, 140, 255, 0.35) !important;
    }
    
    #appointmentForm .btn-submit:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 30px rgba(26, 140, 255, 0.5) !important;
    }
    
    #appointmentForm .btn-submit:disabled {
        opacity: 0.7 !important;
        transform: none !important;
        cursor: not-allowed !important;
    }
    
    /* === ALERT === */
    #appointmentAlert {
    border-radius: 8px !important;
    padding: 12px 16px !important;
    margin-bottom: 18px !important;
    display: none;
    width: 100% !important;
    box-sizing: border-box !important;
    word-wrap: break-word !important;
}
    
    #appointmentAlert ul {
        margin: 5px 0 0 0 !important;
        padding-left: 20px !important;
    }
    
    #appointmentAlert li {
        list-style: disc !important;
    }
    
    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px auto !important;
            width: 96% !important;
            top: 0 !important;
            transform: translateY(0) !important;
        }
        
        .modal-content {
            border-radius: 12px !important;
            max-height: 98vh !important;
        }
        
        .modal-header {
            padding: 16px 18px !important;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .modal-header-title h4 {
            font-size: 17px !important;
        }
        
        .modal-header-title p {
            font-size: 12px !important;
        }
        
        .modal-header-icon {
            width: 40px !important;
            height: 40px !important;
        }
        
        .modal-header-icon i {
            font-size: 18px !important;
        }
        
        .modal-body {
            padding: 18px 18px !important;
            max-height: calc(98vh - 130px) !important;
        }
        
        #appointmentForm .form-group {
            margin-bottom: 12px !important;
        }
        
        #appointmentForm .form-control {
            padding: 10px 12px !important;
            font-size: 13px !important;
        }
        
        #appointmentForm .btn-submit {
            padding: 12px !important;
            font-size: 15px !important;
        }
    }
    
    @media (max-width: 480px) {
        .modal-header {
            padding: 12px 14px !important;
        }
        
        .modal-header-title h4 {
            font-size: 15px !important;
        }
        
        .modal-header-icon {
            width: 34px !important;
            height: 34px !important;
        }
        
        .modal-header-icon i {
            font-size: 15px !important;
        }
        
        .modal-body {
            padding: 14px 14px !important;
        }
        
        #appointmentForm .form-control {
            padding: 8px 10px !important;
            font-size: 12px !important;
            border-radius: 6px !important;
        }
        
        #appointmentForm label {
            font-size: 12px !important;
        }
        
        #appointmentForm .btn-submit {
            padding: 10px !important;
            font-size: 13px !important;
        }
    }
</style>

<!-- ===== MODAL HTML ===== -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="modal-header-icon">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                    <div class="modal-header-title">
                        <h4>Book an Appointment</h4>
                        <p>Fill in the details below and we'll get back to you</p>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="modal-body">
                <!-- Alert -->
                <div id="appointmentAlert" class="alert"></div>

                <form id="appointmentForm" action="{{ route('frontend.appointment.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_name"><i class="fa fa-user"></i> Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modal_name" name="name" 
                                    placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="modal_phone"><i class="fa fa-phone"></i> Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="modal_phone" name="phone" 
                                    placeholder="Enter your phone number" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="modal_email"><i class="fa fa-envelope"></i> Email Address</label>
                                <input type="email" class="form-control" id="modal_email" name="email" 
                                    placeholder="Enter your email address">
                            </div>
                            
                            <div class="form-group">
                                <label for="modal_department"><i class="fa fa-hospital-o"></i> Department (Optional)</label>
                                <select class="form-control" id="modal_department" name="department">
                                    <option value="">Select Department</option>
                                    @php
                                        $departments = App\Models\Department::limit(10)->get();
                                    @endphp
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_date"><i class="fa fa-calendar"></i> Preferred Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="modal_date" name="appointment_date" 
                                    min="{{ date('Y-m-d') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="modal_time"><i class="fa fa-clock-o"></i> Preferred Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="modal_time" name="appointment_time" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="modal_note"><i class="fa fa-comment"></i> Additional Notes / Reason</label>
                                <textarea class="form-control" id="modal_note" name="note" rows="4" 
                                    placeholder="Briefly describe your health concern or reason for visit"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn-submit">
                                <i class="fa fa-check-circle"></i> Book Appointment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ===== JAVASCRIPT ===== -->
@push('scripts')
<script>
    $(document).ready(function() {
        // Reset form when modal is closed
        $('#appointmentModal').on('hidden.bs.modal', function() {
            $('#appointmentForm')[0].reset();
            $('#appointmentAlert').hide().removeClass('alert-success alert-danger');
        });

        // Handle form submission via AJAX
        $('#appointmentForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var formData = form.serialize();
            var alertDiv = $('#appointmentAlert');
            var submitBtn = form.find('.btn-submit');

            // Disable button
            submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

            // Hide previous alert
            alertDiv.hide().removeClass('alert-success alert-danger');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alertDiv
                            .removeClass('alert-danger')
                            .addClass('alert-success')
                            .html('<i class="fa fa-check-circle"></i> ' + response.message)
                            .show();

                        form[0].reset();

                        // Close modal after 2.5 seconds
                        setTimeout(function() {
                            $('#appointmentModal').modal('hide');
                            alertDiv.hide();
                        }, 2500);
                    } else {
                        alertDiv
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .html('<i class="fa fa-exclamation-circle"></i> ' + (response.message || 'Something went wrong.'))
                            .show();
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Something went wrong. Please try again.';
                    
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorList = '<ul style="margin:0; padding-left:20px;">';
                        $.each(errors, function(key, value) {
                            errorList += '<li>' + value[0] + '</li>';
                        });
                        errorList += '</ul>';
                        errorMsg = errorList;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    alertDiv
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html('<i class="fa fa-exclamation-circle"></i> ' + errorMsg)
                        .show();
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Book Appointment');
                }
            });
        });

        // Focus first input when modal opens
        $('#appointmentModal').on('shown.bs.modal', function() {
            setTimeout(function() {
                $('#modal_name').focus();
            }, 300);
        });
    });
</script>
@endpush