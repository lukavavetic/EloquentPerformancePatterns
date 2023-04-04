<?php

class PostsController
{
    public function index()
    {
        /**
         * Time to load page: 31.6ms
         * Memory: 19.8MB
         * Queries counter: 2
         * Query execution time: 6.58ms
         * Models: 120
         * Queries:
         *  "select * from posts order by published_at desc",
         *  "select * from users where users.id in (1, 2, 3, ...)"
         */
        $years = Post::query()
            ->with('author')
            ->latest('published_at')
            ->get()
            ->groupBy(fn ($post) => $post->published_at->year);


        /**
         * Time to load page: 28.12ms
         * Memory: 4.35MB
         * Queries counter: 2
         * Query execution time: 2.55ms
         * Models: 120
         * Queries:
         *  "select id, title, slug, published_at, author_id from posts order by published_at desc",
         *  "select * from users where users.id in (1, 2, 3, ...)"
         */
        $years = Post::query()
            ->select('id', 'title', 'slug', 'published_at', 'author_id')
            ->with('author')
            ->latest('published_at')
            ->get()
            ->groupBy(fn ($post) => $post->published_at->year);

        /**
         * Time to load page: 24.71ms
         * Memory: 4.34MB
         * Queries counter: 2
         * Query execution time: 2.49ms
         * Models: 120
         * Queries:
         *  "select id, title, slug, published_at, author_id from posts order by published_at desc",
         *  "select id, name from users where users.id in (1, 2, 3, ...)"
         */
        $years = Post::query()
            ->select('id', 'title', 'slug', 'published_at', 'author_id')
//            ->with(['author' => function ($query) {
//                $query->select('id', 'name');
//            }])
            ->with('author:id, name')
            ->latest('published_at')
            ->get()
            ->groupBy(fn ($post) => $post->published_at->year);
    }
}