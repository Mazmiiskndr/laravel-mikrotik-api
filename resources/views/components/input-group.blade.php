@props(['id', 'label' => false, 'model' => false, 'type' => 'text', 'placeholder' => '', 'appendText' => '', 'required'
=> false,'tooltip' => ''])

@if($label)
<label for="{{ $id }}" class="form-label">{{ $label }} @if($required)<span
        class="text-danger"><b>*</b></span>@endif</label>
@if($tooltip)
<span data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $tooltip }}"><span
        class="badge badge-center rounded-pill bg-warning bg-glow" style="width: 15px;height:15px;"><i class="ti ti-question-mark" style="font-size: 0.800rem;"></i></span></span>
@endif
@endif

<div class="input-group">
    <input {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($model) ? 'is-invalid' : ''), 'id' => $id,
    'type' => $type, 'placeholder' => $placeholder, 'aria-label' => $placeholder, 'aria-describedby' => $id]) }}
    @if($model) wire:model="{{ $model }}" @endif />
    <span class="input-group-text" id="{{ $id }}">{{ $appendText }}</span>
</div>

@error($model) <small class="error text-danger">{{ $message }}</small> @enderror
