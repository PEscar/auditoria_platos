<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
	protected $table = 'venta_producto';

    public static function findGiftCardByCodigo($codigo)
    {
    	return self::where('codigo', $codigo)->first();
    }

    // SCOPES

    public function scopeGiftCards($query)
    {
    	return $query->whereNotNull('codigo_gift_card');
    }

    // END SCOPES

    // ACCESORS

    public function getValidaAttribute()
    {
        return $this->tipo_producto == 1 && $this->fecha_vencimiento >= date('Y-m-d') && $this->fecha_canje == null;
    }

    // END ACCESORS

    // RELATIONS

    public function entregadoPor()
    {
        return $this->belongsTo(User::class, 'entrega_id', 'id');
    }

    // END RELATIONS
}
