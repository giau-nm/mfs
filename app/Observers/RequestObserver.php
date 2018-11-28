<?php

namespace App\Observers;

use App\Models\Request;
use App\Models\Device;
use Carbon\Carbon;

class RequestObserver
{
    /**
     * Handle the request "created" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function created(Request $request)
    {
        //
    }

    /**
     * Handle the request "updated" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function updated(Request $request)
    {
        $deviceModal = Device::find($request->device_id);

        if ($request->isDirty('status')) {

            $timeNow = Carbon::now()->format('Y-m-d');
            if ($request->status == STATUS_REQUEST_ACCEPT) {
                $deviceModal->status = STATUS_DEVICES_BUZY;
                if (is_null($request->actual_start_time)) {
                    $request->actual_start_time = $timeNow;
                    $request->save();
                }
            }
            if ($request->status == STATUS_REQUEST_REJECT) {
                $deviceModal->status = STATUS_DEVICES_AVAIABLE;
            }
            if ($request->status == STATUS_REQUEST_PAID) {
                $deviceModal->status = STATUS_DEVICES_AVAIABLE;
                $requestModel = Request::find($request->id);
                $requestModel->actual_end_time = $timeNow;
                $requestModel->save();
            }

            return $deviceModal->save();
        }

        if ($request->isDirty('actual_end_time') && $request->getOriginal('actual_end_time') != null) {
            $deviceModal->status = STATUS_DEVICES_AVAIABLE;
            return $deviceModal->save();
        }
    }

    /**
     * Handle the request "deleted" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function deleted(Request $request)
    {
        if ($request->status == STATUS_REQUEST_ACCEPT) {
            $deviceModal = Device::find($request->device_id);
            $deviceModal->status = STATUS_DEVICES_AVAIABLE;
            $deviceModal->save();
        }
        return true;
    }

    /**
     * Handle the request "restored" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function restored(Request $request)
    {
        //
    }

    /**
     * Handle the request "force deleted" event.
     *
     * @param  \App\Models\Request  $request
     * @return void
     */
    public function forceDeleted(Request $request)
    {
        //
    }
}
