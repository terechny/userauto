<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auto;

class AutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [];
        $data['list'] = Auto::all();
        return response()->json( ['data' => $data ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
        // Сделать валидацию без переадресации

        $validated = $request->validate([
            'name' => ['required', 'max:100', 'min:3'],
            'number' => ['required', 'max:100', 'min:3'],
        ]);

        $result['data']['created'] = Auto::create([
            "name" => $request->name,
            "number" => $request->number
        ]);

        $responceStatus = $result ? 201 : 501;

        return response()
            ->json($result, $responceStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $data['auto'] = Auto::findOrFail((int)$id);
        return response()->json([ 'data' => $data ]);
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
        $data = [];
     
        $auto = Auto::findOrFail((int)$id);

        // Сделать валидацию без переадресации

        $validated = $request->validate([
            'name' => ['required', 'max:100', 'min:3'],
            'number' => ['required', 'max:100', 'min:3'],
        ]);

        $auto->name  = $request->name;
        $auto->number = $request->number;

        $result = $auto->save();

        $data['result'] = $result;

        return response()->json( ['data' => $data ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [];
        $data['result'] = Auto::destroy((int)$id);
        return response()->json( ['data' => $data ] );
    }
}
