<?php

namespace App\Http\Controllers\DriverApp\Company;

use App\Http\Controllers\Controller;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Company;
use App\Models\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebhooksController extends Controller
{
    
    /**
     * @SWG\Post(
     *     path="v1/webhooks",
     *     tags={"Company"},
     *     description="Add webhook to comapny",
     *     operationId="addWebhook",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="url",
     *         in="formData",
     *         description="Webhook url",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="code",
     *         in="formData",
     *         description="Webhook code",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="company_id",
     *         in="formData",
     *         description="Company ID. Later we may will not need this field, it may replaced by company authentication key",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation returns success message",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *              ),
     * 			@SWG\Property(
     *                      property="data",
     *                      type="object",
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Validation Errors",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Fields are invalid",
     *              ),
     *              @SWG\Property(
     *                      property="details",
     *                      type="string",
     *              )
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Server Error",
     *              ),
     *              @SWG\Property(
     *                      property="details",
     *                      type="string",
     *              )
     *         )
     *     ),
     *     security={
     *       {"default": {}}
     *     }
     * )
     */
    public function addWebhook(Request $request)
    {
    	
    	$validator = Validator::make($request->all(), [
			'url' => 'required|string|unique:company_webhook',
			'code' => 'required|numeric|exists:webhooks,code',
			'company_id' => 'required|numeric|exists:companies,id'
      	]);

		if ($validator->fails()){
			return ValidationError::handle($validator);
		}

		try{
		  
			// Get company
			$company = Company::find($request->company_id);
			
			// Get WebHook
			$webhook = Webhook::where('code', $request->code)->first();

			// Add company web hooks
			$company_webhook = $company->webhooks()->syncWithoutDetaching(
				array(
					$webhook->id => array('code' => $request->code, 'url' => $request->url)
				)
			);

			// return success
			return response()->json([
			    'message' => trans('company.webhooks.success'),
			], 200);

		}catch (\Exception $e){
			return ServerError::handle($e);
		}
    }
}
