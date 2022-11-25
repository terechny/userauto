<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autousers;
use App\Models\Auto;
use App\Models\Users_auto;

class AutouserController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [];
        $data['list'] = Autousers::all();
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

        $validated = $request->validate([
            'firstname' => ['required', 'max:100', 'min:3'],
            'secondname' => ['required', 'max:100', 'min:3'],
        ]);

        $result['data']['created'] = Autousers::create([
            "firstname" => $request->firstname,
            "secondname" => $request->secondname
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

        $result = Autousers::findOrFail((int)$id);
        return response()->json($result);
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
     
        $user = Autousers::findOrFail((int)$id);

        $validated = $request->validate([
            'firstname' => ['required', 'max:100', 'min:3'],
            'secondname' => ['required', 'max:100', 'min:3'],
        ]);

        $user->firstname  = $request->firstname;
        $user->secondname = $request->secondname;

        $result = $user->save();

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
        $data['result'] = Autousers::destroy((int)$id);
        return response()->json( ['data' => $data ] );
    }

    public function setUserAuto(Request $request){

        $validated = $request->validate([
            'user' => ['required', 'numeric'],
            'auto' => ['required', 'numeric'],
        ]);

        $keyExist = Users_auto::where('user_id', '=', (int)$request->user)
                    ->where('auto_id', '=', (int)$request->auto)
                    ->exists();

        Autousers::findOrFail((int)$request->user);
        Auto::findOrFail((int)$request->auto);

        if( !$keyExist ){

            $result = Users_auto::create([
                'user_id' => (int)$request->user,
                'auto_id' => (int)$request->auto
            ]);

        }else{
            
            $result = [];
        }

        $data = [];
        $data['result'] = $result;
    
        return response()->json( ['data' => $data ] );

    }

    public function destroyUserAuto(Request $request){

        $validated = $request->validate([
            'user' => ['required', 'numeric'],
            'auto' => ['required', 'numeric'],
        ]);

        $data = [];

        $autoUser = Users_auto::where('user_id', '=', (int)$request->user)
                    ->where('auto_id', '=', (int)$request->auto);

        $data['result'] = $autoUser->delete();

        return response()->json( ['data' => $data ] );

    }

    public function showUserAuto($id){

        $data = [];

        $data['user_auto'] = Autousers::select('autousers.*', 
                                               'autos.id as auto_id', 
                                               'autos.name as auto_name', 
                                               'autos.number as auto_number'
                                               )
                                               ->join('users_autos', 'autousers.id', '=', 'users_autos.user_id' )
                                               ->join('autos', 'users_autos.auto_id', '=', 'autos.id' )
                                               ->where('autousers.id', '=', (int)$id)->get()->first();

        
        return response()->json( ['data' => $data ] );

    }

}
