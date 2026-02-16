<?php

namespace Docs;

use OpenApi\Attributes as OA;

class EventDocumentation {
    #[OA\Get(
        path: '/api/events',
        summary: 'Get all events',
        description: 'Retrieve a paginated list of all events with their participants',
        tags: ['Events'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'per_page',
                in: 'query',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(
                    type: 'integer',
                    default: 10,
                    example: 10
                )
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                description: 'Page number',
                required: false,
                schema: new OA\Schema(
                    type: 'integer',
                    default: 1,
                    example: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Events retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Events retrieved successfully'),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer', example: 1),
                                new OA\Property(
                                    property: 'data',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '123e4567-e89b-12d3-a456-426614174000'),
                                            new OA\Property(property: 'title', type: 'string', example: 'Community Cleanup Event'),
                                            new OA\Property(property: 'description', type: 'string', example: 'Join us for a community cleanup event'),
                                            new OA\Property(property: 'event_date', type: 'string', format: 'date-time', example: '2026-03-15T10:00:00.000000Z'),
                                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-02-16T00:00:00.000000Z'),
                                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-02-16T00:00:00.000000Z'),
                                            new OA\Property(
                                                property: 'users',
                                                type: 'array',
                                                items: new OA\Items(
                                                    properties: [
                                                        new OA\Property(property: 'id', type: 'string', example: '9d4e8f12-3456-7890-abcd-ef1234567890'),
                                                        new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                                                        new OA\Property(property: 'email', type: 'string', example: 'john@example.com')
                                                    ]
                                                )
                                            )
                                        ]
                                    )
                                ),
                                new OA\Property(property: 'first_page_url', type: 'string', example: 'http://localhost:8000/api/events?page=1'),
                                new OA\Property(property: 'from', type: 'integer', example: 1),
                                new OA\Property(property: 'last_page', type: 'integer', example: 10),
                                new OA\Property(property: 'per_page', type: 'integer', example: 10),
                                new OA\Property(property: 'to', type: 'integer', example: 10),
                                new OA\Property(property: 'total', type: 'integer', example: 100)
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.')
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Failed to retrieve events'),
                        new OA\Property(property: 'error', type: 'object')
                    ]
                )
            )
        ]
    )]

    #[OA\Post(
        path: '/api/events',
        summary: 'Create a new event',
        description: 'Create a new event with title, description, and event date',
        tags: ['Events'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'description', 'event_date'],
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        maxLength: 255,
                        example: 'Community Cleanup Event'
                    ),
                    new OA\Property(
                        property: 'description',
                        type: 'string',
                        example: 'Join us for a community cleanup event to make our neighborhood cleaner and greener'
                    ),
                    new OA\Property(
                        property: 'event_date',
                        type: 'string',
                        format: 'date-time',
                        description: 'Event date must be in the future',
                        example: '2026-03-15T10:00:00'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Event created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Event created successfully'),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '123e4567-e89b-12d3-a456-426614174000'),
                                new OA\Property(property: 'title', type: 'string', example: 'Community Cleanup Event'),
                                new OA\Property(property: 'description', type: 'string', example: 'Join us for a community cleanup event'),
                                new OA\Property(property: 'event_date', type: 'string', format: 'date-time', example: '2026-03-15T10:00:00.000000Z'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-02-16T00:00:00.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-02-16T00:00:00.000000Z')
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.')
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'The given data was invalid'),
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            example: [
                                'title' => ['The title field is required.'],
                                'event_date' => ['The event date must be a date after now.']
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Failed to create event'),
                        new OA\Property(property: 'error', type: 'object')
                    ]
                )
            )
        ]
    )]

    #[OA\Get(
        path: '/api/events/{id}',
        summary: 'Get event details',
        description: 'Retrieve detailed information about a specific event including its participants',
        tags: ['Events'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Event ID',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid', example: '123e4567-e89b-12d3-a456-426614174000')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Event retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Event retrieved successfully'),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '123e4567-e89b-12d3-a456-426614174000'),
                                new OA\Property(property: 'title', type: 'string', example: 'Community Cleanup Event'),
                                new OA\Property(property: 'description', type: 'string', example: 'Join us for a community cleanup event'),
                                new OA\Property(property: 'event_date', type: 'string', format: 'date-time', example: '2026-03-15T10:00:00.000000Z'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-02-16T00:00:00.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-02-16T00:00:00.000000Z'),
                                new OA\Property(
                                    property: 'users',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '9d4e8f12-3456-7890-abcd-ef1234567890'),
                                            new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                                            new OA\Property(property: 'email', type: 'string', example: 'john@example.com'),
                                            new OA\Property(
                                                property: 'pivot',
                                                properties: [
                                                    new OA\Property(property: 'event_id', type: 'string', format: 'uuid', example: '123e4567-e89b-12d3-a456-426614174000'),
                                                    new OA\Property(property: 'user_id', type: 'string', example: '9d4e8f12-3456-7890-abcd-ef1234567890'),
                                                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                                                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time')
                                                ],
                                                type: 'object'
                                            )
                                        ]
                                    )
                                )
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Event not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Event not found')
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Failed to retrieve event'),
                        new OA\Property(property: 'error', type: 'object')
                    ]
                )
            )
        ]
    )]

    #[OA\Post(
        path: '/api/events/{id}/join',
        summary: 'Join an event',
        description: 'Authenticated user joins a specific event',
        tags: ['Events'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Event ID',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid', example: '123e4567-e89b-12d3-a456-426614174000')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully joined the event',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Successfully joined the event'),
                        new OA\Property(property: 'data', type: 'null')
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Already joined',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'You have already joined this event'),
                        new OA\Property(property: 'error', type: 'string', example: 'Duplicate entry')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Event not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Event not found')
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Failed to join event'),
                        new OA\Property(property: 'error', type: 'object')
                    ]
                )
            )
        ]
    )]

    public function index() {}
    public function store() {}
    public function show() {}
    public function join() {}
}
