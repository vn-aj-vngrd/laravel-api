<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $allowedParms = [];

    protected $columnMap = [];

    protected $operaterMap = [];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->allowedParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operaterMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
