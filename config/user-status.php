<?php

return [

    /**
     * Tables
     *
     * The table names used by the package.
     */
    'tables' => [
        'status_table' => 'user_statuses',
    ],

    /**
     * Statuses
     *
     * We don't store them in the database to reduce the number of queries.
     */
    'statuses' => [
        1  => [
            'name' => 'online',
            'color' => 'green',
            'icon' => 'fas fa-circle',
        ],
        2  => [
            'name' => 'away',
            'color' => 'yellow',
            'icon' => 'fas fa-circle',
        ],
        3  => [
            'name' => 'offline',
            'color' => 'gray',
            'icon' => 'fas fa-circle',
        ],
        4  => [
            'name' => 'busy',
            'color' => 'red',
            'icon' => 'fas fa-circle',
        ],
        5  => [
            'name' => 'invisible',
            'color' => 'gray',
            'icon' => 'fas fa-circle',
        ],
        6  => [
            'name' => 'do_not_disturb',
            'color' => 'red',
            'icon' => 'fas fa-circle',
        ],
        7  => [
            'name' => 'custom',
            'color' => 'custom',
            'icon' => 'custom',
        ]
    ],

    /**
     * Laravel Echo Configuration
     *
     * This is used to broadcast the status changes to the frontend
     * and update the status in real-time. (if enabled)
     */
    'echo' => [
        /**
         * Enable or disable the broadcasting of the status changes
         */
        'enabled' => false,
        'channel' => 'statusable.{type}.{id}',
        /**
         * Enable or disable the broadcasting of the presence changes
         */
        'presences_enabled' => false,
        'presences' => 'statusable.{type}.{id}.presences',
    ],

    /**
     * Status Model
     *
     * The model used to store the statuses, you can extend the model
     * and change the class here. NOT RECOMMENDED, but possible.
     */
    'status_model' => \BrianLogan\LaravelUserStatus\Models\Status::class,

    /**
     * Keep History
     *
     * If enabled, the package will keep past statuses in the database.
     *
     * This is useful for analytics and other purposes, but is disabled
     * by default to reduce the size of the database.
     *
     * If you enable this, you should also enable the `echo.enabled` option
     * to keep the frontend in sync with the backend.
     *
     * This will update the status model to use a morphMany relationship
     * instead of a morphOne relationship.
     */
    'keep_history' => false,

];
