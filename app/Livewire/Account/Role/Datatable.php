<?php

namespace App\Livewire\Account\Role;

use App\Helpers\Alert;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Permissions\PermissionHelper;
use App\Permissions\AccessAccount;
use App\Traits\Livewire\WithDatatable;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Account\RoleRepository;
use App\Repositories\Account\UserRepository;

class Datatable extends Component
{
    use WithDatatable;

    public $isCanUpdate;
    public $isCanDelete;

    // Delete Dialog
    public $targetDeleteId;

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(AccessAccount::ROLE, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(AccessAccount::ROLE, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        RoleRepository::delete($this->targetDeleteId);
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
    }

    #[On('on-delete-dialog-cancel')]
    public function onDialogDeleteCancel()
    {
        $this->targetDeleteId = null;
    }

    public function showDeleteDialog($id)
    {
        $this->targetDeleteId = $id;

        Alert::confirmation(
            $this,
            Alert::ICON_QUESTION,
            "Hapus Data",
            "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            "on-delete-dialog-confirm",
            "on-delete-dialog-cancel",
            "Hapus",
            "Batal",
        );
    }


    public function getColumns(): array
    {
        return [
            [
                'name' => 'Aksi',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {

                    $editHtml = "";
                    if ($this->isCanUpdate) {
                        $editUrl = route('role.edit', $item->id);
                        $editHtml = "<div class='col-auto mb-2'>
                            <a class='btn btn-primary btn-sm' href='$editUrl'>
                                <i class='ki-duotone ki-notepad-edit fs-1'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                </i>
                                Ubah
                            </a>
                        </div>";
                    }

                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto mb-2'>
                            <button class='btn btn-danger btn-sm m-0' 
                                wire:click=\"showDeleteDialog($item->id)\">
                                <i class='ki-duotone ki-trash fs-1'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                    <span class='path3'></span>
                                    <span class='path4'></span>
                                    <span class='path5'></span>
                                </i>
                                Hapus
                            </button>
                        </div>";
                    }

                    $html = "<div class='row'>
                        $editHtml $destroyHtml 
                    </div>";

                    return $html;
                },
            ],
            [
                'key' => 'name',
                'name' => 'Nama',
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Akses',
                'render' => function ($item) {
                    $html = "<ul class='list-group list-group-flush'>";
                    foreach ($item->permissions->take(5) as $permission) {
                        $translatedName = PermissionHelper::translate($permission->name);
                        $html .= "<li class='list-group-item'>$translatedName</li>";
                    }
                    if($item->permissions->count() > 5)
                    {
                        $html .= "<li class='list-group-item text-danger'>Dan masih banyak lagi</li>";
                    }
                    if(!$item->permissions->count())
                    {
                        $html .= "<li class='list-group-item text-danger'>Tidak memiliki akses</li>";
                    }
                    $html .= "</ul>";
                    return $html;
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return RoleRepository::datatable();
    }

    public function getView(): string
    {
        return 'livewire.account.role.datatable';
    }
}
