<?php

namespace App\Http\Controllers\Development;

use App\Notifications\Deploy;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
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
        var_dump('1');
        $validator = Validator::make($request->all(), [
            "commandId" => "required|string",
            "push" => "required|array",
        ]);
        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            return response()->json(['message' => $msg], 400);
        }
        $output = '';
        $push = $request->get('push');
        if($request->get('commandId') == config('development.deployment.push_command_id')) {

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

        } else {
            $output = "non";
        }
        $message = $output;
        if(isset($push['changes'][0]['new']['target'])) {
            $target = $push['changes'][0]['new']['target'];
            $message = $target['auther'] . ' deployed some fresh code!\n';
            $message .= 'The Message: ' . $target['message'] . '\n';
        }
        Notification::send(new User(), new Deploy($message));
        return response()->json([$output]);
    }
}
