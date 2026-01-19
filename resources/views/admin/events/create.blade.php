@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Create New Event</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="title">Event Title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="status">Status *</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="date">Date *</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="time">Time (optional)</label>
                    <input type="time" name="time" id="time" class="form-control" value="{{ old('time') }}">
                    @error('time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="location">Location *</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
                    @error('location')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="venue">Venue (optional)</label>
                    <input type="text" name="venue" id="venue" class="form-control" value="{{ old('venue') }}">
                    @error('venue')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Short Description *</label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                <small class="text-muted">This will appear on the events listing page.</small>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="full_description">Full Description (optional)</label>
                <textarea name="full_description" id="full_description" class="form-control" rows="6">{{ old('full_description') }}</textarea>
                <small class="text-muted">This will appear on the event details page.</small>
                @error('full_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="organizer">Organizer (optional)</label>
                    <input type="text" name="organizer" id="organizer" class="form-control" value="{{ old('organizer') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="contact_email">Contact Email (optional)</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="contact_phone">Contact Phone (optional)</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="website">Website URL (optional)</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}">
            </div>

            <div class="form-group">
                <label for="image">Event Image (optional)</label>
                <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                <small class="text-muted">Max size: 2MB. Supported formats: jpeg, png, jpg, gif</small>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="speakers">Speakers (optional)</label>
                <div id="speakers-container">
                    @if(old('speakers'))
                        @foreach(old('speakers') as $speaker)
                            <div class="input-group mb-2">
                                <input type="text" name="speakers[]" class="form-control" value="{{ $speaker }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-speaker">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" id="add-speaker" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-plus"></i> Add Speaker
                </button>
            </div>

            <div class="form-group">
                <label for="agenda">Event Agenda (optional)</label>
                <div id="agenda-container">
                    @if(old('agenda'))
                        @foreach(old('agenda') as $index => $item)
                            <div class="agenda-item mb-3 p-3 border rounded">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Time</label>
                                        <input type="text" name="agenda[{{ $index }}][time]" class="form-control" value="{{ $item['time'] ?? '' }}" placeholder="e.g., 10:00 AM">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>Activity</label>
                                        <input type="text" name="agenda[{{ $index }}][activity]" class="form-control" value="{{ $item['activity'] ?? '' }}" placeholder="e.g., Registration & Welcome Coffee">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger remove-agenda w-100">×</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" id="add-agenda" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-plus"></i> Add Agenda Item
                </button>
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Add speaker field
    document.getElementById('add-speaker').addEventListener('click', function() {
        const container = document.getElementById('speakers-container');
        const index = container.children.length;
        const html = `
            <div class="input-group mb-2">
                <input type="text" name="speakers[]" class="form-control" placeholder="Speaker name">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-speaker">Remove</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    // Remove speaker field
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-speaker')) {
            e.target.closest('.input-group').remove();
        }
    });

    // Add agenda field
    document.getElementById('add-agenda').addEventListener('click', function() {
        const container = document.getElementById('agenda-container');
        const index = container.children.length;
        const html = `
            <div class="agenda-item mb-3 p-3 border rounded">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Time</label>
                        <input type="text" name="agenda[${index}][time]" class="form-control" placeholder="e.g., 10:00 AM">
                    </div>
                    <div class="form-group col-md-8">
                        <label>Activity</label>
                        <input type="text" name="agenda[${index}][activity]" class="form-control" placeholder="e.g., Registration & Welcome Coffee">
                    </div>
                    <div class="form-group col-md-1">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger remove-agenda w-100">×</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    // Remove agenda field
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-agenda')) {
            e.target.closest('.agenda-item').remove();
        }
    });

    // Set minimum date to today
    document.getElementById('date').min = new Date().toISOString().split('T')[0];
</script>
@endsection