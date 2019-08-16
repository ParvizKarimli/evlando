<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
            'reported_type' => 'required|in:user,post',
            'category' => 'required|in:1,2,3,4',
            'message' => 'max:1000'
        ]);

        // Write to DB
        $report = new Report;
        $report->reporter_user_id = auth()->user()->id;
        if($request->reported_type === 'user')
        {
            $this->validate($request, ['user_id' => 'required|exists:users,id']);

            // Don't let the user report themselves
            if($request->user_id + 0 === auth()->user()->id)
            {
                return redirect()->back()->with('error', 'You cannot report yourself');
            }

            $report->reported_user_id = $request->user_id;
        }
        elseif($request->reported_type === 'post')
        {
            $this->validate($request, [
                'post_id' => 'required|exists:posts,id',
                'post_owner_id' => 'required'
            ]);

            // Don't let the user report their post
            if($request->post_owner_id + 0 === auth()->user()->id)
            {
                return redirect()->back()->with('error', 'You cannot report your post');
            }

            $report->post_id = $request->post_id;
        }
        $report->category = $request->category;
        $report->message = $request->message;
        $report->save();

        return redirect()->back()->with('success', 'Thanks for reporting!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
