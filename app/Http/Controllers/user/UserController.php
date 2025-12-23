<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMailer;
use App\Models\PasswordResetToken;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // <-- Import here


class UserController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:user,email',
                'password' => 'required|string|min:8',
                'role_id' => 'required|integer|exists:role,id'
            ]);

            // Create user with validated data
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id']
            ]);

            return response()->json($user, 201);
        } catch (Exception $e) {
            response(['message' => $e->getMessage()]);
        }
    }
    public function getUser($id)
    {
        try {
            $user = User::with('role')->findOrFail($id);
            return response([$user]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }
    public function getUsers()
    {
        try {
            $users = User::with('role')->get();
            return response([$users]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response([$user]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }

    }
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $request->validate([
                'email' => 'sometimes|email|unique:user,email,' . $id,
                'name' => 'sometimes|string|max:255',
                'password' => 'sometimes|string|min:8',
                'role_id' => 'sometimes|exists:role,id'
            ]);

            $updateData = $request->only(['name', 'email', 'role_id']);

            // Hash password if provided
            if ($request->has('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            $user->update($updateData);
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user->makeHidden(['password'])
            ]);

        } catch (Exception $e) {
            return response(["message" => $e->getMessage()]);
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $credintials = $request->only('email', 'password');
            auth('api')->factory()->setTTL(60 * 24 * 7);
            $token = auth('api')->attempt($credintials);
            $currentTTL = auth('api')->factory()->getTTL();
            if (!$token) {
                return response(["message" => "unauthorised access"], 401);
            }
            return response(["access token" => $token, "expiresIn" => $currentTTL * 60 . ' s']); // instead of Auth::guard('api')->factory()->getTTL();
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }
    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }
    public function forget(Request $request)
    {
        //send mail to the passed mail to you with token
        $token = Str::random(5);
        $email = $request->input('email');
        try {
            $createdAt = now();
            $expiresAt = $createdAt->copy()->addMinutes(30);
            // Delete any existing tokens for this email
            PasswordResetToken::where('email', $email)->delete();
            // Create new token with expiration
            PasswordResetToken::create([
                'email' => $email,
                'token' => $token,
                'created_at' => $createdAt,
                'expires_at' => $expiresAt
            ]);
            Mail::to($email)->send(mailable: new ForgetPasswordMailer($token));//

            return response(['message' => 'email sent']);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }
    public function reset(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8'
        ]);
        
        // Find token
        $tokenRecord = PasswordResetToken::where('email', $request->email)
            ->first();
        
        if (!$tokenRecord) {
            return response(['message' => 'Token not found'], 400);
        }
        
        // Check if expired
        if ($tokenRecord->expires_at < now()) {
            $tokenRecord->delete();
            return response(['message' => 'Token expired'], 400);
        }
        
        // Verify token
        if ($request->token!= $tokenRecord->token) {
            return response(['message' => 'Invalid token'], 400);
        }
        
        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Delete token
        $tokenRecord->delete();
        return response(['message' => 'Password reset successfully']);     
    } catch (\Exception $e) {
        return response(['message' => $e->getMessage()], 500);
    }
}
}
