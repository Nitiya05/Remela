<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Foto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $fillable = ['dokumentasi_id', 'path'];

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class);
    }
}
