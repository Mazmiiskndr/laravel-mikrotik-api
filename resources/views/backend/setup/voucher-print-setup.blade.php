@extends('layouts/layoutMaster')

@section('title', 'Vouchers Print Setup')

@section('content')
@if($permissions['isAllowedToVouchersPrintSetup'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light"></span>Vouchers Print Setup</h4>

<div class="row">

    {{-- START HOTEL LOGO ALERT --}}
    <div class="col-lg-12 ">
        @livewire('backend.setup.config.voucher-print-setup.hotel-logo-alert')
    </div>
    {{-- END HOTEL LOGO ALERT --}}


    <div class="col-xl-8 col-md-7 col-sm-12 mb-3">
        {{-- START HOW TO USER CARD --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">How To Use</h4>
                </div>
            </div>

            {{-- Start Form How To Use --}}
            <div class="card-body">
                @livewire('backend.setup.config.voucher-print-setup.form')
            </div>
            {{-- End Form How To Use --}}
        </div>
        {{-- START HOW TO USER CARD --}}

        {{-- START LOGO FORM CARD --}}
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Logo</h4>
                </div>
            </div>

            {{-- Start Logo Form --}}
            <div class="card-body">
                @livewire('backend.setup.config.voucher-print-setup.logo-form')
            </div>
            {{-- End Logo Form --}}
        </div>
        {{-- END LOGO FORM CARD --}}

    </div>

    {{-- View Voucher --}}
    <div class="col-xl-4 col-md-5 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">View Vouchers</h4>
                </div>
            </div>

            {{-- Start View Vouchers --}}
            <div class="card-body">
                @livewire('backend.setup.config.voucher-print-setup.view')
            </div>
            {{-- End View Vouchers --}}

        </div>
    </div>



</div>
@endif
@endsection
