@extends('layouts.admin')

@section('title', 'Edit Event: ' . $event->title)

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Edit Event: {{ $event->title }}</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="title">Event Title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="status">Status *</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="date">Date *</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="time">Time (optional)</label>
                    <input type="time" name="time" id="time" class="form-control" value="{{ old('time', $event->time ? substr($event->time, 0, 5) : '') }}">
                    @error('time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="location">Location *</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" required>
                    @error('location')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="venue">Venue (optional)</label>
                    <input type="text" name="venue" id="venue" class="form-control" value="{{ old('venue', $event->venue) }}">
                    @error('venue')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Short Description *</label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="full_description">Full Description (optional)</label>
                <textarea name="full_description" id="full_description" class="form-control" rows="6">{{ old('full_description', $event->full_description) }}</textarea>
                @error('full_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="organizer">Organizer (optional)</label>
                    <input type="text" name="organizer" id="organizer" class="form-control" value="{{ old('organizer', $event->organizer) }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="contact_email">Contact Email (optional)</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $event->contact_email) }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="contact_phone">Contact Phone (optional)</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $event->contact_phone) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="website">Website URL (optional)</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $event->website) }}">
            </div>

            <div class="form-group">
                <label for="image">Event Image (optional)</label>
                @if($event->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($event->image) }}" alt="Current image" style="max-width: 200px; border-radius: 8px;">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input">
                            <label for="remove_image" class="form-check-label">Remove current image</label>
                        </div>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                <small class="text-muted">Leave empty to keep current image</small>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="speakers">Speakers (optional)</label>
                <div id="speakers-container">
                    @php
                        $speakers = old('speakers', $event->speakers ?? []);
                    @endphp
                    @if(!empty($speakers))
                        @foreach($speakers as $speaker