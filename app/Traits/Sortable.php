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

    public function applySortingInvestors($query, Request $request, $defaultSortBy = 'name', $defaultOrder = 'asc')
    {
        // Get sorting parameters from the request
        $sortBy = $request->input('sort_by', $defaultSortBy);
        $sortOrder = $request->input('order', $defaultOrder);

        // Validate sort order
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        // Validate sort field
        if (!in_array($sortBy, ['name', 'amount'])) {
            $sortBy = $defaultSortBy; // Fallback to default sorting
        }

        // Apply sorting logic
        return $query->orderBy($sortBy === 'amount' ? 'investments.amount' : 'users.name', $sortOrder);
    }
}
