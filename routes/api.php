<?php
// routes/api.php
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/campaigns/active-paginated', [CampaignController::class, 'getActivePaginated']);
