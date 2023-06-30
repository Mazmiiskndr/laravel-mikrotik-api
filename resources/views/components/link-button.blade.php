@props(['color' => 'primary', 'route' => '#', 'icon' => null])

@php
    if($route == "#" || $route == null || $route == "javascript:void(0);")
    {
        $route = 'javascript:void(0);';
    }else{
        $route = route($route);
    }
@endphp
<a
href="{{ $route }}" {{ $attributes->merge(['class' => 'btn btn-' . $color]) }}>
    @if($icon)
    <i class="{{ $icon }} me-1"></i>
    @endif
    {{ $slot }}
</a>
