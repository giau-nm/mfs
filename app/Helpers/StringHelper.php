<?php
use Carbon\Carbon;

function formatDataDevice($array)
{
    foreach ($array as $key => $value) {
        if (is_string($value)) $array[$key] = str_replace('	', '    ', $value);
    }
    if (isset($array['checked_at'])) {
        $checkedAt = new Carbon($array['checked_at']);
        $array['checked_at'] = $checkedAt->format('Y-m-d');
    }
    return $array;
}