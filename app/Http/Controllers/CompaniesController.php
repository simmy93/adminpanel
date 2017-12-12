<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Requests\StoreCompanyRequest;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = Company::paginate(3);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create', Company::class);
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        //
        $this->authorize('create', Company::class);

       
        $file = $request->file('logo');
        $filename = $request->input('name') . '.jpg';
        if($file){

            Storage::disk('local')->put($filename, File::get($file));
            Company::create($request->all());
        return redirect()->route('companies.index')->with(['message' => 'Company added successfully']);
        }

        return redirect()->route('companies.index')->with(['message' => 'Blogai su paveiksliuku']);
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
        //$this->authorize('update', Company::class);
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCompanyRequest $request, $id)
    {
        //
        $this->authorize('update', Company::class);
        $company = Company::findOrFail($id);
        $company->update($request->all());
        return redirect()->route('companies.index')->with(['message' => 'Company updated successfully']);
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
        $this->authorize('delete', Company::class);
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with(['message' => 'Company deleted successfully']);
    }

    public function massDestroy(Request $request)
    {
        $this->authorize('delete', Company::class);
        $companies = explode(',', $request->input('ids'));
        foreach ($companies as $company_id) {
            $company = Company::findOrFail($company_id);
            $company->delete();
        }
        return redirect()->route('companies.index')->with(['message' => 'Companies deleted successfully']);
    }

    public function getCompanyImage($filename){
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}
