<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display the SEO settings form
     */
    public function index()
    {
        try {
            $seo = Seo::first();
            return view('dashboard', compact('seo'));
        } catch (Exception $e) {
            Log::error('Error fetching SEO settings: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to load SEO settings. Please try again later.');
        }
    }

    /**
     * Update or create SEO settings
     */
    public function updateSeo(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'instagram_url' => 'nullable|url',
                'x_url' => 'nullable|url',
                'telegram_url' => 'nullable|url',
                'tiktok_url' => 'nullable|url',
            ], [
                'banner_image.max' => 'Banner image must not exceed 2MB.',
                'profile_image.max' => 'Profile image must not exceed 2MB.',
                'banner_image.mimes' => 'Banner image must be a file of type: jpeg, png, jpg, gif, svg.',
                'profile_image.mimes' => 'Profile image must be a file of type: jpeg, png, jpg, gif, svg.',
                'title.required' => 'The title field is required.',
                'description.required' => 'The description field is required.',
                'instagram_url.url' => 'Please enter a valid Instagram URL.',
                'x_url.url' => 'Please enter a valid X (Twitter) URL.',
                'telegram_url.url' => 'Please enter a valid Telegram URL.',
                'tiktok_url.url' => 'Please enter a valid TikTok URL.',
            ]);

            // Find existing SEO record or create new one
            $seo = Seo::first() ?? new Seo();

            // Handle banner image
            if ($request->hasFile('banner_image')) {
                try {
                    // Delete old banner image if exists
                    if ($seo->banner_image) {
                        Storage::disk('public')->delete(str_replace('/storage/', 'public/', $seo->banner_image));
                    }

                    // Store new banner image
                    $bannerPath = $request->file('banner_image')->store('images', 'public');
                    $seo->banner_image = Storage::url($bannerPath);
                } catch (Exception $e) {
                    Log::error('Error handling banner image: ' . $e->getMessage());
                    throw new Exception('Failed to process banner image. Please try again.');
                }
            } elseif ($request->has('old_banner_image') && empty($request->old_banner_image)) {
                try {
                    // If banner image was removed
                    if ($seo->banner_image) {
                        Storage::disk('public')->delete(str_replace('/storage/', 'public/', $seo->banner_image));
                    }
                    $seo->banner_image = null;
                } catch (Exception $e) {
                    Log::error('Error removing banner image: ' . $e->getMessage());
                    throw new Exception('Failed to remove banner image. Please try again.');
                }
            }

            // Handle profile image
            if ($request->hasFile('profile_image')) {
                try {
                    // Delete old profile image if exists
                    if ($seo->profile_image) {
                        Storage::disk('public')->delete(str_replace('/storage/', 'public/', $seo->profile_image));
                    }

                    // Store new profile image
                    $profilePath = $request->file('profile_image')->store('images', 'public');
                    $seo->profile_image = Storage::url($profilePath);
                } catch (Exception $e) {
                    Log::error('Error handling profile image: ' . $e->getMessage());
                    throw new Exception('Failed to process profile image. Please try again.');
                }
            } elseif ($request->has('old_profile_image') && empty($request->old_profile_image)) {
                try {
                    // If profile image was removed
                    if ($seo->profile_image) {
                        Storage::disk('public')->delete(str_replace('/storage/', 'public/', $seo->profile_image));
                    }
                    $seo->profile_image = null;
                } catch (Exception $e) {
                    Log::error('Error removing profile image: ' . $e->getMessage());
                    throw new Exception('Failed to remove profile image. Please try again.');
                }
            }

            // Update other fields
            $seo->title = $validatedData['title'];
            $seo->description = $validatedData['description'];
            $seo->instagram_url = $validatedData['instagram_url'];
            $seo->x_url = $validatedData['x_url'];
            $seo->telegram_url = $validatedData['telegram_url'];
            $seo->tiktok_url = $validatedData['tiktok_url'];

            // Save changes
            $seo->save();

            return redirect()->back()->with('success', 'SEO settings have been updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating SEO settings: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage() ?? 'An error occurred while updating SEO settings.')
                ->withInput();
        }
    }
}
