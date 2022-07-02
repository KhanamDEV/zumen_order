<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 28/05/2022
 * Time: 22:55
 */
?>
<p class="info"><span>発注者</span>: {{@$order->project->user->first_name}} {{@$order->project->user->last_name}}</p>
<p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($order->project->created_at))}}</p>
<p class="info"><span>現場名</span>: {{@$order->project->owner}}</p>
<p class="info"><span>現場住所</span>: {{@$order->project->name}}</p>
<p class="info"><span>図面種類</span>: {{config('project.type')[$order->project->type]}}</p>
<p class="info"><span>ステータス</span>: {{config('project.status')[$order->status]}}</p>
<p class="info"><span>納品日</span>: {{ !empty($order->project->importunate) ? '3日以内' : @$order->project->delivery_date}}</p>
<p class="info"><span>納期相談希望</span>: {{!empty($order->project->importunate) ? 'はい' : 'いいえ'}}</p>
<p class="info"><span>備考</span>: {{@$order->project->note}} </p>
@php $information = json_decode($order->project->other_information)  @endphp
@if(!empty($information))
    <p class="info"><span>図面情報</span>:
    <ul>
        @foreach($information as $value)
            <li>{{config('project.other_information')[$value]}}</li>
        @endforeach
    </ul>
    </p>
@endif
<br>
<p>▽「案件受付」こちら: </p>
@if($type == 'worker')
    <a href="{{route('worker.project.show', ['id' => $order->project->id])}}">{{route('worker.project.show', ['id' => $order->project->id])}}</a>
@endif
@if($type == 'user')
    <a href="{{route('user.project.show', ['id' => $order->project->id])}}">{{route('user.project.show', ['id' => $order->project->id])}}</a>
@endif
