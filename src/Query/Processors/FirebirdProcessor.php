<?php

namespace Xgrz\Firebird\Query\Processors;

use Illuminate\Database\Query\Processors\Processor;
use \Illuminate\Database\Query\Builder;

class FirebirdProcessor extends Processor
{
    /**
     * Process the results of a column listing query.
     *
     * @param  array  $results
     * @return array
     */
    public function processColumnListing($results)
    {
        return array_map(function ($result) {
            return ((object) $result)->column_name;
        }, $results);
    }

    /**
     * Process an  "insert get ID" query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $sql
     * @param  array  $values
     * @param  string|null  $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $query->getConnection()->insert($sql, $values);

      	$id = $query->getConnection()->getLastInsertId();

        return is_numeric($id) ? (int) $id : $id;
    }
}
