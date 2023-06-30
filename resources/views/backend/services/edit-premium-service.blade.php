@extends('layouts/layoutMaster')
@section('title', 'Edit Premium Service')

@section('content')

{{-- Is Allowed User To Edit Premium Service --}}
@if($permissions['isAllowedToEditPremiumService'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light">Services </span>/ Edit Premium Service</h4>

<div class="row">
    <!-- DataTable with Buttons -->
    <div class="col-md-12">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Edit Premium Service</h4>
                    <x-button type="button" color="youtube btn-sm text-white" onclick="javascript:window.history.back(-1);return false;">
                        <i class="tf-icons fas fa-backward ti-xs me-1"></i>&nbsp; Back
                    </x-button>
                </div>
            </div>

            {{-- Start Form Edit Premium Service --}}
            @livewire('backend.service.premium.edit', ['serviceId' => $serviceId])
            {{-- End Form Edit Premium Service --}}

        </div>
    </div>
</div>

@endif

@endsection
