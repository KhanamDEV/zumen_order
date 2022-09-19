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
<p class="info"><span>納品日</span>: {{ !empty($order->project->importunate) ? '3日以内' : @$order->project->delivery_date}}
</p>
<p class="info"><span>納期相談希望</span>: {{!empty($order->project->importunate) ? 'はい' : 'いいえ'}}</p>
<p class="info"><span>備考</span>: {{@$order->project->note}} </p>
@php $information = json_decode($order->project->other_information)  @endphp
@if(!empty($information) && !$mailFeedback)
    <p class="info"><span>図面情報</span>:
    <ul>
        @foreach($information as $value)
            <li>{{config('project.other_information')[$value]}}</li>
        @endforeach
    </ul>
    </p>
@endif
@php $documentUser = json_decode($order->project->documents) @endphp
@if(!empty($documentUser))
    <p class="info"><span>Documents:</span>
    <ul>
        @foreach($documentUser as $key => $value)
            <li><a target="_blank" href="http://zumen-order.com/public{{$value->path}}">{{$value->name}}</a></li>
        @endforeach
    </ul>
@endif
@php $documentWorker = !empty($order->documents) ?  json_decode($order->documents) : []; @endphp
@if(!empty($documentWorker))
    <p class="info"><span>Documents of Worker:</span>
    <ul>
        @foreach($documentWorker as $key => $value)
            <li><a target="_blank" href="http://zumen-order.com/public{{$value->path}}">{{$value->name}}</a></li>
        @endforeach
    </ul>
@endif
<br>
<p>▽「案件受付」こちら: </p>
@if($type == 'worker')
    <a href="{{route('worker.project.show', ['id' => $order->project->id])}}">{{route('worker.project.show', ['id' => $order->project->id])}}</a>
@endif
@if($type == 'admin')
    <a href="{{route('admin.project.show', ['id' => $order->project->id])}}">{{route('admin.project.show', ['id' => $order->project->id])}}</a>
@endif
@if($type == 'user')
    <a href="{{route('user.project.show', ['id' => $order->project->id])}}">{{route('user.project.show', ['id' => $order->project->id])}}</a>
@endif
