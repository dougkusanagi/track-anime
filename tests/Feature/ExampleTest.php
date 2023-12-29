<?php

it('has a home page', function () {
    $this->get(route('home'))
        ->assertOk();
});

it('has a search page', function () {
    $this->get(route('search'))
        ->assertOk();
});
