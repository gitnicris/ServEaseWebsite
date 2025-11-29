<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\User;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Remove only old sample services to avoid duplicates
        Service::where('is_sample', true)->delete();

        // Get all provider IDs
        $providerIds = User::where('role', 'provider')->pluck('id')->toArray();

        // Sample services
                $services = [
            [
                'title' => 'Home Cleaning Service',
                'description' => 'Professional home cleaning covering sweeping, mopping, dusting, bathroom sanitizing, and kitchen cleaning.',
                'price' => 499,
                'category' => 'Home Services',
                'image' => 'https://images.unsplash.com/photo-1590080871408-82f998178118?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Aircon Cleaning & Maintenance',
                'description' => 'Complete aircon cleaning service for window or split-type units. Removes dust, odors, and improves cooling efficiency.',
                'price' => 750,
                'category' => 'Repair & Maintenance',
                'image' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Basic Haircut & Grooming',
                'description' => 'Professional haircut service for men, women, and kids. Includes consultation for hairstyle recommendations.',
                'price' => 200,
                'category' => 'Beauty & Wellness',
                'image' => 'https://images.unsplash.com/photo-1592295521074-9a242eaa9f13?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Mobile Car Wash & Detailing',
                'description' => 'Exterior wash, vacuum, tire black, dashboard wipe, and optional interior deep cleaning.',
                'price' => 899,
                'category' => 'Automotive',
                'image' => 'https://images.unsplash.com/photo-1598059781971-8d6eec1f03b0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Plumbing Fix – Leak Repair',
                'description' => 'Leak repair, unclogging, and minor toilet repairs. Fast and reliable plumbing service.',
                'price' => 350,
                'category' => 'Home Repair',
                'image' => 'https://images.unsplash.com/photo-1581091870622-2d9df9ff6600?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Tutoring – Math & English',
                'description' => 'One-on-one tutoring for students. Homework help, exam prep, and concept mastery.',
                'price' => 300,
                'category' => 'Education',
                'image' => 'https://images.unsplash.com/photo-1581091870623-6e9f6b4a38a7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Computer Repair & Troubleshooting',
                'description' => 'Laptop/PC diagnostics, virus removal, OS repair, part replacement, and optimization.',
                'price' => 600,
                'category' => 'IT & Tech Services',
                'image' => 'https://images.unsplash.com/photo-1581090700227-6aab86ff4a7d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Pet Grooming (Small–Medium Dogs)',
                'description' => 'Bath, nail trim, ear cleaning, brushing, and haircut. Gentle and safe grooming service.',
                'price' => 500,
                'category' => 'Pet Services',
                'image' => 'https://images.unsplash.com/photo-1601758173927-3f6f5f05f517?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Photography Session (1 Hour)',
                'description' => 'Portrait, couples, product, or events. Includes edited photos and optional setup.',
                'price' => 1500,
                'category' => 'Creative Services',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
            [
                'title' => 'Motorcycle Repair & Tune-Up',
                'description' => 'Complete tune-up, oil change, brake check, and minor motorcycle repairs.',
                'price' => 350,
                'category' => 'Automotive',
                'image' => 'https://images.unsplash.com/photo-1589571894960-20bbe2828c3d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080&q=80',
                'status' => 'approved',
            ],
        ];

        foreach ($services as $service) {
            $service['user_id'] = $providerIds[array_rand($providerIds)];
            $service['is_sample'] = true; // mark as sample
            Service::create($service);
        }
    }
}
