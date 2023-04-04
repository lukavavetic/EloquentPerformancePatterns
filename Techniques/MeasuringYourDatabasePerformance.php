<?php

class UserController
{
    public function index()
    {
        /**
         * Time to load page: 28.2ms
         * Memory: 4MB
         * Queries counter: 2
         * Models: 17
         * Queries: "select * from users limit 16 offset 0", "select * from companies where companies.id in (1)"
         */
        User::query()
            ->with('company')
            ->simplePaginate();

        /**
         * Time to load page: 30.76ms
         * Memory: 5MB
         * Queries counter: 16
         * Models: 31
         * Queries: "select * from users limit 16 offset 0",  15 x "select * from companies where companies.id in (1)"
         * Comment: Laravel has to load company one by one for each user
         */
        User::query()
            //->with('company')
            ->simplePaginate();

        /**
         * Time to load page: 47.7ms
         * Memory: 4MB
         * Queries counter: 2
         * Query execution time: 28.84ms
         * Models: 32
         * Queries: "select * from users limit 16 offset 0", "select * from companies where companies.id in (138, 141, 211, ...)"
         */
        User::query()
            ->with('company')
            ->orderBy('name')
            ->simplePaginate();

        /**
         * Comment: Index has been added on *name* column via Laravel migration.
         * Time to load page: 27.96ms
         * Memory: 4MB
         * Queries counter: 2
         * Query execution time: 2.86ms
         * Models: 32
         * Queries: "select * from users limit 16 offset 0", "select * from companies where companies.id in (138, 141, 211, ...)"
         */
        User::query()
            ->with('company')
            ->orderBy('name')
            ->simplePaginate();

        /**
         * Comment: Eager load property Company $with = ['users'] for the 'users' relationship has been added to Company model.
         * Time to load page: 28.75ms
         * Memory: 6MB
         * Queries counter: 3
         * Models: 832
         */
        User::query()
            ->with('company')
            ->orderBy('name')
            ->simplePaginate();
    }
}