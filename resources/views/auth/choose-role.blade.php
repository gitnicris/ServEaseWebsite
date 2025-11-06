@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Choose Your Role</h2>
    <form action="{{ route('choose.role.save') }}" method="POST">
        @csrf
        <button type="submit" name="role" value="customer" class="btn btn-success">I am a Customer</button>
        <button type="submit" name="role" value="provider" class="btn btn-primary">I am a Provider</button>
    </form>
</div>
@endsection
