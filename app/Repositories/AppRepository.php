<?php

namespace App\Repositories;
use Excel;

trait AppRepository
{

    public function checkValidator($data, $validators)
    {
        $rules = isset($validators['rules']) ? $validators['rules'] : [];
        $messages = isset($validators['messages']) ? $validators['messages'] : [];
        $attributes = isset($validators['attributes']) ? $validators['attributes'] : [];
        return validator($data, $rules, $messages, $attributes);
    }

    public function toExport($heading, $data, $extension = 'csv') {
        $dataExport = [];
        $dataExport[] = array_values($heading);
        $columnKeys = array_keys($heading);
        foreach($data as $key => $item) {
            $mapping = $this->mappingColumn($columnKeys, $item);
            if (!empty($mapping)) {
                $dataExport[] = array_replace(array_flip($columnKeys), $mapping);
            }
        }
        Excel::create('Filename', function ($excel) use ($dataExport) {
            $excel->sheet('Sheet', function ($sheet) use ($dataExport) {
                $sheet->fromArray($dataExport, null, 'A1', true, false);
            });
        })->download($extension);
    }

    public function mappingColumn($column, $data)
    {
        $result = [];
        foreach($data as $key => $item) {
            if (in_array($key, $column)) {
                $result[$key] = $item;
            }
        }
        return $result;
    }
}
