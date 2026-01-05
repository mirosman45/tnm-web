@extends('admin.layout')

@section('content')
    <h1>{{ __('messages.manage_users') }}</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.role') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.changeRole', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="role" onchange="this.form.submit()">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>{{ __('messages.user') }}</option>
                                <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>{{ __('messages.editor') }}</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('messages.admin') }}</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">{{ $user->blocked ? __('messages.blocked') : __('messages.active') }}</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete_user') }}')">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection