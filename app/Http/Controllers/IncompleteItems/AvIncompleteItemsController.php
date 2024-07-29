<?php

namespace App\Http\Controllers\IncompleteItems;

use App\Http\Controllers\Controller;
use App\Models\IncompleteItems\AvIncompleteItems;
use App\Models\Branches\Branches;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AvIncompleteItemsController extends Controller
{

    // how to search for incomplete items using the location and item Id
    public function searchByLocationAndItemId(Request $request)
    {
        $request->validate([
            'location' => ['required', 'string', 'max:50'],
            'itemId' => ['string', 'max:50'],
        ]);

       // if the item Id is null, then search for the location only
        if ($request->itemId === null) {

            return $this->searchByLocation($request);
        }
        $branches = Branches::where('id', $request->location)->get();
        foreach ($branches as $branch) {
            $branch = $branch->name;
        }

        $incompleteItems = AvIncompleteItems::where('location', $request->location)
            ->where('itemId', $request->itemId)
            ->get();

        if($incompleteItems->isEmpty()) {
            
            return Inertia::render('IncompleteItems/Index', [
                'newItem' => [
                    'id' => 1,
                    'location' => $branch,
                    'itemId' => $request->itemId,
                ], 
            ]); 
        }
        
        return Inertia::render('IncompleteItems/Index', [
            'incompleteItems' => $incompleteItems->map(function ($incompleteItem) {
                return [
                    'id' => $incompleteItem->id,
                    'location' => $incompleteItem->branch->name,
                    'itemId' => $incompleteItem->itemId,
                ];
            }),
        ]);
    }

    
    private function searchByLocation($response)
    {
        $incompleteItems = AvIncompleteItems::where('location', $response->location)
                ->get();

        return Inertia::render('IncompleteItems/ItemsByBranch', [
            'incompleteItems' => $incompleteItems->map(function ($incompleteItem) {
                return [
                    'id' => $incompleteItem->id,
                    'location' => $incompleteItem->branch->name,
                    'itemId' => $incompleteItem->itemId,
                    'title' => $incompleteItem->title,
                    'createDate' => $incompleteItem->createDate,
                    'userId' => $incompleteItem->userId,
                    'userKey' => $incompleteItem->userKey,
                    'userName' => $incompleteItem->userName,
                    'userEmail' => $incompleteItem->userEmail,
                    'userPhone' => $incompleteItem->userPhone,
                ];
            }),
        ]);
    }

    // if item is not found, the post the item to the database
    public function store(Request $request)
    {
        $request->validate([
            'location' => ['required', 'string', 'max:50'],
            'itemId' => ['required', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:50'],
            'createDate' => ['required', 'date'],
            'userId' => ['required', 'string', 'max:50'],
            'userKey' => ['required', 'string', 'max:50'],
            'userName' => ['required', 'string', 'max:50'],
            'userEmail' => ['required', 'string', 'max:50'],
            'userPhone' => ['required', 'string', 'max:50'],
        ]);

        AvIncompleteItems::create([
            'location' => $request->location,
            'itemId' => $request->itemId,
            'title' => $request->title,
            'createDate' => $request->createDate,
            'userId' => $request->userId,
            'userKey' => $request->userKey,
            'userName' => $request->userName,
            'userEmail' => $request->userEmail,
            'userPhone' => $request->userPhone,
            'branch_id' => $branch->id,
        ]);

        return redirect()->route('incompleteItems.index');
    }
 
}
