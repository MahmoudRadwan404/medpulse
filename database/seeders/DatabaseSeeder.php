<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this line
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $permissions=[
        //     ['name' => 'permissions.create', 'description' => 'Create new permission'],
        //     ['name' => 'permissions.list', 'description' => 'View all permissions'],
        //     ['name' => 'permissions.show', 'description' => 'View permission details'],
        //     ['name' => 'permissions.update', 'description' => 'Update permission'],
        //     ['name' => 'permissions.delete', 'description' => 'Delete permission'],
            
        //     // Role Routes
        //     ['name' => 'roles.create', 'description' => 'Create new role'],
        //     ['name' => 'roles.list', 'description' => 'View all roles'],
        //     ['name' => 'roles.delete', 'description' => 'Delete role'],
        //     ['name' => 'roles.update', 'description' => 'Update role name and description'],
        //     ['name' => 'roles.attach-permissions', 'description' => 'Attach permissions to role'],
        //     ['name' => 'roles.detach-permissions', 'description' => 'Detach permissions from role'],
        //     ['name' => 'roles.show', 'description' => 'View role details'],
            
        //     // User Routes
        //     ['name' => 'users.create', 'description' => 'Create new user'],
        //     ['name' => 'users.login', 'description' => 'User login access'],
        //     ['name' => 'users.update', 'description' => 'Update user information'],
        //     ['name' => 'users.show', 'description' => 'View user details'],
        //     ['name' => 'users.delete', 'description' => 'Delete user'],
        //     ['name' => 'users.list', 'description' => 'View all users'],
        //     ['name' => 'users.forget-password', 'description' => 'Request password reset'],
        //     ['name' => 'users.reset-password', 'description' => 'Reset user password'],
            
        //     // Article Category Routes
        //     ['name' => 'article-categories.create', 'description' => 'Create article category'],
        //     ['name' => 'article-categories.show', 'description' => 'View article category'],
        //     ['name' => 'article-categories.update', 'description' => 'Update article category'],
        //     ['name' => 'article-categories.delete', 'description' => 'Delete article category'],
        //     ['name' => 'article-categories.list', 'description' => 'View all article categories'],
            
        //     // Article Routes
        //     ['name' => 'articles.create', 'description' => 'Create new article'],
        //     ['name' => 'articles.list', 'description' => 'View all articles'],
        //     ['name' => 'articles.show', 'description' => 'View article details'],
        //     ['name' => 'articles.delete', 'description' => 'Delete article'],
        //     ['name' => 'articles.update', 'description' => 'Update article'],
        //     ['name' => 'articles.attach-author', 'description' => 'Attach author to article'],
        //     ['name' => 'articles.detach-author', 'description' => 'Detach author from article'],
            
        //     // Author Routes
        //     ['name' => 'authors.create', 'description' => 'Create new author'],
        //     ['name' => 'authors.list', 'description' => 'View all authors'],
        //     ['name' => 'authors.show', 'description' => 'View author details'],
        //     ['name' => 'authors.update', 'description' => 'Update author'],
        //     ['name' => 'authors.delete', 'description' => 'Delete author'],
            
        //     // Image Routes
        //     ['name' => 'images.create', 'description' => 'Upload image'],
        //     ['name' => 'images.delete', 'description' => 'Delete image'],
            
        //     // Video Routes
        //     ['name' => 'videos.create', 'description' => 'Upload video'],
        //     ['name' => 'videos.update', 'description' => 'Update video'],
        //     ['name' => 'videos.delete', 'description' => 'Delete video'],
        //     ['name' => 'videos.show', 'description' => 'View video details'],
            
        //     // Event Routes
        //     ['name' => 'events.create', 'description' => 'Create new event'],
        //     ['name' => 'events.list', 'description' => 'View all events'],
        //     ['name' => 'events.show', 'description' => 'View event details'],
        //     ['name' => 'events.delete', 'description' => 'Delete event'],
        //     ['name' => 'events.update', 'description' => 'Update event'],
        //     ['name' => 'events.attach-author', 'description' => 'Attach author to event'],
        //     ['name' => 'events.detach-author', 'description' => 'Detach author from event'],
            
        //     // Event Analysis Routes
        //     ['name' => 'event-analysis.create', 'description' => 'Create event analysis'],
        //     ['name' => 'event-analysis.update', 'description' => 'Update event analysis'],
        //     ['name' => 'event-analysis.delete', 'description' => 'Delete event analysis'],
            
        //     // Expert Routes
        //     ['name' => 'experts.show', 'description' => 'View expert details'],
        //     ['name' => 'experts.list', 'description' => 'View all experts'],
        //     ['name' => 'experts.create', 'description' => 'Create new expert'],
        //     ['name' => 'experts.update', 'description' => 'Update expert'],
        //     ['name' => 'experts.delete', 'description' => 'Delete expert'],
            
        //     // Contact Routes
        //     ['name' => 'contacts.create', 'description' => 'Create expert contact'],
        //     ['name' => 'contacts.show', 'description' => 'View contact details'],
        //     ['name' => 'contacts.update', 'description' => 'Update contact'],
            
        //     // Contact Form Routes
        //     ['name' => 'contact-forms.create', 'description' => 'Submit contact form'],
        //     ['name' => 'contact-forms.list', 'description' => 'View all contact forms'],
        //     ['name' => 'contact-forms.show', 'description' => 'View contact form details'],
        //     ['name' => 'contact-forms.update', 'description' => 'Update contact form'],
        //     ['name' => 'contact-forms.delete', 'description' => 'Delete contact form'],
            
        //     // Settings Routes
        //     ['name' => 'settings.get-or-create', 'description' => 'Get or create settings'],
        //     ['name' => 'settings.update', 'description' => 'Update settings'],
        //     ['name' => 'settings.events-articles', 'description' => 'Get events and articles for homepage'],
        // ];
        // DB::table('permission')->insert($permissions);
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
            ['name' => 'users.login', 'description' => 'User login access'],
            ['name' => 'users.update', 'description' => 'Update user information'],
            ['name' => 'users.show', 'description' => 'View user details'],
            ['name' => 'users.delete', 'description' => 'Delete user'],
            ['name' => 'users.list', 'description' => 'View all users'],
            ['name' => 'users.forget-password', 'description' => 'Request password reset'],
            ['name' => 'users.reset-password', 'description' => 'Reset user password'],
            
            // Article Category Routes
            ['name' => 'article-categories.create', 'description' => 'Create article category'],
            ['name' => 'article-categories.show', 'description' => 'View article category'],
            ['name' => 'article-categories.update', 'description' => 'Update article category'],
            ['name' => 'article-categories.delete', 'description' => 'Delete article category'],
            ['name' => 'article-categories.list', 'description' => 'View all article categories'],
            
            // Article Routes
            ['name' => 'articles.create', 'description' => 'Create new article'],
            ['name' => 'articles.list', 'description' => 'View all articles'],
            ['name' => 'articles.show', 'description' => 'View article details'],
            ['name' => 'articles.delete', 'description' => 'Delete article'],
            ['name' => 'articles.update', 'description' => 'Update article'],
            ['name' => 'articles.attach-author', 'description' => 'Attach author to article'],
            ['name' => 'articles.detach-author', 'description' => 'Detach author from article'],
            
            // Author Routes
            ['name' => 'authors.create', 'description' => 'Create new author'],
            ['name' => 'authors.list', 'description' => 'View all authors'],
            ['name' => 'authors.show', 'description' => 'View author details'],
            ['name' => 'authors.update', 'description' => 'Update author'],
            ['name' => 'authors.delete', 'description' => 'Delete author'],
            
            // Image Routes
            ['name' => 'images.create', 'description' => 'Upload image'],
            ['name' => 'images.delete', 'description' => 'Delete image'],
            
            // Video Routes
            ['name' => 'videos.create', 'description' => 'Upload video'],
            ['name' => 'videos.update', 'description' => 'Update video'],
            ['name' => 'videos.delete', 'description' => 'Delete video'],
            ['name' => 'videos.show', 'description' => 'View video details'],
            
            // Event Routes
            ['name' => 'events.create', 'description' => 'Create new event'],
            ['name' => 'events.list', 'description' => 'View all events'],
            ['name' => 'events.show', 'description' => 'View event details'],
            ['name' => 'events.delete', 'description' => 'Delete event'],
            ['name' => 'events.update', 'description' => 'Update event'],
            ['name' => 'events.attach-author', 'description' => 'Attach author to event'],
            ['name' => 'events.detach-author', 'description' => 'Detach author from event'],
            ['name' => 'filter_events', 'description' => 'Filter events by criteria'], // MISSING
            
            // Event Analysis Routes
            ['name' => 'event-analysis.create', 'description' => 'Create event analysis'],
            ['name' => 'event-analysis.update', 'description' => 'Update event analysis'],
            ['name' => 'event-analysis.delete', 'description' => 'Delete event analysis'],
            
            // Expert Routes
            ['name' => 'experts.show', 'description' => 'View expert details'],
            ['name' => 'experts.list', 'description' => 'View all experts'],
            ['name' => 'experts.create', 'description' => 'Create new expert'],
            ['name' => 'experts.update', 'description' => 'Update expert'],
            ['name' => 'experts.delete', 'description' => 'Delete expert'],
            
            // Contact Routes
            ['name' => 'contacts.create', 'description' => 'Create expert contact'],
            ['name' => 'contacts.show', 'description' => 'View contact details'],
            ['name' => 'contacts.update', 'description' => 'Update contact'],
            
            // Contact Form Routes
            ['name' => 'contact-forms.create', 'description' => 'Submit contact form'],
            ['name' => 'contact-forms.list', 'description' => 'View all contact forms'],
            ['name' => 'contact-forms.show', 'description' => 'View contact form details'],
            ['name' => 'contact-forms.update', 'description' => 'Update contact form'],
            ['name' => 'contact-forms.delete', 'description' => 'Delete contact form'],
            
            // Settings Routes
            ['name' => 'settings.get-or-create', 'description' => 'Get or create settings'],
            ['name' => 'settings.update', 'description' => 'Update settings'],
            ['name' => 'settings.events-articles', 'description' => 'Get events and articles for homepage'],
            
            // Front Settings Routes - MISSING
            ['name' => 'get_front_data', 'description' => 'Get front settings data by ID'],
            ['name' => 'create_front_mode', 'description' => 'Create front settings mode'],
        ];
        $newPermissions = [
            // Event Filter Route - MISSING
            ['name' => 'filter_events', 'description' => 'Filter events by criteria'],
            
            // Front Settings Routes - MISSING
            ['name' => 'get_front_data', 'description' => 'Get front settings data by ID'],
            ['name' => 'create_front_mode', 'description' => 'Create front settings mode'],
        ];
        DB::table('permission')->insert($permissions);
        
      
    }
}
