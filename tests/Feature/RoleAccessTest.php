<?php

// test('homepage is working', function () {
//     $response = $this->get('/');
//     $response->assertStatus(200);
// });
// tests/Feature/RoleAccessTest.php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::where('role', 'admin')->first();
    $this->hr = User::where('role', 'hr')->first();
    $this->dev = User::where('role', 'development')->first();
});

test('admin can access dashboard', function () {
    $this->actingAs($this->admin)
         ->get('/dashboard')
         ->assertOk();
});

test('hr cannot access department', function () {
    $this->actingAs($this->hr)
         ->get(route('departments.index'))
         ->assertForbidden();
});
