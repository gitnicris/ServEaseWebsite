@extends('layouts.app')

@section('title', 'About Us | ServEase')

@section('content')
<h2 class="h5 fw-bold mb-3">About ServEase</h2>

<p class="text-muted mb-4">
    ServEase is a service marketplace designed to connect customers with trusted and skilled service providers.
    Whether you need home repairs, personal care, or professional assistance, our platform makes booking easy,
    safe, and reliable.
</p>

<hr>

<div class="row g-4 mt-2">
    <div class="col-md-6">
        <h4 class="h6 fw-bold mb-2">Our Mission</h4>
        <p class="text-muted">To simplify how people find and book reliable services by providing a seamless, transparent, and secure platform.</p>
    </div>

    <div class="col-md-6">
        <h4 class="h6 fw-bold mb-2">Our Vision</h4>
        <p class="text-muted">To become the most trusted service marketplace where skilled providers grow and customers enjoy convenience.</p>
    </div>

    <div class="col-md-6">
        <h4 class="h6 fw-bold mb-2">Why Choose Us?</h4>
        <ul class="text-muted small ps-3">
            <li>Verified and trusted service providers</li>
            <li>Secure payments and transparent pricing</li>
            <li>Easy booking and real-time updates</li>
            <li>Chat support between customers and providers</li>
        </ul>
    </div>

    <div class="col-md-6">
        <h4 class="h6 fw-bold mb-2">Our Commitment</h4>
        <p class="text-muted">We aim to support both customers and service providers with an efficient system that enhances trust and quality service delivery.</p>
    </div>
</div>
@endsection
