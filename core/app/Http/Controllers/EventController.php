<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Response;

class EventController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEventRequest $request)
    {
        try {
            $event = new Event();
            $event->name = $request->name;
            $event->event_type = $request->event_type;
            $event->description = $request->description;
            $event->image_url = $request->image_url;
            $event->start_date = (new Carbon($request->start_date))->format('Y-m-d H:i:s');
            $event->end_date = (new Carbon($request->end_date))->format('Y-m-d H:i:s');
            $event->save();

            return self::success(message: "Event has been create successfully", httpStatusCode: Response::HTTP_CREATED);
        }catch (\Exception $e){
            return self::error(message: $e->getMessage(), httpStatusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
