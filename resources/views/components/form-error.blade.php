@props(['name'])
@error($name)
    <p class="field__error" id="{{ $name }}-error">{{ $message }}</p>
@enderror
