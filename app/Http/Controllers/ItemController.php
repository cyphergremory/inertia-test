<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ItemController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    $query = $request->get('query');
    
            $items = Item::when($query,function($q) use ($query){
                $q->where('name','like',"%$query%");
            })->paginate($request->get('perPage'));
        return Inertia::render('Todo/Index',[
            'links' => [
                'current' => $items->currentPage(),
                'from'=> $items->firstItem(),
                'to'=>$items->lastItem(),
                'total' => $items->total(),
                'pages' => $items->lastPage(),

            ],
            'items' => $items->items(),
            'queryString' => $request->get('query'),
            'perPage' =>(string) $request->get('perPage',10),
            
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
        //
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

    public function searchByQueryString(Request $request){

        Item::where('name','like',"%{$request->get('query')}%")->paginate();
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

    public function filter(Request $request){

    }
}

