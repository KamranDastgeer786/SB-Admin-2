@extends('layouts.app')
@section('page-title', 'Driver Information')

@if (isset($driver))
    @section('sub-page-title', 'Update Driver')
@else
  @section('sub-page-title', 'Add New Driver')
@endif

@section('content')

{{-- @dd($driver) --}}

@push('styles')
   <!-- Font-->
   <link rel="stylesheet" href="{{ asset('css/style1.css')}}">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
 
    <div class="container">
        <div class="card w-40">
        <div class="card-header">
        <div class="progress-bar">
            <div class="step">
                <p>Info</p>
                <div class="bullet">
                    <span>1</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

            <div class="step">
                <p>License</p>
                <div class="bullet">
                    <span>2</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

            <div class="step">
                <p>Vehicle</p>
                <div class="bullet">
                    <span>3</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

            <div class="step">
                <p>Emergency</p>
                <div class="bullet">
                    <span>4</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>

        </div>
       </div>

        <div class="card-body">

        <div class="form-outer">
            <form id="driverForm" action="{{ isset($driver) ? route('drivers.update', ['driver' => $driver->id]) : route('drivers.store') }}" method="POST">

                @csrf
                @if (isset($driver))
                   @method('PUT')
                @endif

                <div class="page slide-page">
                    <div class="title">Personal Information</div>
                    <div class="field">
                        <div class="label">Full Name<span class="text-danger">*</span></div>
                        <input type="text" name="name" id="name" class="form-control"  value="{{ $driver->name ?? '' }}" placeholder="Full Name" required>
                    </div>



                    <div class="field">
                        <div class="label">Date of Birth<span class="text-danger">*</span></div>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $driver->date_of_birth ?? '' }}" placeholder="Date of Birth" required>
                    </div>

                    <div class="field">
                        <div class="label">Contact Number<span class="text-danger">*</span></div>
                        <input type="text" name="contact_number" id="contact_number" class="form-control"  value="{{ $driver->contact_number ?? '' }}" placeholder="Contact Number" required>
                    </div>

                    <div class="field">
                        <div class="label">Email Address<span class="text-danger">*</span></div>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $driver->email ?? '' }}" placeholder="Email Address" required>
                    </div>

                    <div class="field">
                        <button class="firstNext next">Next</button>
                    </div>
                </div>

                <div class="page">
                    <div class="title">License Information</div>
                    <div class="field">
                        <div class="label">License Number<span class="text-danger">*</span></div>
                        <input type="text" name="license_number" id="license_number" class="form-control" value="{{ $driver->license_number ?? '' }}" placeholder="4224-3228-6160-5079"  required>
                    </div>

                    <div class="field">
                        <div class="label">License Issuing State<span class="text-danger">*</span></div>
                        <input type="text" name="license_issuing_state" id="license_issuing_state" class="form-control" value="{{ $driver->license_issuing_state ?? '' }}" placeholder="License Issuing State" required>
                    </div>

                    <div class="field">
                        <div class="label">License Expiry Date<span class="text-danger">*</span></div>
                        <input type="date" name="license_expiry_date" id="license_expiry_date" class="form-control" value="{{ isset($driver->license_expiry_date) ? \Illuminate\Support\Carbon::parse($driver->license_expiry_date)->format('Y-m-d') : '' }}" placeholder="License Expiry Date" required>
                    </div>

                    <div class="field btns">
                        <button class="prev-1 prev">Previous</button>
                        <button class="next-1 next">Next</button>
                    </div>

                </div>

                <div class="page">
                    <div class="title">Vehicle Information</div>
                    <div class="field">
                        <div class="label">Vehicle Make & Model<span class="text-danger">*</span></div>
                        <input type="text" name="vehicle_make_model" id="vehicle_make_model" class="form-control" value="{{ $driver->vehicle_make_model ?? '' }}" placeholder="Vehicle Make & Model" required>
                    </div>

                    <div class="field">
                        <div class="label">Vehicle Registration Number<span class="text-danger">*</span></div>
                        <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control" value="{{ $driver->vehicle_registration_number ?? '' }}" placeholder="Vehicle Registration Number" required>
                    </div>

                    <div class="field">
                        <div class="label">Insurance Details<span class="text-danger">*</span></div>
                        <textarea class="form-control" rows="4" name="insurance_details" id="insurance_details" required  style="margin-left: 2px; width: 88%;" >{{ $driver->insurance_details ?? '' }}</textarea>
                    </div>

                    <div class="field btns">
                        <button class="prev-2 prev">Previous</button>
                        <button class="next-2 next">Next</button>
                    </div>

                </div>

                <div class="page">
                    <div class="title">Emergency Contact</div>
                    <div class="field">
                        <div class="label">Emergency Contact Name<span class="text-danger">*</span></div>
                        <input type="text" name="emergency_contact_name" id="emergency_contact_name" class="form-control" value="{{ $driver->emergency_contact_name ?? '' }}" placeholder="Emergency Contact Name" required>
                    </div>

                    <div class="field">
                        <div class="label">Emergency Contact Number<span class="text-danger">*</span></div>
                        <input type="text" name="emergency_contact_number" id="emergency_contact_number" class="form-control" value="{{ $driver->emergency_contact_number ?? '' }}" placeholder="Emergency Contact Number" required>
                    </div>

                    <div class="field">
                        <div class="label">Relationship with Driver<span class="text-danger">*</span></div>
                        <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship" class="form-control" value="{{ $driver->emergency_contact_relationship ?? '' }}" placeholder="Relationship with Driver" required>
                    </div>

                    <div class="field btns">
                        <button class="prev-3 prev">Previous</button>
                        <button class="submit">{{ isset($driver) ? 'Update' : 'Save' }}</button>
                    </div>

                </div>

                
            </form>
        </div>
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
// console.log("ppppppppp",formData)
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
  <script src="{{ asset('js/script.js')}}"></script>
@endpush



@endsection