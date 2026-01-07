@extends('layout')

@section('title', __('messages.contact'))

@section('content')
    <div style="max-width: 600px; margin: 40px auto;">
        <h1>📧 {{ __('messages.contact_us') }}</h1>
        <p style="font-size: 1.1rem; margin-bottom: 30px;">{{ __('messages.get_in_touch') }}</p>

        {{-- social bar --}}
        <div style="display: flex; gap: 1rem; margin-bottom: 30px;">
            <a href="#" aria-label="Facebook" style="color: var(--text); font-size: 1.5rem;"><i
                    class="fab fa-facebook"></i></a>
            <a href="#" aria-label="Twitter" style="color: var(--text); font-size: 1.5rem;"><i
                    class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram" style="color: var(--text); font-size: 1.5rem;"><i
                    class="fab fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn" style="color: var(--text); font-size: 1.5rem;"><i
                    class="fab fa-linkedin"></i></a>
            <a href="#" aria-label="YouTube" style="color: var(--text); font-size: 1.5rem;"><i
                    class="fab fa-youtube"></i></a>
            <a href="#" aria-label="Telegram" style="color: var(--text); font-size: 1.5rem;"><i
                    class="fab fa-telegram"></i></a>
        </div>

        <div
            style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 30px; box-shadow: var(--shadow-md);">
            <form style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label
                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text);">{{ __('messages.your_name') }}</label>
                    <input type="text" required
                        style="width: 100%; padding: 10px; border: 2px solid var(--border); border-radius: var(--radius); font-size: 1rem;" />
                </div>

                <div>
                    <label
                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text);">{{ __('messages.your_email') }}</label>
                    <input type="email" required
                        style="width: 100%; padding: 10px; border: 2px solid var(--border); border-radius: var(--radius); font-size: 1rem;" />
                </div>

                <div>
                    <label
                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text);">{{ __('messages.message') }}</label>
                    <textarea required rows="5"
                        style="width: 100%; padding: 10px; border: 2px solid var(--border); border-radius: var(--radius); font-size: 1rem; font-family: inherit;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary"
                    style="align-self: flex-start;">{{ __('messages.send_message') }}</button>
            </form>
        </div>
    </div>
@endsection