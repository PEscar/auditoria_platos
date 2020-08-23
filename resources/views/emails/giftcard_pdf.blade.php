@extends('layouts.onlycss')

@section('content')
<div class="thumbnail">
  <img src="{{ asset('img/giftcard2.jpeg') }}">
  <div class="caption caption-producto">
      <p>{{ $item->descripcion }}</p>
  </div>
  <div class="caption caption-vencimiento">
      <p>{{ strtoupper(date('d/M/Y', strtotime( $notifiable->fecha_vencimiento ))) }}</p>
  </div>
  <div class="caption caption-codigo">
      <p>{{ $item->codigo_gift_card }}</p>
  </div>
  <div class="caption caption-qr">
    <!-- <p>{{$qr_code}}</p> -->
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(200)->generate(route('giftcards.show', ['codigo' => $item->codigo_gift_card]))) !!} ">
  </div>
</div>