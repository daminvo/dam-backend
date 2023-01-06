<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Viva;
use Keygen\Keygen;



use Laravel\Lumen\Routing\Controller as BaseController;



class UserController extends Controller
{
    public function CreateViva(Request $request) {
        Viva::insert(['Pr_Key'=>$this->setCode(),'Pr_Name'=>$request->name,'Anee' => $request->year,'Fst_Student' => $request->firstStudent,'Sst_Student'=>$request->secondStudent,
        'Tst_Student'=>$request->thirdStudent,'Supervisor'=>$request->supervisor,'Examiner'=>$request->examiner,'President'=>$request->president,
        'Sp_Mark'=>$request->spMark,'Ex_Mark'=>$request->exMark,'Pr_Mark'=>$request->prMark,'Final_Mark'=>$request->vivaMark,'User_Id'=>$request->userId,]);
        return response()->json([
        'msg' => 'information inserted successfuly',
            ]);
    }

    public function getVivaInfo(request $request) {
        return DB::table('vivas')
                    ->where('Pr_Key', '=',$request->id )
                    ->get();
    }
    
    public function setCode() {
        $key=Keygen::alphanum(5)->generate();
        $project = Viva::where("Pr_Key","=",$key)
        ->get();
        while(count($project)>0){
            $key=Keygen::alphanum(5)->generate();
            $project = Viva::where("Pr_Key","=",$key);
        }
        return $key;
    }   



    public function index()
    {
        return User::all();
    }


    public function create(Request $request)
    {
        //
    }


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
