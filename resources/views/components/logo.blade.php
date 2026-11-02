@props(['invertido' => false])
{{-- Logo de Mostrador Digital: un local con toldo. --}}
<svg viewBox="0 0 40 40" aria-hidden="true" {{ $attributes }}>
    <path d="M2 4H38V12A4.5 4.5 0 0 1 29 12A4.5 4.5 0 0 1 20 12A4.5 4.5 0 0 1 11 12A4.5 4.5 0 0 1 2 12Z" fill="#E8572A"/>
    <path d="M6 19H34V36H6Z" fill="{{ $invertido ? '#FFFFFF' : '#0F2C3A' }}"/>
    <path d="M12 25H20V36H12Z" fill="{{ $invertido ? '#0F2C3A' : '#FFFFFF' }}"/>
    <path d="M24 25H29V30H24Z" fill="{{ $invertido ? '#0F2C3A' : '#FFFFFF' }}"/>
</svg>
