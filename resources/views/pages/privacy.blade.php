@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="row">
    <!-- TOC Sidebar -->
    <div class="col-md-3 d-none d-md-block">
        <div class="position-sticky" style="top: 80px;">
            <h5 class="mb-3">Table of Contents</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#info">1. Information We Collect</a></li>
                <li class="nav-item"><a class="nav-link" href="#use">2. How We Use Your Information</a></li>
                <li class="nav-item"><a class="nav-link" href="#sharing">3. Data Sharing</a></li>
                <li class="nav-item"><a class="nav-link" href="#security">4. Data Security</a></li>
                <li class="nav-item"><a class="nav-link" href="#cookies">5. Cookies & Tracking</a></li>
                <li class="nav-item"><a class="nav-link" href="#rights">6. Your Rights</a></li>
                <li class="nav-item"><a class="nav-link" href="#messaging">7. Messaging and Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="#third-party">8. Third-Party Logins</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
        <h2 class="mb-4">Privacy Policy</h2>

        <h4 id="info" class="mt-5">1. Information We Collect</h4>
        <ul>
            <li>Name, email, phone number, and profile photo</li>
            <li>Service listings and booking information</li>
            <li>Messages between users</li>
            <li>Reviews submitted by customers</li>
            <li>Data from third-party logins (e.g., Google)</li>
        </ul>

        <h4 id="use" class="mt-5">2. How We Use Your Information</h4>
        <ul>
            <li>Provide and improve our services</li>
            <li>Facilitate bookings, messaging, and reviews</li>
            <li>Authenticate users and manage accounts</li>
            <li>Communicate with you regarding updates or issues</li>
        </ul>

        <h4 id="sharing" class="mt-5">3. Data Sharing</h4>
        <p>We do not sell your personal information. Data may be shared with service providers, partners, or authorities as necessary to provide services or comply with the law.</p>

        <h4 id="security" class="mt-5">4. Data Security</h4>
        <p>We implement reasonable measures to protect your data, including encrypted storage and access control. However, no system is entirely secure.</p>

        <h4 id="cookies" class="mt-5">5. Cookies & Tracking</h4>
        <p>We may use cookies and analytics to improve your experience, track usage, and customize content.</p>

        <h4 id="rights" class="mt-5">6. Your Rights</h4>
        <p>You may access, correct, or request deletion of your personal data by contacting our support. You may also withdraw consent for certain processing activities.</p>

        <h4 id="messaging" class="mt-5">7. Messaging and Reviews</h4>
        <p>Messages and reviews are stored for operational purposes and may be visible to other users as intended. We respect privacy while ensuring platform integrity.</p>

        <h4 id="third-party" class="mt-5">8. Third-Party Logins</h4>
        <p>Logging in with Google or other third-party services allows us to access your basic profile information. You may revoke this access at any time via your third-party account settings.</p>

        <p class="mt-5">By using ServEase, you consent to this Privacy Policy. See also our <a href="{{ route('terms') }}" class="text-primary">Terms of Service</a>.</p>
    </div>
</div>
@endsection
