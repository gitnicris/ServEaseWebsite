@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="row">
    <!-- TOC Sidebar -->
    <div class="col-md-3 d-none d-md-block">
        <div class="position-sticky" style="top: 80px;">
            <h5 class="mb-3">Table of Contents</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#acceptance">1. Acceptance of Terms</a></li>
                <li class="nav-item"><a class="nav-link" href="#accounts">2. User Accounts</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">3. Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#messaging">4. Messaging</a></li>
                <li class="nav-item"><a class="nav-link" href="#reviews">5. Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="#payments">6. Payments & Fees</a></li>
                <li class="nav-item"><a class="nav-link" href="#google">7. Google Login & Third-Party Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#termination">8. Termination</a></li>
                <li class="nav-item"><a class="nav-link" href="#modifications">9. Modifications</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
        <h2 class="mb-4">Terms of Service</h2>
        <p>Welcome to <strong>ServEase</strong>, a platform connecting customers and service providers. By using our platform, you agree to comply with the following terms and conditions:</p>

        <h4 id="acceptance" class="mt-5">1. Acceptance of Terms</h4>
        <p>By using ServEase, you agree to these Terms of Service and our Privacy Policy. If you do not agree, please do not use our services.</p>

        <h4 id="accounts" class="mt-5">2. User Accounts</h4>
        <p>Users must provide accurate and complete information. You are responsible for keeping your account credentials secure and for all activity under your account.</p>

        <h4 id="services" class="mt-5">3. Services</h4>
        <p>Service providers may list services on our platform, which are subject to admin approval. Customers may browse, book, and review services. ServEase does not guarantee the quality of services provided by users.</p>

        <h4 id="messaging" class="mt-5">4. Messaging</h4>
        <p>Users may communicate via the platform's messaging system for booking inquiries or service-related discussions. You are responsible for the content you send through messages.</p>

        <h4 id="reviews" class="mt-5">5. Reviews</h4>
        <p>Customers may leave reviews for services they have booked. Reviews must be honest and comply with our guidelines. Fake or abusive reviews are prohibited.</p>

        <h4 id="payments" class="mt-5">6. Payments & Fees</h4>
        <p>Payments made through ServEase must comply with our payment policies. Fees may apply depending on the service provider’s pricing. ServEase is not responsible for any disputes between users regarding payment.</p>

        <h4 id="google" class="mt-5">7. Google Login & Third-Party Services</h4>
        <p>Users may log in using Google. By doing so, you consent to sharing the necessary information from your Google account with ServEase.</p>

        <h4 id="termination" class="mt-5">8. Termination</h4>
        <p>We may suspend or terminate accounts that violate our Terms of Service, without prior notice. Accounts may also be terminated at the user's request.</p>

        <h4 id="modifications" class="mt-5">9. Modifications</h4>
        <p>ServEase may update these terms at any time. Changes are effective immediately upon posting. Continued use of the platform constitutes acceptance of any changes.</p>

        <p class="mt-5">For more information on data usage, see our <a href="{{ route('privacy') }}" class="text-primary">Privacy Policy</a>.</p>
    </div>
</div>
@endsection
