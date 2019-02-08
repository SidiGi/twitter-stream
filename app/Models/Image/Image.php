<?php
declare(strict_types=1);

namespace App\Models\Image;

use App\Models\Content\Content;
use App\Models\Option\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int                 $id
 * @property string              $path
 */
class Image extends Model
{
    protected $guarded = [];
    protected $casts   = [
        'id'          => 'integer',
    ];

    public static function add(string $path)
    {
        Storage::exists($path);

        return self::create([
            'path' => $path
        ]);
    }

    public function content()
    {
        return $this->morphMany(Content::class, 'contentable');
    }
}