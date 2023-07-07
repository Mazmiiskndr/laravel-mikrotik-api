@extends('layouts/layoutMaster')
@section('title', 'Users Data')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To Users Data --}}
@if($permissions['isAllowedToUsersData'])
<h4 class="fw-bold py-3 mb-1">Users Data</h4>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header" style="margin-bottom: -15px">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Users Data</h4>
            <div>

                {{-- /Start Button for Print --}}
                @if ($permissions['isAllowedToPrintUsersData'])
                <x-link-button color="facebook" icon="fas fa-lg fa-file-pdf" route="backend.clients.users-data.print"
                    target="_blank">
                    &nbsp; Print Users Data
                </x-link-button>
                @endif
                {{-- /End Button for Print --}}

                {{-- /Start Button for Save To Excel --}}
                @if ($permissions['isAllowedToUsersDataCsv'])
                <x-button type="button" color="success" onclick="saveToExcel()">
                    <i class="tf-icons fas fa-file-excel ti-xs me-1"></i>&nbsp; Save to Excel
                </x-button>
                @endif
                {{-- /End Button for Save To Excel --}}

                {{-- /Start Button for Batch Delete --}}
                @if ($permissions['isAllowedToDeleteUsersData'])
                <x-button type="button" color="danger" onclick="confirmDeleteBatch()">
                    <i class="tf-icons fas fa-trash-alt ti-xs me-1"></i>&nbsp; Batch Delete
                </x-button>
                @endif
                {{-- /End Button for Batch Delete --}}
            </div>
        </div>

        {{-- /Start Form Find Users Data --}}
        @if ($permissions['isAllowedToFindUsersData'])
        @livewire('backend.client.users-data.find-users-data')
        @endif
        {{-- /End Form Find Users Data --}}
    </div>

    @if($permissions['isAllowedToUsersData'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.client.users-data.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script>
        var findUsersData = @json($permissions['isAllowedToFindUsersData']);
    </script>
    <script src="{{ asset('assets/js/backend/client/users-data/users-data-management.js') }}"></script>

    @endpush
</div>
@endif

@endsection
