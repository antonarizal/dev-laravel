<?php
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};
middleware(['auth', 'verified','adminAuth']);
name('admin.users');
use Livewire\WithPagination;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
new class extends Component {
    use WithPagination;
    public $id,
        $name,
        $email,
        $phone,
        $password,
        $message,
        $search = '';
    public $showModal,
        $data_id,
        $showConfirmModal,
        $showSuccessModal,
        $showDeleteButton = false;
    public $showCheckAll = true;
    public $limit = 10;
    public $selected = [];
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $column = [['name' => 'ID', 'field' => 'id'], ['name' => 'Name', 'field' => 'name'], ['name' => 'Email', 'field' => 'email'], ['name' => 'Phone', 'field' => 'phone']];
    public function with(): array
    {
        $limit = $this->limit == null ? 10 : $this->limit;
        $sortField = $this->sortField;
        $sortDirection = $this->sortDirection;
        $data = $this->search == null ? User::orderBy($sortField, $sortDirection) : User::where('name', 'like', '%' . $this->search . '%')->orderBy($sortField, $sortDirection);
        $data = $data->paginate($limit);
        return [
            'results' => $data,
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
    public function save()
    {
        $validated = [];
        $submit = DB::transaction(function () use ($validated) {
            if ($this->data_id) {
                $validated = $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                ]);
                User::find($this->data_id)->update($validated);
            } else {
                $validated = $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                    'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
                ]);
                $validated['password'] = Hash::make($this->password);
                User::create($validated);
            }
            return true;
        });
        if ($submit) {
            $this->reset();
            $this->message = 'Data berhasil disimpan';
            $this->showSuccessModal = true;
        }
    }
    public function edit($id)
    {
        $this->reset();
        $user = User::find($id);
        $this->showModal = true;
        $this->data_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }
    public function confirmDelete($id)
    {
        $this->showConfirmModal = true;
        $this->data_id = $id;
    }
    public function delete($id = null)
    {
        $id = $id ?? $this->data_id;
        $user = User::find($id);
        if ($user->delete()) {
            $this->toastr = true;
            $this->message = 'Data berhasil dihapus';
            $this->showConfirmModal = false;
            $this->showSuccessModal = true;
            $this->data_id = null;
        }
    }
    public function selectAll()
    {
        $data = $this->selected;
        $this->showDeleteButton = count($data) > 0 ? true : false;
    }
    public function deleteSelected()
    {
        $data = count($this->selected);
        if ($data > 0) {
            User::whereIn('id', $this->selected)->delete();
            $this->selected = [];
            $this->message = 'Data berhasil dihapus';
            $this->showSuccessModal = true;
        }
    }
};
?>
<x-layouts.admin>
    <div class="mb-3">
        <flux:ui.breadcrumb :links="[['url' => '#', 'label' => 'Admin'], ['label' => 'Users']]" />
    </div>
    @volt
        <div>
            <flux:ui.table.toolbar :showDeleteButton="$showDeleteButton" :showCreateButton=true />
                <flux:ui.table :showCheckAll="$showCheckAll" :message="$message" :results="$results">
                    <x-slot name="columns">
                        @foreach ($column as $col)
                            <flux:ui.table.column :label="$col['name']" :field="$col['field']" :sortField="$sortField" :sortDirection="$sortDirection"
                                :sortable=true />
                        @endforeach
                        <flux:ui.table.column label="Action" />
                    </x-slot>
                    <x-slot name="rows">
                        @foreach ($results as $row)
                            <flux:ui.table.row :id="$row->id">
                                @if ($showCheckAll)
                                    <flux:ui.table.cell :showCheckBox=true :id="$row->id"></flux:ui.table.cell>
                                @endif
                                <flux:ui.table.cell>{{ $row->id }}</flux:ui.table.cell>
                                <flux:ui.table.cell>{{ $row->name }}</flux:ui.table.cell>
                                <flux:ui.table.cell>{{ $row->email }}</flux:ui.table.cell>
                                <flux:ui.table.cell>{{ $row->phone }}</flux:ui.table.cell>
                                <flux:ui.table.cell>
                                    <flux:ui.table.button.action :id="$row->id" :showDetail=false>

                                    </flux:ui.table.button.action>
                                </flux:ui.table.cell>
                            </flux:ui.table.row>
                        @endforeach
                    </x-slot>
                </flux:ui.table>

            <flux:modal wire:model.self="showModal" variant="flyout">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Edit User</flux:heading>
                    </div>
                    <flux:input type="hidden" placeholder="ID" wire:model="data_id" />
                    <flux:input label="Name" placeholder="Name" wire:model="name" />
                    <flux:input label="Email" placeholder="Email" wire:model="email" />
                    <flux:input label="Phone" placeholder="Phone" wire:model="phone" />
                    <flux:input label="Password" placeholder="Password" type="password" viewable wire:model="password" />
                    <div class="flex">
                        <flux:spacer />
                        <flux:button variant="primary" wire:click="save">Save changes</flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
    @endvolt
</x-layouts.admin>
