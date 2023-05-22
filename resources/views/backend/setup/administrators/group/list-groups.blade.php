@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')
@section('title', 'List Groups')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-primary fw-light">Groups </span>/ List</h4>

<div class="row">
    <!-- DataTable with Buttons -->
    <div class="col-md-12">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Table Groups</h4>
                    <a href="{{route('backend.setup.admin.add-new-group') }}"
                        class="btn btn-sm btn-facebook text-white">
                        <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Group
                    </a>
                </div>
            </div>

            {{-- Start List DataTable --}}
            <div class="card-body">
                @livewire('backend.setup.administrator.group.data-table')
            </div>
            {{-- End List DataTable --}}

        </div>
    </div>

</div>
@push('scripts')
@endpush

@endsection