<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DealNotification;
use App\Models\Deal;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subscribers_manage')->only(['index', 'sendBulkDeal']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::featured()->get();
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.subscribers.index', compact('subscribers', 'deals'));
    }

    public function sendBulkDeal(Request $request)
    {
        $request->validate([
            'subscribers' => 'required|string',
            'deal_id' => 'required|exists:deals,id'
        ]);

        $subscriberIds = explode(',', $request->subscribers);
        $deal = Deal::findOrFail($request->deal_id);

        // Get subscribers
        $subscribers = Subscriber::whereIn('id', $subscriberIds)->get();


        setMailConfigFromDB();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new DealNotification($deal));
        }

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Deal sent to ' . count($subscribers) . ' subscribers successfully.');
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
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
