<?php
/**
 * Created by PhpStorm.
 * User: anoos
 * Date: 15/03/18
 * Time: 01:07 م
 */
$array = [
    'current_branch' => 'development', //branch name to be deployed
    'push_command_id' => 'PUSH_DEVELOPMENT_BRANCH_12344321', //in order to secure the command
    'changes_to_be_deployed' => 'branch', //changes to be deployed
];
 $array['git_commands'] =  [
    'pull_current_branch' => '
        git fetch && 
        git reset --hard origin/' . $array['current_branch'] . ' &&
        php composer.phar install --ignore-platform-reqs
    ',
];
return $array;