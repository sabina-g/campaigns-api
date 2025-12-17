<?php
// app/Models/Campaign.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';
    public $timestamps = false;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => (bool) $this->is_active,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
        ];
    }
}
