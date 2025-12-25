<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this line
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            // Permission Routes
            ['name' => 'permissions.create', 'description' => 'Create new permission'],
            ['name' => 'permissions.list', 'description' => 'View all permissions'],
            ['name' => 'permissions.show', 'description' => 'View permission details'],
            ['name' => 'permissions.update', 'description' => 'Update permission'],
            ['name' => 'permissions.delete', 'description' => 'Delete permission'],
            
            // Role Routes
            ['name' => 'roles.create', 'description' => 'Create new role'],
            ['name' => 'roles.list', 'description' => 'View all roles'],
            ['name' => 'roles.delete', 'description' => 'Delete role'],
            ['name' => 'roles.update', 'description' => 'Update role name and description'],
            ['name' => 'roles.attach-permissions', 'description' => 'Attach permissions to role'],
            ['name' => 'roles.detach-permissions', 'description' => 'Detach permissions from role'],
            ['name' => 'roles.show', 'description' => 'View role details'],
            
            // User Routes
            ['name' => 'users.create', 'description' => 'Create new user'],
            ['name' => 'users.update', 'description' => 'Update user information'],
            ['name' => 'users.show', 'description' => 'View user details'],
            ['name' => 'users.delete', 'description' => 'Delete user'],
            ['name' => 'users.list', 'description' => 'View all users'],
            
            // Article Category Routes
            ['name' => 'article-categories.create', 'description' => 'Create article category'],
            ['name' => 'article-categories.update', 'description' => 'Update article category'],
            ['name' => 'article-categories.delete', 'description' => 'Delete article category'],
            
            // Article Routes
            ['name' => 'articles.create', 'description' => 'Create new article'],
            ['name' => 'articles.delete', 'description' => 'Delete article'],
            ['name' => 'articles.update', 'description' => 'Update article'],
            ['name' => 'articles.attach-author', 'description' => 'Attach author to article'],
            ['name' => 'articles.detach-author', 'description' => 'Detach author from article'],
            
            // Author Routes
            ['name' => 'authors.create', 'description' => 'Create new author'],
            ['name' => 'authors.update', 'description' => 'Update author'],
            ['name' => 'authors.delete', 'description' => 'Delete author'],
            
            // Image Routes
            ['name' => 'images.create', 'description' => 'Upload image'],
            ['name' => 'images.delete', 'description' => 'Delete image'],
            ['name' => 'get-image-by-id', 'description' => 'Get image by ID'],
            
            // Video Routes
            ['name' => 'videos.create', 'description' => 'Upload video'],
            ['name' => 'videos.update', 'description' => 'Update video'],
            ['name' => 'videos.delete', 'description' => 'Delete video'],
            
            // Event Routes
            ['name' => 'events.create', 'description' => 'Create new event'],
            ['name' => 'events.delete', 'description' => 'Delete event'],
            ['name' => 'events.update', 'description' => 'Update event'],
            ['name' => 'events.attach-author', 'description' => 'Attach author to event'],
            ['name' => 'events.detach-author', 'description' => 'Detach author from event'],
            
            // Event Analysis Routes
            ['name' => 'event-analysis.create', 'description' => 'Create event analysis'],
            ['name' => 'event-analysis.update', 'description' => 'Update event analysis'],
            ['name' => 'event-analysis.delete', 'description' => 'Delete event analysis'],
            
            // Expert Routes
            ['name' => 'experts.create', 'description' => 'Create new expert'],
            ['name' => 'experts.update', 'description' => 'Update expert'],
            ['name' => 'experts.delete', 'description' => 'Delete expert'],
            
            // Contact Routes
            ['name' => 'contacts.create', 'description' => 'Create expert contact'],
            ['name' => 'contacts.show', 'description' => 'View contact details'],
            ['name' => 'contacts.update', 'description' => 'Update contact'],
            
            // Contact Form Routes
            ['name' => 'contact-forms.list', 'description' => 'View all contact forms'],
            ['name' => 'contact-forms.show', 'description' => 'View contact form details'],
            ['name' => 'contact-forms.update', 'description' => 'Update contact form'],
            ['name' => 'contact-forms.delete', 'description' => 'Delete contact form'],
            
            // Settings Routes
            ['name' => 'settings.get-or-create', 'description' => 'Get or create settings'],
            ['name' => 'settings.update', 'description' => 'Update settings'],
            
            // Front Settings Routes
            ['name' => 'create_front_mode', 'description' => 'Create front settings mode'],
            ['name' => 'gemini.add', 'description' => 'Add Gemini key model'],
    
            // Static Data Routes
            ['name' => 'static.create', 'description' => 'Create static data'],
            ['name' => 'static.update', 'description' => 'Update static data'],
            
            // Contact Form Additional Routes
            ['name' => 'contact.reply', 'description' => 'Reply to contact form'],
            ['name' => 'notification.index', 'description' => 'View notifications']
        ];
        $timestamp = now();
        $permissions = array_map(function($permission) use ($timestamp) {
            return array_merge($permission, [
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }, $permissions);
        DB::table('permission')->insert($permissions);
        $superAdminRole = Role::create([
            'name' => 'Super Admin',
            'description' => 'Has full access to all system features and permissions'
        ]);

        $allPermissions = Permission::all();
        $permissionIds = $allPermissions->pluck('id')->toArray();
        // Attach all permissions to Super Admin
        $superAdminRole->permissions()->attach($permissionIds);
     //   $superAdminRole->load('permissions');
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $superAdminRole->id,
        ]);
    }
}
