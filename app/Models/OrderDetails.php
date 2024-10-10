<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\isEmpty;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'market_price',
        'quoted_kg',
        'real_kg',
        'basket_qty',
        'grade'
    ];

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function getGradeOptions($productOption)
    {
        return collect(explode(',', Product::where('id', $productOption)->first('grade_list')?->grade_list))
        ->mapWithKeys(fn ($grade) => [$grade => $grade])
        ->toArray();
    }
}
