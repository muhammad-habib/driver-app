<?php

namespace App\Http\Controllers\Development;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;

class DeploymentController extends Controller
{
    /**
     * @author Anas AlSbenati
     * @since 5/06/2018
     * @param $request
     * @version 1.0
     * @return mixed
     */
    public function pullDevelopmentBranch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "commandId" => "required|string",
            "push" => "required|array",
        ]);
        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            return response()->json(['message' => $msg], 400);
        }
        $output = '';
        if($request->get('commandId') == config('development.deployment.push_command_id')) {

            $push = $request->get('push');
            if ($push['changes'][0]['new']['type'] == config('development.deployment.changes_to_be_deployed') &&
                $push['changes'][0]['new']['name'] == config('development.deployment.current_branch')
            ) {
                $command = new Process(config('development.deployment.git_commands.pull_current_branch'));

                $command->setWorkingDirectory(base_path());
                $command->run(function ($type, $buffer) use (&$output) {
                    if (Process::ERR === $type) {
                        $output = $buffer;
                    } else {
                        $output = $buffer;
                    }
                });

            }
            return response()->json([$output]);
        } else {
            return null;
        }
    }
}
