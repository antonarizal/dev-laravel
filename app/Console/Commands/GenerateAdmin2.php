<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateAdmin2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin2 {name : The name of the view file} {--layout= : The layout to use for the view} {--force : Overwrite the view file if it exists} {--table= : Create an inline view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate page in admin';

    /**
     * Execute the console command.
     */
    private function getType($type){
        $types = [
            'string' => 'text',
            'varchar' => 'text',
            'text' => 'textarea',
            'int' => 'number',
            'integer' => 'number',
            'date' => 'date',
            'datetime' => 'datetime-local',
            'time' => 'time',
            'boolean' => 'checkbox',
            'float' => 'number',
            'double' => 'number',
            'decimal' => 'number',
            'timestamp' => 'datetime-local',
            'timestampTz' => 'datetime-local',
            'id' => 'text',
            'bigIncrements' => 'text',
            'bigInteger' => 'number',
            'binary' => 'file',
            'boolean' => 'checkbox',
            'char' => 'text',
            'date' => 'date',
            'dateTime' => 'datetime-local',
            'dateTimeTz' => 'datetime-local',
            'decimal' => 'number',
            'double' => 'number',
            'enum' => 'text',
            'float' => 'number',
            'increments' => 'text',
            'integer' => 'number',
            'mediumInteger' => 'number',
            'mediumText' => 'textarea',
        ];
        return $types[$type];

    }
    public function handle()
    {
              // Get the name of the view
              $name = $this->argument('name');
              $modelName = ucwords($name);
              $dir = explode('.', $name);
              $dir = $dir[0];
              $layout = $this->option('layout') ?: 'layouts.app';

              // Create the file path
              $path = resource_path('views/pages/admin/' . str_replace('.', '/', $name) . '.blade.php');

            //   Check if the file already exists
            if(!$this->option('force'))
              if (File::exists($path)) {
                  $this->error("The view file already exists at {$path}");
                  return;
              }
              // Ensure the directory exists
              File::ensureDirectoryExists(dirname($path));
              if($this->option('table')){
                $cols = Schema::getColumnListing($this->option('table'));
                $i = 0;
                foreach($cols as $col ){
                    $type = $this->getType(Schema::getColumnType($this->option('table'), $col));
                    $typeData = Schema::getColumnType($this->option('table'), $col);

                    if($i!=0){
                        $input[$i] = $i== 1 ?  "\t'". $col ."'=> \$this->".$col."," :   "\t\t\t\t'". $col ."'=> \$this->".$col."," ;
                    }
                  $fields[$i] = $i== 0 ? "\tpublic $". $col ." = '';" : "\t\tpublic $". $col ." = '';";
                  $edit[$i] = $i== 0 ?   "\$this->". $col ." = \$row->". $col .";" : "\t\t\$this->". $col ." = \$row->". $col .";";
                  $column[$i] = $i== 0 ? "\t['label'=>'". Str::headline($col) ."',\t'name'=>'". $col ."',\t'type'=>'".$type."',\t'typeData'=>'".$typeData."']" :
                   "\t\t['label'=>'". Str::headline($col) ."',\t'name'=>'". $col ."',\t 'type'=>'".$type."',\t'typeData'=>'".$typeData."']";
                $inputModal[$i] = "<flux:ui.input.text name=\"{{ \$col['name'] }}\" label=\"{{ \$col['label'] }}\" type=\"{{ \$col['type'] }}\" />";
                  $i++;
                }
                $inputs = implode("\n",$input);
                $inputModals = implode("\n",$inputModal);
                $state = implode("\n",$fields);
                $columns = implode(",\n",$column);
                $edits = implode("\n",$edit);
                // $columns = '[]';
              }else{
                $inputs = '';
                $inputModals = '';
                $state = '';
                $columns = '[]';
                $edits = '';
              }


              // Generate the file content
$content = <<<PHP
<?php
use function Laravel\Folio\\name;
use function Laravel\Folio\{middleware};
middleware(['auth', 'verified','adminAuth']);
name('admin.$name');
use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Models\\$modelName;
new class extends Component {
    use WithPagination;
    public    \$message,
        \$search = '';
    public \$showModal,
        \$data_id,
        \$showConfirmModal,
        \$showSuccessModal,
        \$showDeleteButton = false;
    public \$showCheckAll = true;
    public \$searchField = 'name';
    public \$limit = 10;
    public \$selected = [];
    public \$sortField = 'id';
    public \$sortDirection = 'asc';
    //
    $state
    public \$columns = [
    $columns
    ];
    public function with(): array
    {
        \$limit = \$this->limit == null ? 10 : \$this->limit;
        \$sortField = \$this->sortField;
        \$sortDirection = \$this->sortDirection;
        \$data = \$this->search == null ? $modelName::orderBy(\$sortField,\$sortDirection) : $modelName::where(\$this->searchField, 'like', '%' . \$this->search . '%')->orderBy(\$sortField, \$sortDirection);
        \$data = \$data->paginate(\$limit);
        return [
            'results' => \$data,
        ];
    }
    public function sortBy(\$field)
    {
        \$this->sortField = \$field;
        \$this->sortDirection = \$this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
    public function create()
    {
        \$this->reset();
        \$this->showModal = true;
    }
    public function save()
    {

        \$data = [
              $inputs
        ];
        \$submit = DB::transaction(function () use (\$data) {
            if (\$this->data_id) {
                $modelName::find(\$this->data_id)->update(\$data);
            } else {
                $modelName::create(\$data);
            }
            return true;
        });
        if (\$submit) {
            \$this->reset();
            \$this->message = 'Data berhasil disimpan';
            \$this->showSuccessModal = true;
        }
    }
    public function edit(\$id)
    {
        \$this->reset();
        \$row = $modelName::find(\$id);
        \$this->showModal = true;
        \$this->data_id = \$row->id;
        $edits

    }
    public function confirmDelete(\$id)
    {
        \$this->showConfirmModal = true;
        \$this->data_id = \$id;
    }
    public function delete(\$id = null)
    {
        \$id = \$id ?? \$this->data_id;
        \$data = $modelName::find(\$id);
        if (\$data->delete()) {
            \$this->toastr = true;
            \$this->message = 'Data berhasil dihapus';
            \$this->showConfirmModal = false;
            \$this->showSuccessModal = true;
            \$this->data_id = null;
        }
    }
    public function selectAll()
    {
        \$data = \$this->selected;
        \$this->showDeleteButton = count(\$data) > 0 ? true : false;
    }
    public function deleteSelected()
    {
        \$data = count(\$this->selected);
        if (\$data > 0) {
            $modelName::whereIn('id', \$this->selected)->delete();
            \$this->selected = [];
            \$this->message = 'Data berhasil dihapus';
            \$this->showSuccessModal = true;
        }
    }
};
?>
<x-layouts.admin>
    <div class="mb-3">
        <flux:ui.breadcrumb :links="[['url' => '#', 'label' => 'Admin'], ['label' => '$modelName']]" />
    </div>
    @volt
        <div>

            <flux:modal wire:model.self="showModal" variant="flyout">
                <form wire:submit.prevent="save">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Input Data</flux:heading>
                    </div>
                    <flux:input type="hidden" placeholder="ID" wire:model="data_id" />
                        @foreach (\$columns as \$col)
                            @if (\$col['name'] != 'id')
                                <flux:ui.input.text name="{{ \$col['name'] }}" label="{{ \$col['label'] }}" type="{{ \$col['type'] }}" />
                            @endif
                        @endforeach
                    <div class="flex">
                        <flux:spacer />
                        <flux:button variant="primary" type="submit">Save changes</flux:button>
                    </div>
                </div>
                </form>
            </flux:modal>
            <flux:ui.table.toolbar :showDeleteButton="\$showDeleteButton" :showCreateButton=true />
                <flux:ui.table :showCheckAll="\$showCheckAll" :message="\$message" :results="\$results">
                    <x-slot name="columns">
                        @foreach (\$columns as \$col)
                            <flux:ui.table.column :label="\$col['label']" :field="\$col['name']" :sortField="\$sortField" :sortDirection="\$sortDirection"
                                :sortable=true />
                        @endforeach
                        <flux:ui.table.column label="Action" style="width:200px"/>
                    </x-slot>
                    <x-slot name="rows">
                        @foreach (\$results as \$row)
                            <flux:ui.table.row :id="\$row->id">
                                @if (\$showCheckAll)
                                    <flux:ui.table.cell :showCheckBox=true :id="\$row->id"></flux:ui.table.cell>
                                @endif
                                @foreach(\$columns as \$col)
                                    <flux:ui.table.cell>{{ \$row->{\$col['name']} }}</flux:ui.table.cell>
                                @endforeach
                                <flux:ui.table.cell style="float: right;">
                                    <flux:ui.table.button.action :id="\$row->id" :showDetail=false>
                                    </flux:ui.table.button.action>
                                </flux:ui.table.cell>
                            </flux:ui.table.row>
                        @endforeach
                    </x-slot>
                </flux:ui.table>
        </div>
    @endvolt
</x-layouts.admin>
PHP;


              // Create the file
              File::put($path, $content);
              $this->info("View file created at {$path}");
          }

}
