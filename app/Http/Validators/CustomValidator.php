<?php
namespace App\Http\Validators;

use Carbon\Carbon;

class CustomValidator
{
    public function maxDateRequest($attribute, $value, $parameters, $validator)
    {
        $compareParam = $parameters[0];
        $maxDateParam = $parameters[1];
        $requestData  = $validator->getData();
        if (!isset($requestData[$compareParam])) return false;
        $dateStart = Carbon::createFromFormat('Y-m-d', $requestData[$compareParam]);
        $dateEnd   = Carbon::createFromFormat('Y-m-d', $value);
        $dateEndCorrect = $dateStart->addWeekdays($maxDateParam)->subDay();

        return $dateEnd->lte($dateEndCorrect);
    }
}