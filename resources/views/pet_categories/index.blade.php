@extends('layouts.app')
@section('title')
    {{ __('messages.pet_category.pet_categories') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            {{ Form::hidden('petCategoryCreateUrl', route('pet.category.store'), ['id' => 'petCategoryCreateUrl']) }}
            {{ Form::hidden('operationCategoryUrl', url('pet-categories'), ['id' => 'petCategoryUrl']) }}
            {{ Form::hidden('petCategory', __('messages.pet_category.pet_category'), ['id' => 'petCategory']) }}
            <livewire:pet-category-table/>
            @include('pet_categories.modal')
            @include('pet_categories.edit_modal')
        </div>
    </div>
@endsection

