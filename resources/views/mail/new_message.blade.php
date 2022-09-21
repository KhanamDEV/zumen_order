<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 28/05/2022
 * Time: 22:55
 */
?>
<p class="info"><span>内容</span>: {{$chat->content}}</p>
@php
    $documents = json_decode($chat->documents);
    @endphp
@if(!empty($documents))
    <p class="info"><span>Documents:</span>
    <ul>
        @foreach($documents as $key => $value)
            <li><a target="_blank" href="http://zumen-order.com/public{{$value->path}}">{{$value->name}}</a></li>
        @endforeach
    </ul>
@endif
<br>
<p>▽「案件受付」こちら: </p>
@if($type == 'worker')
    <a href="{{route('worker.order.show', ['id' => $order->id])}}">{{route('worker.order.show', ['id' => $order->id])}}</a>
@endif
@if($type == 'user')
    <a href="{{route('user.project.show', ['id' => $order->project->id])}}">{{route('user.project.show', ['id' => $order->project->id])}}</a>
@endif
