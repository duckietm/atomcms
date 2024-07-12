<x-app-layout>
    @push('title', __('title.register', ['name' => $settings->get('hotel_name')]))

    <x-form.form route="{{ route('register.store') }}" class="flex flex-col gap-6 bg-gray-100 p-3 rounded-lg dark:bg-gray-950">
        <x-form.input id="username" label="{{ __('form.username') }}" value="{{ old('username') }}" required />
        <x-form.input id="mail" label="{{ __('form.email') }}" value="{{ old('mail') }}" type="email" required />
        <x-form.input id="password" label="{{ __('form.password') }}" type="password" required />
        <x-form.input id="password_confirmation" label="{{ __('form.password_confirmation') }}" type="password" required />
        <x-form.checkbox id="terms" label="{!! __('form.terms', ['name' => $settings->get('hotel_name')]) !!}" required />
        <x-button.primary type="submit">{{ __('buttons.register') }}</x-button.primary>
    </x-form.form>

    <a href="{{ route('login.index') }}" class="flex flex-col">
        <x-button.secondary>{{ __('buttons.account_exists') }}</x-button.primary>
    </a>
</x-app-layout>