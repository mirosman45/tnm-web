@extends('layout')

@section('title', isset($event) ? 'Edit Event' : 'Add Event')

@section('content')
<div style="max-width:700px;margin:50px auto; padding:20px; background:rgba(255,255,255,0.05); border-radius:12px; box-shadow:var(--shadow-md);">

    <h1 style="font-size:2rem; margin-bottom:20px;">{{ isset($event) ? 'Edit Event' : 'Add Event' }}</h1>

    <form action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($event))
            @method('PUT')
        @endif

        <div style="margin-bottom:15px;">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required style="width:100%; padding:8px; border-radius:var(--radius); border:1px solid var(--border);">
        </div>

        <div style="margin-bottom:15px;">
            <label>Description</label>
            <textarea name="description" rows="5" required style="width:100%; padding:8px; border-radius:var(--radius); border:1px solid var(--border);">{{ old('description', $event->description ?? '') }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label>Event Date</label>
            <input type="datetime-local" name="event_date" value="{{ old('event_date', isset($event) ? \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') : '') }}" required style="width:100%; padding:8px; border-radius:var(--radius); border:1px solid var(--border);">
        </div>

        <div style="margin-bottom:15px;">
            <label>Status</label>
            <select name="status" required style="width:100%; padding:8px; border-radius:var(--radius); border:1px solid var(--border);">
                <option value="published" {{ (old('status', $event->status ?? '')=='published')?'selected':'' }}>Published</option>
                <option value="draft" {{ (old('status', $event->status ?? '')=='draft')?'selected':'' }}>Draft</option>
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label>Image (optional)</label>
            <input type="file" name="image">
            @if(isset($event) && $event->image)
                <div style="margin-top:10px;">
                    <img src="{{ asset('storage/' . $event->image) }}" style="max-width:200px; border-radius:8px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn-plain">{{ isset($event) ? 'Update Event' : 'Add Event' }}</button>
    </form>
</div>
@endsection
