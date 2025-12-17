<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function getActivePaginated(Request $request)
    {
        $limit = max(1, min((int) $request->query('limit', 10), 100));
        $offset = max(0, (int) $request->query('offset', 0));

        $campaigns = Campaign::where('is_active', true)
            ->skip($offset)
            ->take($limit)
            ->get();

        $data = $campaigns->map(function ($c) {
            return $c->toArray();
        });

        return response()->json([
            'status' => 200,
            'data' => $data,
            'meta' => [
                'limit' => $limit,
                'offset' => $offset,
                'count' => $data->count(),
            ],
        ]);
    }
}
