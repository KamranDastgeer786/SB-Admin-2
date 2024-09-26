{{-- @push('styles')
   <!-- Font-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/montserrat-font.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}"/>
@endpush



<div class="container-fluid">

    <div class="wizard-v7-content">
        <div class="wizard-form">
            <form class="form-register" id="driverForm" action="{{ isset($driver) ? route('drivers.update', ['driver' => $driver->id]) : route('drivers.store') }}" method="POST">

                @csrf
                @if (isset($driver))
                   @method('PUT')
                @endif
                <div id="form-total">
                    <!-- SECTION 1 -->
                    <h2>
                        <p class="step-icon"><span>1</span></p>
                        <div class="step-text">
                            <span class="step-inner-1">Personal Info </span>
                            <span class="step-inner-2">Personal Details</span>
                        </div>
                    </h2>
                    <section>
                        <div class="inner">
                            <div class="wizard-header">
                                <h3 class="heading">Personal Information</h3>
                            </div>
                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="Full_Name">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $driver->name ?? '' }}" placeholder="Full Name" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="Date_of_Birth">Date of Birth<span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"  value="{{ $driver->date_of_birth ?? '' }}" placeholder="Date of Birth" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="contact_number">Contact Number<span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control"  value="{{ $driver->contact_number ?? '' }}" placeholder="Contact Number" require>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="your_email">Email Address<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $driver->email ?? '' }}" placeholder="Email Address" required>
                                </div>
                            </div>

                            
                        </div>
                    </section>

                    <!-- SECTION 2 -->
                    <h2>
                        <p class="step-icon"><span>2</span></p>
                        <div class="step-text">
                            <span class="step-inner-1">License Info</span>
                            <span class="step-inner-2">License Details</span>
                        </div>
                    </h2>
                    <section>
                        <div class="inner">
                            <div class="wizard-header">
                                <h3 class="heading">License Information</h3>
                            </div>
                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="license_number">License Number<span class="text-danger">*</span></label>
                                    <input type="text" name="license_number" id="license_number" class="form-control" value="{{ $driver->license_number ?? '' }}" placeholder="4224-3228-6160-5079"  required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="license_issuing_state">License Issuing State<span class="text-danger">*</span></label>
                                    <input type="text" name="license_issuing_state" id="license_issuing_state" class="form-control" value="{{ $driver->license_issuing_state ?? '' }}" placeholder="License Issuing State" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="license_expiry_date"> License Expiry Date<span class="text-danger">*</span></label>
                                    <input type="date" name="license_expiry_date" id="license_expiry_date" class="form-control" value="{{ $driver->license_expiry_date ?? '' }}" placeholder="License Expiry Date" required>
                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- SECTION 3 -->
                    <h2>
                        <p class="step-icon"><span>3</span></p>
                        <div class="step-text">
                            <span class="step-inner-1">Vehicle Info</span>
                            <span class="step-inner-2">Vehicle Details</span>
                        </div>
                    </h2>
                    <section>
                        <div class="inner">
                            <div class="wizard-header">
                                <h3 class="heading">Vehicle Information</h3>
                            </div>
                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="vehicle_make_model">Vehicle Make & Model<span class="text-danger">*</span></label>
                                    <input type="text" name="vehicle_make_model" id="vehicle_make_model" class="form-control" value="{{ $driver->vehicle_make_model ?? '' }}" placeholder="Vehicle Make & Model" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="vehicle_registration_number">Vehicle Registration Number<span class="text-danger">*</span></label>
                                    <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control" value="{{ $driver->vehicle_registration_number ?? '' }}" placeholder="Vehicle Registration Number" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="insurance_details"> Insurance Details<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="insurance_details" id="insurance_details" required  style="width: 94%; padding: 10px 10px 100px; border-color: gainsboro;">{{ $driver->insurance_details ?? '' }}</textarea>
                                    
                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- SECTION 4 -->
                    <h2>
                        <p class="step-icon"><span>4</span></p>
                        <div class="step-text">
                            <span class="step-inner-1"> Emergency</span>
                            <span class="step-inner-2">Emergency Details</span>
                        </div>
                    </h2>
                    <section>
                        <div class="inner">
                            <div class="wizard-header">
                                <h3 class="heading"> Emergency Contact</h3>
                            </div>
                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="emergency_contact_name">Emergency Contact Name<span class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" class="form-control" value="{{ $driver->emergency_contact_name ?? '' }}" placeholder="Emergency Contact Name" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="emergency_contact_number">Emergency Contact Number<span class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact_number" id="emergency_contact_number" class="form-control" value="{{ $driver->emergency_contact_number ?? '' }}" placeholder="Emergency Contact Number" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <label for="emergency_contact_relationship"> Relationship with Driver<span class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship" class="form-control" value="{{ $driver->emergency_contact_relationship ?? '' }}" placeholder="Relationship with Driver" required>
                                </div>
                            </div>

                        </div>
                    </section>


                    
                    <!-- SECTION 5 -->
                    <h2>
                        <p class="step-icon"><span>5</span></p>
                        <div class="step-text">
                            <span class="step-inner-1">Agreement</span>
                            <span class="step-inner-2">Our Information policy</span>
                        </div>
                    </h2>
                    <section>
                        <div class="inner">
                            <div class="wizard-header">
                                <h3 class="heading">Agreement</h3>
                            </div>
                            <div class="form-row">
                                <div class="form-holder form-holder-2">
                                    <div class="content-inner">
                                        <p>Massa placerat duis ultricies lacus sed turpis tin Elementum sagittis vitae et leo duis ut diam quam nulla. Viverra mauris in aliquam sem fringilla ut. Id leo in vitae turpis massa sed elementum tempus. Aliquet enim tortor at auctor urna nunc id cursus. Nulla aliquet enim tortor at auctor .Consquat nisl vel pretium lectus quam id leo.</p>
                                        <div class="form-checkbox">
                                            <label class="container">
                                                <p>I read agreement and i have not any objection.</p>
                                                  <input type="checkbox" name="agreement" required>
                                                  <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                {{-- <button type="submit" class="btn btn-primary sm">{{ isset($driver) ? 'Update' : 'Save' }}</button> --}}
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#driverForm').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                '{{ route('drivers.index') }}';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessage += `${errors[field].join('\n')}\n`;
                        }
                    }

                    Swal.fire(
                        'Error!',
                        errorMessage + '\n',
                        'error'
                    );
                }

            });
        });
    });

</script>



@push('scripts')
   <script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
   <script src="{{ asset('js/jquery.steps.js')}}"></script>
   <script src="{{ asset('js/main.js')}}"></script>
@endpush --}}