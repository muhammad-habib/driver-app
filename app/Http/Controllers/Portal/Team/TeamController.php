<?php

namespace App\Http\Controllers\Portal\Team;

use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Company;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * @author Mahmoud Soliman
     * @api get all teams
     * @param Request $request
     * @since 30/05/2018
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function teams(Request $request)
    {
        try{

            // make the needed parameters validation
            $validator = Validator::make($request->all(),[
                'company_id' => 'required|numeric|exists:companies,id',
            ]);

            if ($validator->fails()){
                return ValidationError::handle($validator);
            }

            // get company
            $company = Company::find($request->company_id);

            // get teams
            $teams = $company->teams()->with('drivers:id,name,active,mobile');

            return Response()->json([
                'message' => trans('team.confirm.retrieve'),
                'data' => $teams
            ],200);



        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }


    /**
     * @author Mahmoud Soliman
     * @api create team
     * @since 30/05/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function createTeam(Request $request)
    {
        try{

            // make the needed parameters validation
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'company_id' => 'required|numeric|exists:companies,id',
                'drivers' => 'array|exists:drivers,id',
            ]);

            if ($validator->fails()){
                return ValidationError::handle($validator);
            }

            $team = new Team();
            $team->name = $request->name;
            $team->company_id = $request->company_id;
            $team->save();

            // add the attached drivers to the team if any
            if($request->has('drivers') && !empty($request->drivers)){
                $team->drivers()->attach($request->drivers);
            }

            return Response()->json([
                'message' => trans('team.confirm.create'),
                'data' => $team->with('drivers:id,name,active,mobile')
            ],200);


        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Mahmoud Soliman
     * @api update team
     * @since 30/05/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function updateTeam(Request $request)
    {
        try {

            // make the needed parameters validation
            $validator = Validator::make($request->all(), [
                'team_id' => 'required|numeric|exists:companies,id',
                'name' => 'string',
                'drivers' => 'array|exists:drivers,id',
            ]);

            if ($validator->fails()) {
                return ValidationError::handle($validator);
            }

            // get team
            $team = Team::find($request->team_id);

            if($request->has('name') && $request->name != '')
                $team->name = $request->name;

            $team->save();

            if($request->has('drivers') && !empty($request->drivers)){
                $team->drivers()->sync($request->drivers);
            }

            return Response()->json([
                'message' => trans('team.confirm.update'),
                'data' => $team->with('drivers:id,name,active,mobile')
            ],200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Mahmoud Soliman
     * @api delete team
     * @since 30/05/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function deleteTeam(Request $request)
    {
        try{

            // make the needed parameters validation
            $validator = Validator::make($request->all(), [
                'team_id' => 'required|numeric|exists:companies,id',
            ]);

            if ($validator->fails()) {
                return ValidationError::handle($validator);
            }

            // get team
            $team = Team::find($request->team_id);

            // remove all related drivers from the pivot
            $team->drivers()->delete();

            // remove the team itself
            $team->delete();

            return Response()->json([
                'message' => trans('team.confirm.delete'),
            ],200);


        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

}
