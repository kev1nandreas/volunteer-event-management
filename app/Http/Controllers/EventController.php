<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $events = Event::with('users')->paginate($perPage);
            
            return $this->success(
                data: $events,
                success: true,
                code: 200,
                message: 'Events retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Failed to retrieve events',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        try {
            $event = Event::create($request->validated());
            
            return $this->created(
                data: $event,
                success: true,
                code: 201,
                message: 'Event created successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Failed to create event',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        try {
            $event->load('users');
            
            return $this->success(
                data: $event,
                success: true,
                code: 200,
                message: 'Event retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Failed to retrieve event',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }

    /**
     * User join the event.
     */
    public function join(Request $request, Event $event)
    {
        try {
            $user = $request->user();
            
            // Check if user already joined
            if ($event->users()->where('user_id', $user->id)->exists()) {
                return $this->error(
                    message: 'You have already joined this event',
                    success: false,
                    code: 400,
                    error: 'Duplicate entry'
                );
            }
            
            // Attach user to event
            $event->users()->attach($user->id);
            
            return $this->success(
                data: null,
                success: true,
                code: 200,
                message: 'Successfully joined the event'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Failed to join event',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }
}
