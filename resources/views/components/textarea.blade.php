@props(['id', 'label' => false, 'model' => false, 'placeholder' => '', 'required' => false])

@if($label)
<label for="{{ $id }}" class="form-label">{{ $label }} @if($required)<span
        class="text-danger"><b>*</b></span>@endif</label>
@endif

<textarea {{
    $attributes->merge(['class' => 'form-control ' . ($errors->has($model) ? 'is-invalid' : ''), 'id' => $id, 'placeholder' => $placeholder]) }} @if($model) wire:model="{{ $model }}" @endif></textarea>

@error($model)
<small class="error text-danger">{{ $message }}</small>
@enderror
