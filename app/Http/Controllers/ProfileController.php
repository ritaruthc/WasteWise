<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {

        $user = Auth::user();
    
        $activities = Activity::where('user_id', $user->id)->latest()->get();
        
        // Calculate user contributions
        $contributionsCount = Question::where('user_id', $user->id)->count() + Answer::where('user_id', $user->id)->count();
        
        // Count best answers
        $bestAnswersCount = Answer::where('user_id', $user->id)->where('is_accepted', true)->count();
        
        return view('profile.profile', compact('user', 'activities', 'contributionsCount', 'bestAnswersCount'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $activities = Activity::where('user_id', $user->id)->latest()->get();

        // Hitung kontribusi pengguna
        $contributionsCount = Question::where('user_id', $user->id)->count() + Answer::where('user_id', $user->id)->count();

        // Hitung jawaban terbaik
        $bestAnswersCount = Answer::where('user_id', $user->id)->where('is_accepted', true)->count();

        return view('profile.profile', compact('user', 'activities', 'contributionsCount', 'bestAnswersCount'));
    }

    // Method to display the edit profile page
    public function editProfile()
    {
        Log::info('Masuk ke method edit di ProfileController');

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Jika Anda menggunakan policy
        // if (!auth()->user()->can('edit', $user)) {
        //     abort(403);
        // }
        
        return view('profile.edit', compact('user'));
    }

    // Method to update user profile
    public function update(Request $request)
    {
        Log::info('Update profile request:', $request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'nullable',
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
            'cropped_avatar' => 'nullable|string', // Validate the cropped avatar
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        if (!$user instanceof User) {
            return redirect()->route('profile.index')->with('error', 'Invalid user.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->current_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
            }
            $user->password = Hash::make($request->password);
        }

        // Handle cropped avatar
        if ($request->filled('cropped_avatar')) {
            $image_parts = explode(";base64,", $request->cropped_avatar);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file_name = 'avatar_' . time() . '.' . $image_type;
            $file_path = 'avatars/' . $file_name;
            
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            Storage::disk('public')->put($file_path, $image_base64);
            $user->avatar = $file_path;
        }

        $user->save();
        Log::info('User after update:', $user->toArray());

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function showAvatar($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar) {
            return response()->file(Storage::disk('public')->path($user->avatar));
        } else {
            return redirect('https://via.placeholder.com/150');
        }
    }




    // Method to display the edit email page
    public function editEmail()
    {
        return view('profile.edit-email');
    }

    // Method to update user email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        // Check if $user is a valid Eloquent model instance
        if (!$user instanceof User) {
            return redirect()->route('profile')->with('error', 'Invalid user.');
        }

        $user->email = $request->email;
        $user->save();  // Ensure $user is a valid Eloquent model

        return redirect()->route('profile')->with('success', 'Email updated successfully.');
    }

    // Method to display the edit password page
    public function editPassword()
    {
        return view('profile.edit-password');
    }

    // Method to update user password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $user = Auth::user();

        // Check if $user is a valid Eloquent model instance
        if (!$user instanceof User) {
            return redirect()->route('profile')->with('error', 'Invalid user.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();  // Ensure $user is a valid Eloquent model

        return redirect()->route('profile')->with('success', 'Password updated successfully.');
    }

    private function getRecentActivities(User $user)
    {
        // Logic to get user's recent activities
        return [
            'Answered a question',
            'Posted a new question',
            'Commented on a discussion'
        ];
    }
}
