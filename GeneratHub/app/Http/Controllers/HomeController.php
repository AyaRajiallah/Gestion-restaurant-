<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $services = [
            [
                'title' => 'Candidate Space',
                'description' => 'Create a profile, upload CV, explore offers, and track applications.'
            ],
            [
                'title' => 'Company Space',
                'description' => 'Publish offers, manage applications, and discover qualified candidates.'
            ],
            [
                'title' => 'Smart Matching',
                'description' => 'Connect the right candidates with the right opportunities.'
            ],
            [
                'title' => 'Application Tracking',
                'description' => 'Follow every application step from submission to final decision.'
            ],
        ];

        $modules = [
            [
                'title' => 'Job Offers',
                'subtitle' => 'Browse and filter available opportunities.'
            ],
            [
                'title' => 'Candidate Profiles',
                'subtitle' => 'Professional profiles with skills, CV, and motivation letters.'
            ],
            [
                'title' => 'Recruitment Dashboard',
                'subtitle' => 'Manage statistics, offers, and application flow.'
            ],
            [
                'title' => 'Admin Panel',
                'subtitle' => 'Control platform activity, users, and published content.'
            ],
            [
                'title' => 'Interview Management',
                'subtitle' => 'Organize candidate follow-up and recruitment stages.'
            ],
            [
                'title' => 'Analytics',
                'subtitle' => 'Track activity and platform performance.'
            ],
        ];

        return view('home', compact('services', 'modules'));
    }
}
