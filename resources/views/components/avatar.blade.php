@props(['name' => '?', 'size' => 'sm', 'chars' => 2])
{{-- Avatar inisial (tanpa foto). size: sm | md | lg | xl --}}
<span {{ $attributes->class(['avatar', 'avatar--circle', "avatar--{$size}" => $size !== 'md']) }}>{{ strtoupper(mb_substr($name, 0, $chars)) }}</span>
