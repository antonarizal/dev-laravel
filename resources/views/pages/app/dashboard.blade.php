<?php
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};
name('app.dashboard');
// middleware(['appAuth']);

use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Models\Ujian;

new class extends Component {
    use WithPagination;
    public $message,
        $search = '';
    public $showModal,
        $data_id,
        $showConfirmModal,
        $showSuccessModal,
        $showDeleteButton = false;
    public $showCheckAll = false;
    public $searchField = 'name';
    public $limit = 10;
    public $selected = [];
    public $sortField = 'id';
    public $sortDirection = 'asc';
    //
    public $id = '';
    public $kode_ujian = '';
    public $id_soal = '';
    public $kelas = '';
    public $jurusan = '';
    public $tanggal = '';
    public $waktu_mulai = '';
    public $waktu_selesai = '';
    public $durasi = '';
    public $status = '';
    public $sesi = '';
    public $columns = [
        ['label' => 'ID', 'name' => 'id', 'type' => 'number', 'typeData' => 'int'],
        // ['label'=>'Kode Ujian',	'name'=>'kode_ujian',	 'type'=>'text',	'typeData'=>'varchar'],
        ['label' => 'Mapel', 'name' => 'id_soal', 'type' => 'number', 'typeData' => 'int'],
        ['label' => 'Sesi', 'name' => 'sesi', 'type' => 'number', 'typeData' => 'int'],
        ['label' => 'Kelas', 'name' => 'kelas', 'type' => 'number', 'typeData' => 'int'],
        ['label' => 'Jurusan', 'name' => 'jurusan', 'type' => 'number', 'typeData' => 'int'],
        ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'typeData' => 'date'],
        ['label' => 'Waktu Mulai', 'name' => 'waktu_mulai', 'type' => 'time', 'typeData' => 'time'],
        ['label' => 'Waktu Selesai', 'name' => 'waktu_selesai', 'type' => 'time', 'typeData' => 'time'],
        // ['label'=>'Durasi',	'name'=>'durasi',	 'type'=>'number',	'typeData'=>'int'],
        // ['label'=>'Status',	'name'=>'status',	 'type'=>'number',	'typeData'=>'int'],
    ];
    public function boot(){
        if(empty(session('siswa'))){
            $this->redirect(url('app/logout'));

        }

    }
    public function with(): array
    {

        $limit = $this->limit == null ? 10 : $this->limit;
        $sortField = $this->sortField;
        $sortDirection = $this->sortDirection;
        $data = Ujian::where('tanggal', date('Y-m-d'))->orderBy($sortField, $sortDirection);
        $data = $data->paginate($limit);
        return [
            'results' => $data,
            'siswa'=>session('siswa')

        ];
    }
    public function sortBy($field)
    {
        $this->sortField = $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
    public function create()
    {
        $this->reset();
        $this->showModal = true;
    }
};
?>
<x-layouts.app>
    @volt
        <div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 lg:px-30">

                    <flux:callout icon="sparkles" color="purple">
                        <flux:callout.heading>Selamat datang di aplikasi CBT</flux:callout.heading>

                        <flux:callout.text>
                            Try our new AI assistant, Jeffrey. Let him handle tasks and answer questions for you.
                            <flux:callout.link href="#">Learn more</flux:callout.link>
                        </flux:callout.text>
                    </flux:callout>
                    <div class="mt-4">

                        <flux:ui.table :showCheckAll="false" :message="$message" :results="$results">
                            <x-slot name="columns">
                            </x-slot>
                            <x-slot name="rows">
                                    <flux:ui.table.row>
                                        <flux:ui.table.cell style="width:150px">Nama</flux:ui.table.cell>
                                        <flux:ui.table.cell style="width:30px">:</flux:ui.table.cell>
                                        <flux:ui.table.cell>{{ session('siswa')['nama'] }}</flux:ui.table.cell>
                                    </flux:ui.table.row>
                                    <flux:ui.table.row>
                                        <flux:ui.table.cell>Kelas</flux:ui.table.cell>
                                        <flux:ui.table.cell style="width:30px">:</flux:ui.table.cell>
                                        <flux:ui.table.cell> {{ $siswa->getKelas->nama_kelas }}</flux:ui.table.cell>
                                    </flux:ui.table.row>
                                    <flux:ui.table.row>
                                        <flux:ui.table.cell>Jurusan</flux:ui.table.cell>
                                        <flux:ui.table.cell style="width:30px">:</flux:ui.table.cell>
                                        <flux:ui.table.cell> {{ $siswa->getJurusan->nama_jurusan }}</flux:ui.table.cell>
                                    </flux:ui.table.row>
                            </x-slot>
                        </flux:ui.table>

                    </div>
                    <h4 class="p-3">Ujian Tanggal {{ date('d/m/Y') }}</h4>
                    <flux:ui.table :showCheckAll="$showCheckAll" :message="$message" :results="$results">
                        <x-slot name="columns">
                            @foreach ($columns as $col)
                                <flux:ui.table.column :label="$col['label']" :field="$col['name']" :sortField="$sortField"
                                    :sortDirection="$sortDirection" :sortable=true />
                            @endforeach
                            <flux:ui.table.column label="Action" style="width:200px" />
                        </x-slot>
                        <x-slot name="rows">
                            @foreach ($results as $row)
                                <flux:ui.table.row :id="$row->id">
                                    <flux:ui.table.cell>{{ $row->id }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>
                                        <a class="text-blue-600 hover:text-blue-400" href="{{ url('app/pdf/' . $row->id) }}"
                                            wire:navigate>{{ $row->soal->mapel }}</a>
                                    </flux:ui.table.cell>
                                    <flux:ui.table.cell>{{ $row->sesi }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>{{ $row->getKelas->nama_kelas }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>{{ $row->getJurusan->nama_jurusan }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>{{ $row->tanggal }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>{{ $row->waktu_mulai }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>{{ $row->waktu_selesai }}</flux:ui.table.cell>
                                    <flux:ui.table.cell>
                                        <flux:button size="sm" variant="primary" href="{{ url('app/pdf/' . $row->id) }}"
                                            icon-trailing="arrow-right" wire:navigate>Mulai</flux:button>
                                    </flux:ui.table.cell>
                                </flux:ui.table.row>
                            @endforeach
                        </x-slot>
                    </flux:ui.table>

                </div>
                {{-- <div class="col-span-0">
            <flux:ui.card></flux:ui.card>
        </div> --}}
            </div>
        </div>
    @endvolt
</x-layouts.app>
