@extends('layouts.app')

@section('title', 'Contact Us | ServEase')

@section('content')
<div class="container py-4">
    <h2 class="h5 fw-bold mb-3">Contact Us</h2>

    <p class="text-muted mb-3">
        Have questions, feedback, or need support? We're here to help!  
        You can reach out using the form below or through our contact details.
    </p>

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- CONTACT DETAILS --}}
        <div class="col-md-5">
            <div class="p-3 border rounded bg-white shadow-sm">
                <h4 class="h6 fw-bold mb-2">Reach Us</h4>

                <p class="small text-muted mb-2">
                    <i class="bi bi-envelope me-2"></i> support@servease.com
                </p>
                <p class="small text-muted mb-2">
                    <i class="bi bi-telephone me-2"></i> +63 912 345 6789
                </p>
                <p class="small text-muted">
                    <i class="bi bi-geo-alt me-2"></i> Metro Manila, Philippines
                </p>

                <hr>

                <h4 class="h6 fw-bold mb-2">Available Hours</h4>
                <p class="small text-muted mb-1">Monday – Friday: 9:00 AM – 6:00 PM</p>
                <p class="small text-muted">Saturday: 10:00 AM – 4:00 PM</p>
            </div>
        </div>

        {{-- CONTACT FORM --}}
        <div class="col-md-7">
            <div class="p-3 border rounded bg-white shadow-sm">
                <h4 class="h6 fw-bold mb-3">Send Us a Message</h4>

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Name</label>
                        <input type="text" name="name"
                               class="form-control form-control-sm"
                               placeholder="Enter your name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email Address</label>
                        <input type="email" name="email"
                               class="form-control form-control-sm"
                               placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Message</label>
                        <textarea name="message"
                                  class="form-control form-control-sm"
                                  rows="4" placeholder="How can we help you?" required></textarea>
                    </div>

                    <button class="btn btn-primary btn-sm rounded-pill px-4">
                        <i class="bi bi-send me-1"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
