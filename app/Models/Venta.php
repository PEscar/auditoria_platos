<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Venta extends Model
{
	use Notifiable;

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->client_email;
    }

	// RELATIONS

	public function venta_productos()
	{
		return $this->hasMany(VentaProducto::class);
	}

	// END RELATIONS

    public function tieneGiftcards()
    {
        $tiene = false;

        foreach ($this->venta_productos as $key => $ventaProducto) {
            
            if ( $ventaProducto->tipo_producto == 1 )
            {
                $tiene = true;
            }
        }

        return $tiene;
    }

    // Método que importa una orden desde tienda nube, a partir de su ID.
    // Si la venta contiene giftcards, les genera un codigo y fecha de vencimient oa cada una. el tiemp ode validez es configurable
    // desde .env
    public static function importOrderFromTiendaNubeById($order_id)
    {
        $skus_gift_cards = ['11248', '11251'];

        $api = new \TiendaNube\API(1222005, env('TIENDA_NUBE_ACCESS_TOKEN', null), 'La Parolaccia (comercial@fscarg.com)');
        $order = $api->get("orders/" . $order_id);

        $venta = new Venta;
        $venta->external_id = $order->body->id;
        $venta->date = date('Y-m-d H:i:s', strtotime($order->body->created_at));
        $venta->source_id = 0; // Tienda Nube
        $venta->pagada = $order->body->payment_status == 'paid' ? true : false;
        $venta->client_email = $order->body->customer->email;
        $venta->save();

        // Save products
        foreach ($order->body->products as $key => $orderProduct) {
            
            $ventaProducto = new VentaProducto;
            $ventaProducto->sku = $orderProduct->sku;
            $ventaProducto->descripcion = $orderProduct->name;
            $ventaProducto->cantidad = $orderProduct->quantity;

            $ventaProducto->tipo_producto = 0;
            if ( in_array($ventaProducto->sku, $skus_gift_cards) )
            {
                $ventaProducto->tipo_producto = 1; // Gift Card
                $ventaProducto->fecha_vencimiento = \Illuminate\Support\Carbon::now()->addDays(env('VENCIMIENTO_GIFT_CARDS', 30))->toDate();
                $ventaProducto->codigo_gift_card = \Str::uuid();
            }

            $venta->venta_productos()->save($ventaProducto);
        }

        return $venta;
    }
}
