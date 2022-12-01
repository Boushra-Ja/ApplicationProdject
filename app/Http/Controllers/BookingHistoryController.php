<?php

namespace App\Http\Controllers;

use App\Models\BookingHistory;
use App\Http\Requests\StoreBookingHistoryRequest;
use App\Http\Requests\UpdateBookingHistoryRequest;

class BookingHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingHistory  $bookingHistory
     * @return \Illuminate\Http\Response
     */
    public function show(BookingHistory $bookingHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookingHistory  $bookingHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingHistory $bookingHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingHistoryRequest  $request
     * @param  \App\Models\BookingHistory  $bookingHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingHistoryRequest $request, BookingHistory $bookingHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingHistory  $bookingHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingHistory $bookingHistory)
    {
        //
    }
}
