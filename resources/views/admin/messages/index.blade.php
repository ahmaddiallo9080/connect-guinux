@extends('layouts.admin')
@section('title', 'Messages')

@section('content')
<div class="topline">
    <div><h1>Messages</h1><p>Demandes reçues via le formulaire de contact.</p></div>
</div>

<div class="card">
    @if($messages->isEmpty())
        <div class="empty">@include('partials.icon', ['name' => 'message'])<p>Aucun message pour le moment.</p></div>
    @else
    <div class="table-wrap">
        <table>
            <thead><tr><th>Expéditeur</th><th>Sujet</th><th class="hide-sm">Reçu</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
            @foreach($messages as $m)
                <tr class="{{ $m->read_at ? '' : 'unread' }}">
                    <td><a href="{{ route('admin.messages.show', $m) }}" style="color:inherit">{{ $m->name }}</a><br><small style="color:var(--muted);font-weight:400">{{ $m->phone ?: $m->email }}</small></td>
                    <td>{{ $m->subject ?: '—' }}<br><small style="color:var(--muted);font-weight:400">{{ \Illuminate\Support\Str::limit($m->body, 70) }}</small></td>
                    <td class="hide-sm" style="white-space:nowrap">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="actions">
                            <a class="icon-btn" href="{{ route('admin.messages.show', $m) }}" title="Lire">@include('partials.icon', ['name' => 'eye'])</a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" data-confirm="Supprimer le message de {{ $m->name }} ?">
                                @csrf @method('DELETE')
                                <button class="icon-btn icon-btn--danger" title="Supprimer">@include('partials.icon', ['name' => 'trash'])</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $messages->links() }}
    @endif
</div>
@endsection
