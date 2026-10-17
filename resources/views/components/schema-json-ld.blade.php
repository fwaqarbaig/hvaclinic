@props(['schema' => null, 'data' => null])

@php
    $payload = $data ?? $schema;
@endphp

@if(!empty($payload))
    {!! \App\Services\SchemaGenerator::render($payload) !!}
@endif

