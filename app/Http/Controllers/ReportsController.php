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
        if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'mod')
        {
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $reports = Report::orderBy('id', 'desc')->paginate(20);

        $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        $number_of_unseen_reports = Report::where('seen', 0)->count();

        return view('reports.index')->with([
            'reports' => $reports,
            'unseen_reports' => $unseen_reports,
            'number_of_unseen_reports' => $number_of_unseen_reports
        ]);
    }

    // Get reports based on the criteria user selects
    public function get(Request $request)
    {
        if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'mod')
        {
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $types = $request->input('types');
        $seen = $request->input('seen');
        $resolved = $request->input('resolved');
        $categories = $request->input('categories');

        if(empty($types))
        {
            $types = ['users', 'posts'];
        }
        if(empty($seen))
        {
            $seen = ['0', '1'];
        }
        if(empty($resolved))
        {
            $resolved = ['0', '1'];
        }
        if(empty($categories))
        {
            $categories = ['1', '2', '3', '4'];
        }

        // If only users selected
        if(in_array('users', $types) && !in_array('posts', $types))
        {
            // Get only users
            $reports = Report::whereNotNull('reported_user_id')
                ->whereIn('seen', $seen)
                ->whereIn('resolved', $resolved)
                ->whereIn('category', $categories)
                ->orderBy('id', 'desc')
                ->paginate(20);
        }
        // If only posts selected
        elseif(in_array('posts', $types) && !in_array('users', $types))
        {
            // Get only posts
            $reports = Report::whereNotNull('post_id')
                ->whereIn('seen', $seen)
                ->whereIn('resolved', $resolved)
                ->whereIn('category', $categories)
                ->orderBy('id', 'desc')
                ->paginate(20);
        }
        // If both or more selected
        elseif(in_array('users', $types) && in_array('posts', $types))
        {
            // Get both users and posts
            $reports = Report::whereIn('seen', $seen)
                ->whereIn('resolved', $resolved)
                ->whereIn('category', $categories)
                ->orderBy('id', 'desc')
                ->paginate(20);
        }
        // If none but something else selected
        elseif(!in_array('users', $types) && !in_array('posts', $types))
        {
            // Get nothing
            $reports = NULL;
        }

        $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        $number_of_unseen_reports = Report::where('seen', 0)->count();

        return view('reports.index')->with([
            'reports' => $reports,
            'unseen_reports' => $unseen_reports,
            'number_of_unseen_reports' => $number_of_unseen_reports
        ]);
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
        if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'mod')
        {
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $report = Report::find($id);

        if(empty($report))
        {
            return redirect()->back()->with('error', 'Report Not Found');
        }

        $report->seen = 1;
        $report->save();

        $unseen_reports = Report::where('seen', 0)
                ->orderBy('id', 'desc')
                ->paginate(10);
        $number_of_unseen_reports = Report::where('seen', 0)->count();

        return view('reports.show')->with([
            'report' => $report,
            'unseen_reports' => $unseen_reports,
            'number_of_unseen_reports' => $number_of_unseen_reports
        ]);
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
    public function update($id)
    {
        if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'mod')
        {
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $report = Report::find($id);

        if(empty($report))
        {
            return redirect()->back()->with('error', 'Report Not Found');
        }

        if($report->resolved === 0)
        {
            $report->resolved = 1;
            $report->save();
            return redirect()->back()->with('success', 'Report Marked as Resolved');
        }
        elseif($report->resolved === 1)
        {
            $report->resolved = 0;
            $report->save();
            return redirect()->back()->with('success', 'Report Marked as Unresolved');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'mod')
        {
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $report = Report::find($id);

        if(empty($report))
        {
            return redirect()->back()->with('error', 'Report Not Found');
        }

        $report->delete();
        return redirect('/reports')->with('success', 'Report Deleted');
    }
}
