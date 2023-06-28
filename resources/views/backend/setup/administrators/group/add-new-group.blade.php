@extends('layouts/layoutMaster')
@section('title', 'Add New Group')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To Add New Group --}}
@if($permissions['isAllowedToAddNewGroup'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light">Groups </span>/ Add New Group</h4>

<div class="row">
    <!-- DataTable with Buttons -->
    <div class="col-md-12">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Add New Group</h4>
                    <a href="{#" class="btn btn-sm btn-youtube text-white"
                        onclick="javascript:window.history.back(-1);return false;">
                        <i class="tf-icons fas fa-backward ti-xs me-1"></i>&nbsp; Back
                    </a>
                </div>
            </div>

            {{-- Start Form Create Group --}}
            @livewire('backend.setup.administrator.group.create-group')
            {{-- End Form Create Group --}}

        </div>
    </div>
</div>
@endif

@endsection
