<?php
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};
name('app.login');

use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Models\Siswa;
new class extends Component {
    use WithPagination;
    public $message,
        $search = '';
    public $username, $password ='';
    public $showModal,
        $data_id,
        $showConfirmModal,
        $showSuccessModal,
        $showError,
        $showDeleteButton = false;
    //
    public function login(){
        $username = ($this->username);
        $password = ($this->password);
        $input = Siswa::with('getKelas')->with('getJurusan')->where('username',$username)
                        ->where('password',$password)
                        ->first();
        // dd($input);
        if($input){
            session(['siswa' => $input]);
            return redirect(route('app.dashboard'));
        }else{
            $this->showError = true;
            $this->message = "Username atau password salah";
        }
    }
};
?>
<x-layouts.app.login>
    @volt
        <div>
            <div class="h-14 bg-linear-to-r from-sky-800 to-blue-400 h-50 bg-[url({{ asset('header-bg.jpg') }})]">
                <div class="grid justify-center pt-10">
                    <h3 class="text-white text-3xl font-semibold">UJIAN ONLINE</h3>
                </div>

            </div>
            <div class="bg-muted flex flex-col items-center justify-center gap-6 p-6 md:p-10">
                <div class="flex -mt-50 w-full max-w-md flex-col gap-6">
                    <div class="flex flex-col gap-6">
                        <div
                            class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 text-stone-800 shadow-xs  mt-15">
                            <div class="mt-10 mx-10 ">
                            <h3 class="font-bold text-4xl">Selamat datang,</h3>
                            <h4>Silahkan login dengan username dan password yang telah anda miliki.</h4>
                        </div>
                                <div class="p-10">
                                    <div class="{{ !$showError ? 'hidden' : '' }} mb-2">
                                    <flux:callout variant="danger" icon="x-circle" heading="{{ $message }}" />
                                </div>
                                    <form wire:submit="login" class="flex flex-col gap-6">
                                        @csrf
                                        <!-- Email Address -->
                                        <flux:input icon="user" wire:model="username" :label="__('Username')" type="text"
                                            name="username" required autofocus autocomplete="username"
                                            placeholder="Username" />

                                        <!-- Password -->
                                        <div class="relative">
                                            <flux:input icon="key" viewable wire:model="password" :label="__('Password')" type="password"
                                                name="password" required autocomplete="current-password"
                                                placeholder="Password" />
                                        </div>

                                        <!-- Remember Me -->

                                        <div class="flex items-center justify-end">
                                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}
                                            </flux:button>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-layouts.app.login>
