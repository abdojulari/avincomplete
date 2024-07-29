<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Branches\Branches;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    // using inertia and vue to render the view 
    public function index()
    {
        return Inertia::render('Branches/Index', [
            'branches' => Branches::all()->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                ];
            }),
        ]);
    }

    // store the item with the request data i.e. branch and item Id
    public function store(Request $request)
    {
        $request->validate([
            'selectedBranch' => [
                'required','string', 'max:50'],
            'itemID' => ['required', 'max:50'],
        ]);

        Log::info($request->all());
        //Branches::create($request->all());

        return redirect('/items');

    }
    

}
