@props(['color' => 'primary', 'route' => '#', 'icon' => null, 'identity' => '', 'target' => null])

@php
if($route == "#" || $route == null || $route == "javascript:void(0);")
{
$route = 'javascript:void(0);';
}else{
if($identity != ''){
$route = route($route, $identity);
}else{
$route = route($route);
}
}
@endphp
<a href="{{ $route }}" {{ $attributes->merge(['class' => 'btn btn-' . $color]) }} @if($target) target="{{ $target }}" @endif>
    @if($icon)
    <i class="{{ $icon }} me-1"></i>
    @endif
    {{ $slot }}
</a>
