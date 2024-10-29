<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\View\Components\PropertyCard;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register PropertyCard component
        Blade::component('property-card', PropertyCard::class);

        // Ensure upload directories exist
        $this->ensureUploadDirectories();

        // Your existing view composer for form categories
        View::composer('*', function ($view) {
            $formCategories = [
                'For Sellers' => [
                    'listing-agreement' => 'Listing Agreement',
                    'property-disclosure' => 'Property Disclosure Statement',
                ],
                'For Buyers' => [
                    'purchase-agreement' => 'Purchase Agreement',
                    'buyers-agency' => 'Buyer\'s Agency Agreement',
                ],
                'For Renters' => [
                    'rental-application' => 'Rental Application',
                    'lease-agreement' => 'Lease Agreement',
                ],
                'For Viewers' => [
                    'contact-inquiry' => 'Contact/Inquiry Form',
                    'feedback' => 'Feedback Form',
                ],
                'Additional Forms' => [
                    'pre-approval' => 'Pre-Approval Letter Upload',
                    'digital-signature' => 'Digital Signature Authorization',
                ],
            ];
            $view->with('formCategories', $formCategories);
        });
    }

    /**
     * Ensure all required upload directories exist
     */
    protected function ensureUploadDirectories(): void
    {
        $directories = [
            public_path('uploads/uploads'),
            public_path('images')
        ];

        foreach ($directories as $directory) {
            try {
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
            } catch (\Exception $e) {
                logger()->error('Failed to create directory: ' . $directory . ' - ' . $e->getMessage());
            }
        }

        // Ensure no-image.jpg exists
        $noImagePath = public_path('images/no-image.jpg');
        if (!file_exists($noImagePath)) {
            try {
                // Copy a default no-image if it exists in your resources
                if (file_exists(resource_path('assets/images/no-image.jpg'))) {
                    copy(
                        resource_path('assets/images/no-image.jpg'),
                        $noImagePath
                    );
                }
            } catch (\Exception $e) {
                logger()->error('Failed to create no-image.jpg: ' . $e->getMessage());
            }
        }
    }
}
