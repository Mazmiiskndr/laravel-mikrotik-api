@props(['id', 'label' => false, 'model' => false, 'required' => false, 'options' => [], 'tooltip' => '', 'placeholder'
=> "true"])

@if($label)
<label for="{{ $id }}" class="form-label">{{ $label }} @if($required)<span
        class="text-danger"><b>*</b></span>@endif</label>
@if($tooltip)
<span data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $tooltip }}"><span
        class="badge badge-center rounded-pill bg-warning bg-glow" style="width: 15px;height:15px;"><i
            class="ti ti-question-mark" style="font-size: 0.800rem;"></i></span></span>
@endif
@endif

<select {{ $attributes->merge(['class' => 'form-select ' . ($model && $errors->has($model) ? 'is-invalid' : ''), 'id' =>
    $id, 'name' => $id]) }} {{ $model ? 'wire:model=' . $model : '' }}>
    @if($placeholder == "true")
    <option value="" style="color: #a5a5a5">-- Choice {{ $label }} -- </option>
    @endif
    @foreach ($options as $value => $display)
    <option value="{{ $value }}">{{ $display }}</option>
    @endforeach
</select>

@error($model) <small class="error text-danger">{{ $message }}</small> @enderror
