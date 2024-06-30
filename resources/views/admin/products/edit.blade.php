@extends('admin.layouts.admin')

@section('content')
    @livewire('product-edit', [
        'id' => $id,
    ])
@endsection
