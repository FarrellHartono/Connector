<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Sortable
{
    /**
     * Apply sorting to the given query based on request parameters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applySorting($query, $request)
    {
        // Sort dari defaultnya by title dan ascending
        $sortBy = $request->input('sort_by', 'title');
        $orderBy = $request->input('order', 'asc');

        // aplikasiin sorting dari query yang ada ke database
        if (in_array($sortBy, ['title', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $orderBy);
        }

        return $query;
    }

    public function applySortingInvestors($query, Request $request)
    {


        // Get sorting parameters from the request
        $sortBy = $request->input('sort', 'name');
        $sortOrder = $request->input('order', 'asc');

        // Validate sort order to prevent invalid input
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc'; // Fallback to default sort order
        }

        $sortColumn = 'users.name';
        // Determine the column to sort by
        if ($sortBy === 'amount') {
            $sortColumn = 'investments.amount';
        } elseif ($sortBy === 'name') {
            $sortColumn = 'users.name';
        }

        // Apply sorting to the query
        return $query->orderBy($sortColumn, $sortOrder);



    }
}
