<?php

test('the home page redirects to dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});

test('admin pages redirect guests to login', function () {
    $response = $this->get('/categories');

    $response->assertRedirect('/login');
});
