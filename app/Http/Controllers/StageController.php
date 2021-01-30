<?php

namespace App\Http\Controllers;

use App\Http\Requests\StageRequest;
use App\Models\Stage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $stages = Stage::all();
        return view('admin.stages.index',compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('admin.stages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StageRequest $request
     * @return RedirectResponse
     */
    public function store(StageRequest $request)
    {
        $validatedData = $request->validated();

        if (isset($validatedData['bonus_status']))
        {
            if ($validatedData['bonus_status'] == 'checked')
            {
                $validatedData['bonus_status'] = '1';
            } else {
                $validatedData['bonus_status'] = '0';
            }
        } else {
            $validatedData['bonus_status'] = '0';
        }

        try {
            Stage::create($validatedData);
            return back()->with('success', __('The stage successfully created!'));
        } catch (\Exception $e) {
            return back()->with('error', __('Stage could not be created!'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Stage $stage
     * @return Response
     */
    public function show(Stage $stage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Stage $stage
     * @return Application|Factory|View|Response
     */
    public function edit(Stage $stage)
    {
        $sells = $stage->sells;
        return view('admin.stages.edit',compact('stage','sells'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Stage $stage
     * @return RedirectResponse
     */
    public function update(StageRequest $request, Stage $stage)
    {
        $validatedData = $request->validated();

        if (isset($validatedData['bonus_status']))
        {
            if ($validatedData['bonus_status'] == 'checked')
            {
                $validatedData['bonus_status'] = '1';
            } else {
                $validatedData['bonus_status'] = '0';
            }
        } else {
            $validatedData['bonus_status'] = '0';
        }

        try {
            Stage::find($stage->id)->update($validatedData);
            return back()->with('success', __('The stage successfully updated!'));
        } catch (\Exception $e) {
            return back()->with('error', __('Stage could not be updated!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Stage $stage
     * @return RedirectResponse
     */
    public function destroy(Stage $stage)
    {
        try {
            $stage->delete();
            return redirect()->route('admin.stages.index')->with('success', __('The stage successfully deleted!'));
        } catch (\Exception $e) {
            return redirect()->route('admin.stages.index')->with('error', __('Stage could not be deleted!'));
        }
    }
}
